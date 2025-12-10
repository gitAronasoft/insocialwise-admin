<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbox_conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->unsignedBigInteger('social_page_id')->nullable();
            $table->string('platform');
            $table->string('platform_conversation_id')->nullable();
            $table->string('participant_id')->nullable();
            $table->string('participant_name')->nullable();
            $table->string('participant_avatar')->nullable();
            $table->text('last_message')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->integer('unread_count')->default(0);
            $table->enum('status', ['open', 'closed', 'archived'])->default('open');
            $table->string('assigned_to')->nullable();
            $table->json('labels')->nullable();
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('social_page_id')->references('id')->on('social_page')->onDelete('set null');
        });

        Schema::create('inbox_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversation_id');
            $table->string('platform_message_id')->nullable();
            $table->enum('direction', ['inbound', 'outbound']);
            $table->text('content');
            $table->json('attachments')->nullable();
            $table->enum('status', ['sent', 'delivered', 'read', 'failed'])->default('sent');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->foreign('conversation_id')->references('id')->on('inbox_conversations')->onDelete('cascade');
        });

        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid')->nullable();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
        });

        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->string('channel');
            $table->string('notification_type');
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->unique(['user_uuid', 'channel', 'notification_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
        Schema::dropIfExists('user_notifications');
        Schema::dropIfExists('notification');
        Schema::dropIfExists('inbox_messages');
        Schema::dropIfExists('inbox_conversations');
    }
};

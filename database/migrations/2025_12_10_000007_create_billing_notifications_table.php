<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('billing_notifications')) {
            Schema::create('billing_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid');
                $table->unsignedBigInteger('subscription_id')->nullable();
                $table->string('type');
                $table->string('notification_type')->nullable();
                $table->string('channel')->default('email');
                $table->smallInteger('priority')->default(0);
                $table->smallInteger('status')->default(0);
                $table->string('title')->nullable();
                $table->text('message')->nullable();
                $table->string('recipient_email')->nullable();
                $table->string('subject')->nullable();
                $table->string('template_name')->nullable();
                $table->json('template_data')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamp('scheduled_at')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('type');
                $table->index('status');
            });
        }
    }

    public function down(): void
    {
    }
};

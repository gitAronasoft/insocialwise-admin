<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notification')) {
            Schema::create('notification', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('social_userid', 255)->nullable();
                $table->string('accountplatform', 255)->nullable();
                $table->string('notificationtype', 255)->nullable();
                $table->string('notificationtype_id', 255)->nullable();
                $table->string('page_or_post_id', 255)->nullable();
                $table->smallInteger('is_read')->default(0);
                $table->timestamp('notification_datetime')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user_notifications')) {
            Schema::create('user_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255);
                $table->string('type', 100);
                $table->string('title', 255);
                $table->text('message');
                $table->string('icon', 255)->nullable();
                $table->smallInteger('severity')->default(0);
                $table->string('link', 255)->nullable();
                $table->smallInteger('is_read')->default(0);
                $table->json('metadata')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

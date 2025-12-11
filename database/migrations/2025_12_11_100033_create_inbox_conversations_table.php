<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inbox_conversations')) {
            Schema::create('inbox_conversations', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 250);
                $table->string('social_userid', 200);
                $table->string('social_pageid', 250);
                $table->string('social_platform', 100);
                $table->string('conversation_id', 200);
                $table->string('external_userid', 200);
                $table->string('external_username', 200)->nullable();
                $table->string('external_userimg', 250)->nullable();
                $table->string('snippet', 250);
                $table->smallInteger('status')->default(0);
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('conversation_id');
            });
        }
    }

    public function down(): void
    {
    }
};

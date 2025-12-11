<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('activity')) {
            Schema::create('activity', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('account_social_userid', 255)->nullable();
                $table->string('account_platform', 255)->nullable();
                $table->string('activity_type', 255)->nullable();
                $table->string('activity_subtype', 255)->nullable();
                $table->string('action', 255)->nullable();
                $table->string('source_type', 255)->nullable();
                $table->string('post_form_id', 255)->nullable();
                $table->text('reference_pageid')->nullable();
                $table->timestamp('activity_datetime')->nullable();
                $table->timestamp('nextapi_call_datetime')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

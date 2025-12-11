<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_sessions')) {
            Schema::create('admin_sessions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id');
                $table->string('session_token', 255);
                $table->string('ip_address', 45);
                $table->text('user_agent')->nullable();
                $table->string('device_type', 50)->nullable();
                $table->string('browser', 100)->nullable();
                $table->string('os', 100)->nullable();
                $table->string('location', 255)->nullable();
                $table->boolean('is_current')->default(false);
                $table->timestamp('last_activity_at')->nullable();
                $table->timestamp('logged_in_at')->nullable();
                $table->timestamp('logged_out_at')->nullable();
                $table->string('status', 50)->default('active');
                $table->timestamps();
                
                $table->index('admin_id');
            });
        }
    }

    public function down(): void
    {
    }
};

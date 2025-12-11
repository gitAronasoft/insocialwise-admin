<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_audit_logs')) {
            Schema::create('admin_audit_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id')->nullable();
                $table->string('admin_email', 255)->nullable();
                $table->string('admin_name', 255)->nullable();
                $table->string('action_type', 100);
                $table->string('entity_type', 255)->nullable();
                $table->string('entity_id', 255)->nullable();
                $table->text('description');
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->json('metadata')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('request_method', 10)->nullable();
                $table->text('request_url')->nullable();
                $table->string('session_id', 255)->nullable();
                $table->string('severity', 50)->default('info');
                $table->timestamps();
                
                $table->index('admin_id');
                $table->index('action_type');
            });
        }
    }

    public function down(): void
    {
    }
};

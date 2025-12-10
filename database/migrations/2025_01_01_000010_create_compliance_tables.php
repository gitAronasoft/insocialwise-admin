<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compliance_policies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('version')->default('1.0');
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_acceptance')->default(false);
            $table->timestamp('effective_date')->nullable();
            $table->timestamps();
        });

        Schema::create('data_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->enum('request_type', ['export', 'delete', 'access', 'rectification']);
            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');
            $table->text('description')->nullable();
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('processed_by')->references('id')->on('admin_users')->onDelete('set null');
        });

        Schema::create('data_retention_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('data_type');
            $table->integer('retention_days');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('data_retention_rules');
        Schema::dropIfExists('data_requests');
        Schema::dropIfExists('compliance_policies');
    }
};

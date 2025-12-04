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
            $table->enum('policy_type', ['privacy_policy', 'terms_of_service', 'cookie_policy', 'data_retention', 'gdpr'])->unique();
            $table->longText('content');
            $table->string('version')->default('1.0');
            $table->date('effective_date');
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('data_requests', function (Blueprint $table) {
            $table->id();
            $table->string('user_uuid');
            $table->string('user_email');
            $table->enum('request_type', ['export', 'delete', 'access', 'rectification'])->default('export');
            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamps();
        });

        Schema::create('data_retention_rules', function (Blueprint $table) {
            $table->id();
            $table->string('data_type');
            $table->integer('retention_days');
            $table->boolean('auto_delete')->default(false);
            $table->timestamp('last_cleanup_at')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_retention_rules');
        Schema::dropIfExists('data_requests');
        Schema::dropIfExists('compliance_policies');
    }
};

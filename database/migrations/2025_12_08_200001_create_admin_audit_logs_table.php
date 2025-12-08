<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admin_audit_logs')) {
            return;
        }
        Schema::create('admin_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('admin_name')->nullable();
            $table->enum('action_type', [
                'login',
                'logout',
                'login_failed',
                'password_changed',
                'profile_updated',
                'customer_created',
                'customer_updated',
                'customer_deleted',
                'customer_status_changed',
                'subscription_created',
                'subscription_updated',
                'subscription_canceled',
                'plan_created',
                'plan_updated',
                'plan_deleted',
                'setting_created',
                'setting_updated',
                'setting_deleted',
                'admin_created',
                'admin_updated',
                'admin_deleted',
                'role_assigned',
                'role_removed',
                'webhook_created',
                'webhook_updated',
                'webhook_deleted',
                'webhook_tested',
                'policy_created',
                'policy_updated',
                'data_request_handled',
                'feature_flag_toggled',
                'knowledge_base_created',
                'knowledge_base_updated',
                'knowledge_base_deleted',
                'bulk_action',
                'export_data',
                'api_key_updated',
                'api_key_tested',
                'other'
            ]);
            $table->string('entity_type')->nullable()->comment('Model or entity affected');
            $table->string('entity_id')->nullable()->comment('ID of the affected entity');
            $table->text('description');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->json('metadata')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('request_method', 10)->nullable();
            $table->text('request_url')->nullable();
            $table->string('session_id')->nullable();
            $table->enum('severity', ['info', 'warning', 'critical'])->default('info');
            $table->timestamps();

            $table->index('admin_id');
            $table->index('action_type');
            $table->index('entity_type');
            $table->index('severity');
            $table->index('created_at');
            $table->index('ip_address');
            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_audit_logs');
    }
};

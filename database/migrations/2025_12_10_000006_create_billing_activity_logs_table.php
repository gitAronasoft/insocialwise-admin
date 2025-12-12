<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('billing_activity_logs')) {
            Schema::create('billing_activity_logs', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid')->nullable();
                $table->unsignedBigInteger('subscription_id')->nullable();
                $table->unsignedBigInteger('transaction_id')->nullable();
                $table->enum('action_type', [
                'subscription_created',
                'subscription_updated',
                'subscription_canceled',
                'subscription_reactivated',
                'subscription_paused',
                'subscription_resumed',
                'plan_upgraded',
                'plan_downgraded',
                'trial_started',
                'trial_extended',
                'trial_ended',
                'payment_attempted',
                'payment_succeeded',
                'payment_failed',
                'payment_refunded',
                'invoice_created',
                'invoice_sent',
                'invoice_paid',
                'invoice_voided',
                'card_added',
                'card_updated',
                'card_removed',
                'card_set_default',
                'billing_info_updated',
                'coupon_applied',
                'coupon_removed',
                'webhook_received',
                'webhook_processed',
                'notification_sent',
                'dunning_started',
                'dunning_escalated',
                'dunning_resolved',
                'admin_action',
                'system_action'
                ])->comment('Type of billing action');
                $table->enum('action_status', ['success', 'failed', 'pending', 'skipped'])->default('success')->comment('Status of the action');
                $table->enum('actor_type', ['user', 'admin', 'system', 'stripe', 'cron'])->default('system')->comment('Who performed the action');
                $table->text('description')->nullable();           
                $table->string('actor_id')->nullable();
                $table->string('actor_email')->nullable();
                $table->json('old_value')->nullable();
                $table->json('new_value')->nullable();
                $table->json('metadata')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('stripe_event_id')->nullable();
                $table->string('stripe_object_id')->nullable();
                $table->string('error_code')->nullable();
                $table->text('error_message')->nullable();
                $table->text('notes')->nullable();
                $table->string('request_id')->nullable();
                $table->bigInteger('amount')->nullable();
                $table->string('currency', 3)->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('subscription_id');
                $table->index('action_type');
                $table->index('created_at');
            });
        }
    }

    public function down(): void
    {
    }
};

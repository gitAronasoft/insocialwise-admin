<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_uuid')->nullable()->comment('User UUID reference');
            $table->unsignedInteger('subscription_id')->nullable()->comment('Related subscription ID');
            $table->unsignedInteger('transaction_id')->nullable()->comment('Related transaction ID');
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
            $table->string('actor_id')->nullable()->comment('ID of the actor');
            $table->string('actor_email')->nullable()->comment('Email of the actor');
            $table->json('old_value')->nullable()->comment('Previous value(s) before change');
            $table->json('new_value')->nullable()->comment('New value(s) after change');
            $table->integer('amount')->nullable()->comment('Amount involved in cents');
            $table->string('currency', 3)->nullable()->comment('Currency code');
            $table->string('stripe_event_id')->nullable()->comment('Related Stripe event ID');
            $table->string('stripe_object_id')->nullable()->comment('Related Stripe object ID');
            $table->string('error_code', 100)->nullable()->comment('Error code if failed');
            $table->text('error_message')->nullable()->comment('Error message if failed');
            $table->text('description')->nullable()->comment('Human-readable description');
            $table->text('notes')->nullable()->comment('Admin notes');
            $table->string('ip_address', 45)->nullable()->comment('IP address of the request');
            $table->text('user_agent')->nullable()->comment('User agent string');
            $table->string('request_id')->nullable()->comment('Request ID for tracing');
            $table->json('metadata')->nullable()->comment('Additional metadata');
            $table->timestamps();

            $table->index('user_uuid');
            $table->index('subscription_id');
            $table->index('transaction_id');
            $table->index('action_type');
            $table->index('action_status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_activity_logs');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->index('user_uuid', 'idx_subscriptions_user_uuid');
            $table->index('stripe_subscription_id', 'idx_subscriptions_stripe_subscription_id');
            $table->index('stripe_customer_id', 'idx_subscriptions_stripe_customer_id');
            $table->index('status', 'idx_subscriptions_status');
            $table->index(['user_uuid', 'status'], 'idx_subscriptions_user_status');
            $table->index(['status', 'current_period_end'], 'idx_subscriptions_status_period_end');
            $table->index('dunning_status', 'idx_subscriptions_dunning_status');
            $table->index('next_payment_retry_at', 'idx_subscriptions_next_retry');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index('user_uuid', 'idx_transactions_user_uuid');
            $table->index('stripe_invoice_id', 'idx_transactions_stripe_invoice_id');
            $table->index('stripe_payment_intent_id', 'idx_transactions_stripe_payment_intent_id');
            $table->index('stripe_charge_id', 'idx_transactions_stripe_charge_id');
            $table->index('stripe_customer_id', 'idx_transactions_stripe_customer_id');
            $table->index('status', 'idx_transactions_status');
            $table->index(['user_uuid', 'status'], 'idx_transactions_user_status');
            $table->index('paid_at', 'idx_transactions_paid_at');
            $table->index('subscription_id', 'idx_transactions_subscription_id');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->index('user_uuid', 'idx_payment_methods_user_uuid');
            $table->index('stripe_payment_method_id', 'idx_payment_methods_stripe_pm_id');
            $table->index('stripe_customer_id', 'idx_payment_methods_stripe_customer_id');
            $table->index(['user_uuid', 'status'], 'idx_payment_methods_user_status');
            $table->index(['user_uuid', 'is_default'], 'idx_payment_methods_user_default');
            $table->index(['fingerprint', 'user_uuid'], 'idx_payment_methods_fingerprint_user');
        });

        Schema::table('subscription_events', function (Blueprint $table) {
            $table->unique('stripe_event_id', 'uq_subscription_events_stripe_event_id');
            $table->index('subscription_id', 'idx_subscription_events_subscription_id');
            $table->index('user_uuid', 'idx_subscription_events_user_uuid');
            $table->index('event_type', 'idx_subscription_events_event_type');
            $table->index('occurred_at', 'idx_subscription_events_occurred_at');
            $table->index(['subscription_id', 'occurred_at'], 'idx_subscription_events_sub_occurred');
        });

        Schema::table('billing_activity_logs', function (Blueprint $table) {
            $table->index('user_uuid', 'idx_billing_logs_user_uuid');
            $table->index('subscription_id', 'idx_billing_logs_subscription_id');
            $table->index('action_type', 'idx_billing_logs_action_type');
            $table->index('action_status', 'idx_billing_logs_action_status');
            $table->index('created_at', 'idx_billing_logs_created_at');
            $table->index(['user_uuid', 'created_at'], 'idx_billing_logs_user_created');
            $table->index('stripe_event_id', 'idx_billing_logs_stripe_event_id');
        });

        Schema::table('billing_notifications', function (Blueprint $table) {
            $table->index('user_uuid', 'idx_billing_notifications_user_uuid');
            $table->index('subscription_id', 'idx_billing_notifications_subscription_id');
            $table->index('status', 'idx_billing_notifications_status');
            $table->index('type', 'idx_billing_notifications_type');
            $table->index('sent_at', 'idx_billing_notifications_sent_at');
            $table->index(['status', 'scheduled_at'], 'idx_billing_notifications_status_scheduled');
        });

        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->index('stripe_price_id', 'idx_subscription_plans_stripe_price_id');
            $table->index('stripe_product_id', 'idx_subscription_plans_stripe_product_id');
            $table->index('is_active', 'idx_subscription_plans_is_active');
        });

        Schema::table('webhook_events', function (Blueprint $table) {
            $table->index('event_type', 'idx_webhook_events_event_type');
            $table->index('status', 'idx_webhook_events_status');
            $table->index('customer_id', 'idx_webhook_events_customer_id');
            $table->index('object_id', 'idx_webhook_events_object_id');
            $table->index('processed_at', 'idx_webhook_events_processed_at');
            $table->index('received_at', 'idx_webhook_events_received_at');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex('idx_subscriptions_user_uuid');
            $table->dropIndex('idx_subscriptions_stripe_subscription_id');
            $table->dropIndex('idx_subscriptions_stripe_customer_id');
            $table->dropIndex('idx_subscriptions_status');
            $table->dropIndex('idx_subscriptions_user_status');
            $table->dropIndex('idx_subscriptions_status_period_end');
            $table->dropIndex('idx_subscriptions_dunning_status');
            $table->dropIndex('idx_subscriptions_next_retry');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_user_uuid');
            $table->dropIndex('idx_transactions_stripe_invoice_id');
            $table->dropIndex('idx_transactions_stripe_payment_intent_id');
            $table->dropIndex('idx_transactions_stripe_charge_id');
            $table->dropIndex('idx_transactions_stripe_customer_id');
            $table->dropIndex('idx_transactions_status');
            $table->dropIndex('idx_transactions_user_status');
            $table->dropIndex('idx_transactions_paid_at');
            $table->dropIndex('idx_transactions_subscription_id');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropIndex('idx_payment_methods_user_uuid');
            $table->dropIndex('idx_payment_methods_stripe_pm_id');
            $table->dropIndex('idx_payment_methods_stripe_customer_id');
            $table->dropIndex('idx_payment_methods_user_status');
            $table->dropIndex('idx_payment_methods_user_default');
            $table->dropIndex('idx_payment_methods_fingerprint_user');
        });

        Schema::table('subscription_events', function (Blueprint $table) {
            $table->dropUnique('uq_subscription_events_stripe_event_id');
            $table->dropIndex('idx_subscription_events_subscription_id');
            $table->dropIndex('idx_subscription_events_user_uuid');
            $table->dropIndex('idx_subscription_events_event_type');
            $table->dropIndex('idx_subscription_events_occurred_at');
            $table->dropIndex('idx_subscription_events_sub_occurred');
        });

        Schema::table('billing_activity_logs', function (Blueprint $table) {
            $table->dropIndex('idx_billing_logs_user_uuid');
            $table->dropIndex('idx_billing_logs_subscription_id');
            $table->dropIndex('idx_billing_logs_action_type');
            $table->dropIndex('idx_billing_logs_action_status');
            $table->dropIndex('idx_billing_logs_created_at');
            $table->dropIndex('idx_billing_logs_user_created');
            $table->dropIndex('idx_billing_logs_stripe_event_id');
        });

        Schema::table('billing_notifications', function (Blueprint $table) {
            $table->dropIndex('idx_billing_notifications_user_uuid');
            $table->dropIndex('idx_billing_notifications_subscription_id');
            $table->dropIndex('idx_billing_notifications_status');
            $table->dropIndex('idx_billing_notifications_type');
            $table->dropIndex('idx_billing_notifications_sent_at');
            $table->dropIndex('idx_billing_notifications_status_scheduled');
        });

        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropIndex('idx_subscription_plans_stripe_price_id');
            $table->dropIndex('idx_subscription_plans_stripe_product_id');
            $table->dropIndex('idx_subscription_plans_is_active');
        });

        Schema::table('webhook_events', function (Blueprint $table) {
            $table->dropIndex('idx_webhook_events_event_type');
            $table->dropIndex('idx_webhook_events_status');
            $table->dropIndex('idx_webhook_events_customer_id');
            $table->dropIndex('idx_webhook_events_object_id');
            $table->dropIndex('idx_webhook_events_processed_at');
            $table->dropIndex('idx_webhook_events_received_at');
        });
    }
};

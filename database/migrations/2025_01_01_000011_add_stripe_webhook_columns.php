<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('subscriptions', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable()->after('plan_id');
            }
            if (!Schema::hasColumn('subscriptions', 'stripe_price_id')) {
                $table->string('stripe_price_id')->nullable()->after('stripe_subscription_id');
            }
            if (!Schema::hasColumn('subscriptions', 'trial_start')) {
                $table->timestamp('trial_start')->nullable()->after('trial_ends_at');
            }
            if (!Schema::hasColumn('subscriptions', 'trial_end')) {
                $table->timestamp('trial_end')->nullable()->after('trial_start');
            }
            if (!Schema::hasColumn('subscriptions', 'trial_days')) {
                $table->integer('trial_days')->nullable()->after('trial_end');
            }
            if (!Schema::hasColumn('subscriptions', 'billing_cycle_anchor')) {
                $table->timestamp('billing_cycle_anchor')->nullable()->after('current_period_end');
            }
            if (!Schema::hasColumn('subscriptions', 'next_invoice_date')) {
                $table->timestamp('next_invoice_date')->nullable()->after('billing_cycle_anchor');
            }
            if (!Schema::hasColumn('subscriptions', 'collection_method')) {
                $table->string('collection_method')->nullable()->after('next_invoice_date');
            }
            if (!Schema::hasColumn('subscriptions', 'quantity')) {
                $table->integer('quantity')->default(1)->after('collection_method');
            }
            if (!Schema::hasColumn('subscriptions', 'billing_interval')) {
                $table->string('billing_interval')->default('month')->after('quantity');
            }
            if (!Schema::hasColumn('subscriptions', 'cancel_at_period_end')) {
                $table->boolean('cancel_at_period_end')->default(false)->after('billing_interval');
            }
            if (!Schema::hasColumn('subscriptions', 'cancel_at')) {
                $table->timestamp('cancel_at')->nullable()->after('cancel_at_period_end');
            }
            if (!Schema::hasColumn('subscriptions', 'latest_invoice_id')) {
                $table->string('latest_invoice_id')->nullable()->after('ended_at');
            }
            if (!Schema::hasColumn('subscriptions', 'past_due_since')) {
                $table->timestamp('past_due_since')->nullable()->after('latest_invoice_id');
            }
            if (!Schema::hasColumn('subscriptions', 'dunning_status')) {
                $table->string('dunning_status')->default('none')->after('past_due_since');
            }
            if (!Schema::hasColumn('subscriptions', 'payment_retry_count')) {
                $table->integer('payment_retry_count')->default(0)->after('dunning_status');
            }
            if (!Schema::hasColumn('subscriptions', 'next_payment_retry_at')) {
                $table->timestamp('next_payment_retry_at')->nullable()->after('payment_retry_count');
            }
            if (!Schema::hasColumn('subscriptions', 'last_payment_error')) {
                $table->text('last_payment_error')->nullable()->after('next_payment_retry_at');
            }
            if (!Schema::hasColumn('subscriptions', 'last_payment_attempt_at')) {
                $table->timestamp('last_payment_attempt_at')->nullable()->after('last_payment_error');
            }
            if (!Schema::hasColumn('subscriptions', 'synced_at')) {
                $table->timestamp('synced_at')->nullable()->after('last_payment_attempt_at');
            }
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('subscription_id');
            }
            if (!Schema::hasColumn('transactions', 'stripe_subscription_id')) {
                $table->string('stripe_subscription_id')->nullable()->after('stripe_invoice_id');
            }
            if (!Schema::hasColumn('transactions', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable()->after('stripe_subscription_id');
            }
            if (!Schema::hasColumn('transactions', 'stripe_charge_id')) {
                $table->string('stripe_charge_id')->nullable()->after('stripe_customer_id');
            }
            if (!Schema::hasColumn('transactions', 'stripe_refund_id')) {
                $table->string('stripe_refund_id')->nullable()->after('stripe_charge_id');
            }
            if (!Schema::hasColumn('transactions', 'invoice_number')) {
                $table->string('invoice_number')->nullable()->after('stripe_refund_id');
            }
            if (!Schema::hasColumn('transactions', 'invoice_pdf_url')) {
                $table->text('invoice_pdf_url')->nullable()->after('invoice_number');
            }
            if (!Schema::hasColumn('transactions', 'invoice_hosted_url')) {
                $table->text('invoice_hosted_url')->nullable()->after('invoice_pdf_url');
            }
            if (!Schema::hasColumn('transactions', 'receipt_url')) {
                $table->text('receipt_url')->nullable()->after('invoice_hosted_url');
            }
            if (!Schema::hasColumn('transactions', 'billing_reason')) {
                $table->string('billing_reason')->nullable()->after('receipt_url');
            }
            if (!Schema::hasColumn('transactions', 'amount_subtotal')) {
                $table->decimal('amount_subtotal', 12, 2)->nullable()->after('amount');
            }
            if (!Schema::hasColumn('transactions', 'amount_tax')) {
                $table->decimal('amount_tax', 12, 2)->default(0)->after('amount_subtotal');
            }
            if (!Schema::hasColumn('transactions', 'amount_total')) {
                $table->decimal('amount_total', 12, 2)->nullable()->after('amount_tax');
            }
            if (!Schema::hasColumn('transactions', 'amount_due')) {
                $table->decimal('amount_due', 12, 2)->nullable()->after('amount_total');
            }
            if (!Schema::hasColumn('transactions', 'amount_paid')) {
                $table->decimal('amount_paid', 12, 2)->nullable()->after('amount_due');
            }
            if (!Schema::hasColumn('transactions', 'amount_remaining')) {
                $table->decimal('amount_remaining', 12, 2)->nullable()->after('amount_paid');
            }
            if (!Schema::hasColumn('transactions', 'payment_status')) {
                $table->string('payment_status')->nullable()->after('status');
            }
            if (!Schema::hasColumn('transactions', 'failure_code')) {
                $table->string('failure_code')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('transactions', 'failure_message')) {
                $table->text('failure_message')->nullable()->after('failure_code');
            }
            if (!Schema::hasColumn('transactions', 'failure_reason')) {
                $table->string('failure_reason')->nullable()->after('failure_message');
            }
            if (!Schema::hasColumn('transactions', 'attempt_count')) {
                $table->integer('attempt_count')->default(0)->after('failure_reason');
            }
            if (!Schema::hasColumn('transactions', 'next_payment_attempt')) {
                $table->timestamp('next_payment_attempt')->nullable()->after('attempt_count');
            }
            if (!Schema::hasColumn('transactions', 'due_date')) {
                $table->timestamp('due_date')->nullable()->after('next_payment_attempt');
            }
            if (!Schema::hasColumn('transactions', 'period_start')) {
                $table->timestamp('period_start')->nullable()->after('due_date');
            }
            if (!Schema::hasColumn('transactions', 'period_end')) {
                $table->timestamp('period_end')->nullable()->after('period_start');
            }
            if (!Schema::hasColumn('transactions', 'refund_amount')) {
                $table->decimal('refund_amount', 12, 2)->nullable()->after('period_end');
            }
            if (!Schema::hasColumn('transactions', 'refunded_at')) {
                $table->timestamp('refunded_at')->nullable()->after('refund_amount');
            }
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_methods', 'stripe_customer_id')) {
                $table->string('stripe_customer_id')->nullable()->after('user_uuid');
            }
            if (!Schema::hasColumn('payment_methods', 'funding')) {
                $table->string('funding')->nullable()->after('exp_year');
            }
            if (!Schema::hasColumn('payment_methods', 'country')) {
                $table->string('country')->nullable()->after('funding');
            }
            if (!Schema::hasColumn('payment_methods', 'billing_details')) {
                $table->json('billing_details')->nullable()->after('country');
            }
            if (!Schema::hasColumn('payment_methods', 'fingerprint')) {
                $table->string('fingerprint')->nullable()->after('billing_details');
            }
            if (!Schema::hasColumn('payment_methods', 'wallet')) {
                $table->string('wallet')->nullable()->after('fingerprint');
            }
            if (!Schema::hasColumn('payment_methods', 'status')) {
                $table->string('status')->default('active')->after('is_default');
            }
        });

        Schema::table('subscription_events', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_events', 'user_uuid')) {
                $table->uuid('user_uuid')->nullable()->after('subscription_id');
            }
            if (!Schema::hasColumn('subscription_events', 'stripe_subscription_id')) {
                $table->string('stripe_subscription_id')->nullable()->after('user_uuid');
            }
            if (!Schema::hasColumn('subscription_events', 'stripe_event_id')) {
                $table->string('stripe_event_id')->nullable()->after('stripe_subscription_id');
            }
            if (!Schema::hasColumn('subscription_events', 'old_status')) {
                $table->string('old_status')->nullable()->after('event_type');
            }
            if (!Schema::hasColumn('subscription_events', 'new_status')) {
                $table->string('new_status')->nullable()->after('old_status');
            }
            if (!Schema::hasColumn('subscription_events', 'amount')) {
                $table->decimal('amount', 12, 2)->nullable()->after('new_status');
            }
            if (!Schema::hasColumn('subscription_events', 'currency')) {
                $table->string('currency')->nullable()->after('amount');
            }
            if (!Schema::hasColumn('subscription_events', 'failure_code')) {
                $table->string('failure_code')->nullable()->after('currency');
            }
            if (!Schema::hasColumn('subscription_events', 'failure_message')) {
                $table->text('failure_message')->nullable()->after('failure_code');
            }
            if (!Schema::hasColumn('subscription_events', 'actor')) {
                $table->string('actor')->nullable()->after('failure_message');
            }
            if (!Schema::hasColumn('subscription_events', 'actor_id')) {
                $table->string('actor_id')->nullable()->after('actor');
            }
            if (!Schema::hasColumn('subscription_events', 'description')) {
                $table->text('description')->nullable()->after('actor_id');
            }
            if (!Schema::hasColumn('subscription_events', 'metadata')) {
                $table->json('metadata')->nullable()->after('event_data');
            }
            if (!Schema::hasColumn('subscription_events', 'event_payload')) {
                $table->json('event_payload')->nullable()->after('metadata');
            }
            if (!Schema::hasColumn('subscription_events', 'occurred_at')) {
                $table->timestamp('occurred_at')->nullable()->after('event_payload');
            }
            if (!Schema::hasColumn('subscription_events', 'processed_at')) {
                $table->timestamp('processed_at')->nullable()->after('occurred_at');
            }
        });

        Schema::table('billing_activity_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('billing_activity_logs', 'transaction_id')) {
                $table->unsignedBigInteger('transaction_id')->nullable()->after('subscription_id');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'action_type')) {
                $table->string('action_type')->nullable()->after('action');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'action_status')) {
                $table->string('action_status')->nullable()->after('action_type');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'actor_type')) {
                $table->string('actor_type')->nullable()->after('action_status');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'actor_email')) {
                $table->string('actor_email')->nullable()->after('actor_type');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'actor_id')) {
                $table->string('actor_id')->nullable()->after('actor_email');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'old_value')) {
                $table->json('old_value')->nullable()->after('actor_id');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'new_value')) {
                $table->json('new_value')->nullable()->after('old_value');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'amount')) {
                $table->decimal('amount', 12, 2)->nullable()->after('new_value');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'currency')) {
                $table->string('currency')->nullable()->after('amount');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'error_code')) {
                $table->string('error_code')->nullable()->after('currency');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'error_message')) {
                $table->text('error_message')->nullable()->after('error_code');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'stripe_event_id')) {
                $table->string('stripe_event_id')->nullable()->after('error_message');
            }
            if (!Schema::hasColumn('billing_activity_logs', 'stripe_object_id')) {
                $table->string('stripe_object_id')->nullable()->after('stripe_event_id');
            }
        });

        Schema::table('webhook_events', function (Blueprint $table) {
            if (!Schema::hasColumn('webhook_events', 'stripe_event_id')) {
                $table->string('stripe_event_id')->nullable()->unique()->after('webhook_id');
            }
            if (!Schema::hasColumn('webhook_events', 'api_version')) {
                $table->string('api_version')->nullable()->after('stripe_event_id');
            }
            if (!Schema::hasColumn('webhook_events', 'livemode')) {
                $table->boolean('livemode')->default(false)->after('api_version');
            }
            if (!Schema::hasColumn('webhook_events', 'object_type')) {
                $table->string('object_type')->nullable()->after('livemode');
            }
            if (!Schema::hasColumn('webhook_events', 'object_id')) {
                $table->string('object_id')->nullable()->after('object_type');
            }
            if (!Schema::hasColumn('webhook_events', 'customer_id')) {
                $table->string('customer_id')->nullable()->after('object_id');
            }
            if (!Schema::hasColumn('webhook_events', 'subscription_id')) {
                $table->string('subscription_id')->nullable()->after('customer_id');
            }
            if (!Schema::hasColumn('webhook_events', 'invoice_id')) {
                $table->string('invoice_id')->nullable()->after('subscription_id');
            }
            if (!Schema::hasColumn('webhook_events', 'payment_intent_id')) {
                $table->string('payment_intent_id')->nullable()->after('invoice_id');
            }
            if (!Schema::hasColumn('webhook_events', 'payload_hash')) {
                $table->string('payload_hash')->nullable()->after('payload');
            }
            if (!Schema::hasColumn('webhook_events', 'received_at')) {
                $table->timestamp('received_at')->nullable()->after('payload_hash');
            }
            if (!Schema::hasColumn('webhook_events', 'processed_at')) {
                $table->timestamp('processed_at')->nullable()->after('received_at');
            }
            if (!Schema::hasColumn('webhook_events', 'processing_time_ms')) {
                $table->integer('processing_time_ms')->nullable()->after('processed_at');
            }
            if (!Schema::hasColumn('webhook_events', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('processing_time_ms');
            }
            if (!Schema::hasColumn('webhook_events', 'signature_verified')) {
                $table->boolean('signature_verified')->default(false)->after('ip_address');
            }
            if (!Schema::hasColumn('webhook_events', 'actions_taken')) {
                $table->json('actions_taken')->nullable()->after('signature_verified');
            }
            if (!Schema::hasColumn('webhook_events', 'affected_records')) {
                $table->json('affected_records')->nullable()->after('actions_taken');
            }
        });

        Schema::table('billing_notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('billing_notifications', 'notification_type')) {
                $table->string('notification_type')->nullable()->after('type');
            }
            if (!Schema::hasColumn('billing_notifications', 'channel')) {
                $table->string('channel')->default('email')->after('notification_type');
            }
            if (!Schema::hasColumn('billing_notifications', 'priority')) {
                $table->string('priority')->default('normal')->after('channel');
            }
            if (!Schema::hasColumn('billing_notifications', 'recipient_email')) {
                $table->string('recipient_email')->nullable()->after('priority');
            }
            if (!Schema::hasColumn('billing_notifications', 'subject')) {
                $table->string('subject')->nullable()->after('recipient_email');
            }
            if (!Schema::hasColumn('billing_notifications', 'template_name')) {
                $table->string('template_name')->nullable()->after('subject');
            }
            if (!Schema::hasColumn('billing_notifications', 'template_data')) {
                $table->json('template_data')->nullable()->after('template_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $columns = ['stripe_customer_id', 'stripe_price_id', 'trial_start', 'trial_end', 'trial_days',
                'billing_cycle_anchor', 'next_invoice_date', 'collection_method', 'quantity', 'billing_interval',
                'cancel_at_period_end', 'cancel_at', 'latest_invoice_id', 'past_due_since', 'dunning_status',
                'payment_retry_count', 'next_payment_retry_at', 'last_payment_error', 'last_payment_attempt_at', 'synced_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('subscriptions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('transactions', function (Blueprint $table) {
            $columns = ['plan_id', 'stripe_subscription_id', 'stripe_customer_id', 'stripe_charge_id', 'stripe_refund_id',
                'invoice_number', 'invoice_pdf_url', 'invoice_hosted_url', 'receipt_url', 'billing_reason',
                'amount_subtotal', 'amount_tax', 'amount_total', 'amount_due', 'amount_paid', 'amount_remaining',
                'payment_status', 'failure_code', 'failure_message', 'failure_reason', 'attempt_count',
                'next_payment_attempt', 'due_date', 'period_start', 'period_end', 'refund_amount', 'refunded_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('transactions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $columns = ['stripe_customer_id', 'funding', 'country', 'billing_details', 'fingerprint', 'wallet', 'status'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('payment_methods', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('subscription_events', function (Blueprint $table) {
            $columns = ['user_uuid', 'stripe_subscription_id', 'stripe_event_id', 'old_status', 'new_status',
                'amount', 'currency', 'failure_code', 'failure_message', 'actor', 'actor_id', 'description',
                'metadata', 'event_payload', 'occurred_at', 'processed_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('subscription_events', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('billing_activity_logs', function (Blueprint $table) {
            $columns = ['transaction_id', 'action_type', 'action_status', 'actor_type', 'actor_email', 'actor_id',
                'old_value', 'new_value', 'amount', 'currency', 'error_code', 'error_message', 'stripe_event_id', 'stripe_object_id'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('billing_activity_logs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('webhook_events', function (Blueprint $table) {
            $columns = ['stripe_event_id', 'api_version', 'livemode', 'object_type', 'object_id', 'customer_id',
                'subscription_id', 'invoice_id', 'payment_intent_id', 'payload_hash', 'received_at', 'processed_at',
                'processing_time_ms', 'ip_address', 'signature_verified', 'actions_taken', 'affected_records'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('webhook_events', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('billing_notifications', function (Blueprint $table) {
            $columns = ['notification_type', 'channel', 'priority', 'recipient_email', 'subject', 'template_name', 'template_data'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('billing_notifications', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

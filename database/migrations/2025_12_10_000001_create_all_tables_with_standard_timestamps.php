<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('webhook_events')) {
            Schema::create('webhook_events', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('webhook_id')->default(0);
                $table->string('stripe_event_id')->unique();
                $table->string('event_type');
                $table->string('api_version')->nullable();
                $table->boolean('livemode')->default(false);
                $table->string('object_type')->nullable();
                $table->string('object_id')->nullable();
                $table->string('customer_id')->nullable();
                $table->string('subscription_id')->nullable();
                $table->string('invoice_id')->nullable();
                $table->string('payment_intent_id')->nullable();
                $table->json('payload')->nullable();
                $table->string('payload_hash')->nullable();
                $table->integer('response_code')->nullable();
                $table->text('response_body')->nullable();
                $table->string('status')->default('pending');
                $table->text('error_message')->nullable();
                $table->integer('retry_count')->default(0);
                $table->timestamp('received_at')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->integer('processing_time_ms')->nullable();
                $table->timestamp('executed_at')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->boolean('signature_verified')->default(false);
                $table->json('actions_taken')->nullable();
                $table->json('affected_records')->nullable();
                $table->json('request_headers')->nullable();
                $table->json('response_data')->nullable();
                $table->timestamps();
                
                $table->index('event_type');
                $table->index('status');
                $table->index('customer_id');
                $table->index('created_at');
            });
        }

        if (!Schema::hasTable('webhook_logs')) {
            Schema::create('webhook_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('webhook_id')->nullable();
                $table->unsignedBigInteger('webhook_event_id')->nullable();
                $table->string('log_level')->default('info');
                $table->string('event_type');
                $table->string('stripe_event_id')->nullable();
                $table->text('message')->nullable();
                $table->json('context')->nullable();
                $table->json('request_data')->nullable();
                $table->json('response_data')->nullable();
                $table->json('payload')->nullable();
                $table->integer('response_code')->nullable();
                $table->text('response_body')->nullable();
                $table->string('status')->default('success');
                $table->text('error_message')->nullable();
                $table->integer('retry_count')->default(0);
                $table->string('ip_address', 45)->nullable();
                $table->integer('processing_time_ms')->nullable();
                $table->timestamp('executed_at')->nullable();
                $table->timestamps();
                
                $table->index('webhook_event_id');
                $table->index('log_level');
                $table->index('event_type');
                $table->index('created_at');
            });
        }

        if (!Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid');
                $table->string('stripe_customer_id');
                $table->string('stripe_subscription_id')->unique();
                $table->string('price_id');
                $table->unsignedBigInteger('plan_id')->nullable();
                $table->string('status', 50);
                $table->string('stripe_price_id')->nullable();
                $table->timestamp('trial_start')->nullable();
                $table->timestamp('trial_end')->nullable();
                $table->integer('trial_days')->nullable();
                $table->timestamp('current_period_start')->nullable();
                $table->timestamp('current_period_end')->nullable();
                $table->timestamp('billing_cycle_anchor')->nullable();
                $table->timestamp('next_invoice_date')->nullable();
                $table->boolean('cancel_at_period_end')->default(false);
                $table->timestamp('cancel_at')->nullable();
                $table->timestamp('canceled_at')->nullable();
                $table->timestamp('ended_at')->nullable();
                $table->string('cancellation_reason')->nullable();
                $table->text('cancellation_feedback')->nullable();
                $table->string('pause_collection')->nullable();
                $table->timestamp('resume_at')->nullable();
                $table->string('collection_method')->default('charge_automatically');
                $table->string('default_payment_method_id')->nullable();
                $table->string('latest_invoice_id')->nullable();
                $table->integer('quantity')->default(1);
                $table->decimal('amount', 10, 2)->nullable();
                $table->string('currency', 3)->default('USD');
                $table->string('billing_interval')->default('month');
                $table->decimal('discount_percent', 5, 2)->nullable();
                $table->string('coupon_code', 100)->nullable();
                $table->string('stripe_coupon_id')->nullable();
                $table->timestamp('past_due_since')->nullable();
                $table->timestamp('last_payment_attempt_at')->nullable();
                $table->text('last_payment_error')->nullable();
                $table->integer('payment_retry_count')->default(0);
                $table->timestamp('next_payment_retry_at')->nullable();
                $table->string('dunning_status')->default('none');
                $table->text('status_reason')->nullable();
                $table->json('metadata')->nullable();
                $table->boolean('trial_reminder_sent')->default(false);
                $table->timestamp('trial_reminder_sent_at')->nullable();
                $table->boolean('renewal_reminder_sent')->default(false);
                $table->timestamp('renewal_reminder_sent_at')->nullable();
                $table->timestamp('synced_at')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('status');
            });
        }

        if (!Schema::hasTable('subscription_events')) {
            Schema::create('subscription_events', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('subscription_id')->nullable();
                $table->string('user_uuid')->nullable();
                $table->string('stripe_subscription_id')->nullable();
                $table->string('stripe_event_id')->nullable()->unique();
                $table->string('event_type');
                $table->string('old_status')->nullable();
                $table->string('new_status')->nullable();
                $table->unsignedBigInteger('old_plan_id')->nullable();
                $table->unsignedBigInteger('new_plan_id')->nullable();
                $table->integer('old_quantity')->nullable();
                $table->integer('new_quantity')->nullable();
                $table->bigInteger('amount')->nullable();
                $table->string('currency', 3)->nullable();
                $table->string('failure_code')->nullable();
                $table->text('failure_message')->nullable();
                $table->string('actor')->nullable();
                $table->string('actor_id')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('description')->nullable();
                $table->json('metadata')->nullable();
                $table->json('event_payload')->nullable();
                $table->timestamp('occurred_at')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->timestamps();
                
                $table->index('subscription_id');
                $table->index('event_type');
                $table->index('user_uuid');
            });
        }

        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('subscription_id');
                $table->string('user_uuid', 36)->nullable();
                $table->unsignedBigInteger('plan_id')->nullable();
                $table->string('stripe_invoice_id')->nullable();
                $table->string('stripe_payment_intent_id')->nullable();
                $table->string('stripe_charge_id')->nullable();
                $table->string('stripe_subscription_id')->nullable();
                $table->string('stripe_customer_id')->nullable();
                $table->string('stripe_payment_method_id')->nullable();
                $table->string('invoice_number', 100)->nullable();
                $table->string('invoice_pdf_url', 500)->nullable();
                $table->string('invoice_hosted_url', 500)->nullable();
                $table->string('billing_reason')->nullable();
                $table->bigInteger('amount_subtotal')->nullable();
                $table->bigInteger('amount_tax')->default(0);
                $table->bigInteger('amount_total')->nullable();
                $table->bigInteger('amount');
                $table->bigInteger('amount_paid')->nullable();
                $table->bigInteger('amount_due')->nullable();
                $table->bigInteger('amount_remaining')->default(0);
                $table->bigInteger('discount_amount')->default(0);
                $table->string('coupon_code', 100)->nullable();
                $table->json('tax_rates')->nullable();
                $table->string('currency', 10);
                $table->string('status', 50);
                $table->string('payment_status')->nullable();
                $table->string('failure_code', 100)->nullable();
                $table->text('failure_message')->nullable();
                $table->string('failure_reason')->nullable();
                $table->integer('attempt_count')->default(0);
                $table->timestamp('next_payment_attempt')->nullable();
                $table->timestamp('due_date')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamp('period_start')->nullable();
                $table->timestamp('period_end')->nullable();
                $table->bigInteger('refund_amount')->default(0);
                $table->timestamp('refunded_at')->nullable();
                $table->string('refund_reason')->nullable();
                $table->string('stripe_refund_id')->nullable();
                $table->text('description')->nullable();
                $table->string('receipt_url', 500)->nullable();
                $table->string('card_brand', 50)->nullable();
                $table->string('card_last4', 4)->nullable();
                $table->json('metadata')->nullable();
                $table->boolean('disputed')->default(false);
                $table->timestamps();
                
                $table->index('subscription_id');
                $table->index('user_uuid');
                $table->index('stripe_invoice_id');
            });
        }

        if (!Schema::hasTable('billing_activity_logs')) {
            Schema::create('billing_activity_logs', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid')->nullable();
                $table->unsignedBigInteger('subscription_id')->nullable();
                $table->unsignedBigInteger('transaction_id')->nullable();
                $table->string('action_type');
                $table->string('action_status')->default('success');
                $table->text('description')->nullable();
                $table->string('actor_type')->nullable();
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

        if (!Schema::hasTable('billing_notifications')) {
            Schema::create('billing_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid');
                $table->unsignedBigInteger('subscription_id')->nullable();
                $table->string('type');
                $table->string('notification_type')->nullable();
                $table->string('channel')->default('email');
                $table->string('priority')->default('normal');
                $table->string('status')->default('pending');
                $table->string('title')->nullable();
                $table->text('message')->nullable();
                $table->string('recipient_email')->nullable();
                $table->string('subject')->nullable();
                $table->string('template_name')->nullable();
                $table->json('template_data')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamp('scheduled_at')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('type');
                $table->index('status');
            });
        }

        if (!Schema::hasTable('payment_methods')) {
            Schema::create('payment_methods', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid');
                $table->string('stripe_payment_method_id')->unique();
                $table->string('stripe_customer_id');
                $table->string('type')->default('card');
                $table->string('brand')->nullable();
                $table->string('card_brand')->nullable();
                $table->string('last4', 4)->nullable();
                $table->string('card_last4', 4)->nullable();
                $table->integer('exp_month')->nullable();
                $table->integer('exp_year')->nullable();
                $table->string('card_holder_name')->nullable();
                $table->string('funding')->nullable();
                $table->string('country')->nullable();
                $table->json('billing_details')->nullable();
                $table->string('fingerprint')->nullable();
                $table->string('wallet')->nullable();
                $table->boolean('is_default')->default(false);
                $table->string('status')->default('active');
                $table->string('billing_email')->nullable();
                $table->string('billing_name')->nullable();
                $table->string('billing_phone')->nullable();
                $table->json('billing_address')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('stripe_customer_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
        Schema::dropIfExists('webhook_events');
        Schema::dropIfExists('billing_notifications');
        Schema::dropIfExists('billing_activity_logs');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('subscription_events');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('subscriptions');
    }
};

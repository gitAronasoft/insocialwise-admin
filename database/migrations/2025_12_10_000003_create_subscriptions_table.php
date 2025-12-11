<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid');
                $table->string('stripe_customer_id');
                $table->string('stripe_subscription_id')->unique();
                $table->string('price_id');
                $table->unsignedBigInteger('plan_id')->nullable();
                $table->smallInteger('status')->default(0);
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
    }

    public function down(): void
    {
    }
};

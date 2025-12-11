<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
                $table->string('status', 50)->default('pending');
                $table->string('payment_status', 50)->default('unpaid');
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
    }

    public function down(): void
    {
    }
};

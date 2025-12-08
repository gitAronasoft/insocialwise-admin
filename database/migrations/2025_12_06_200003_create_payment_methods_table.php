<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('payment_methods')) {
            return;
        }
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('user_uuid')->comment('User UUID reference');
            $table->string('stripe_payment_method_id')->unique()->comment('Stripe payment method ID');
            $table->string('stripe_customer_id')->comment('Stripe customer ID');
            $table->enum('type', ['card', 'bank_account', 'sepa_debit', 'paypal', 'other'])->default('card')->comment('Payment method type');
            $table->string('card_brand', 50)->nullable()->comment('Card brand (visa, mastercard, etc.)');
            $table->string('card_last4', 4)->nullable()->comment('Last 4 digits of card');
            $table->integer('card_exp_month')->nullable()->comment('Card expiry month');
            $table->integer('card_exp_year')->nullable()->comment('Card expiry year');
            $table->string('card_funding', 20)->nullable()->comment('Card funding type (credit, debit, prepaid)');
            $table->string('card_country', 2)->nullable()->comment('Card country code');
            $table->string('billing_name')->nullable()->comment('Billing name on payment method');
            $table->string('billing_email')->nullable()->comment('Billing email');
            $table->string('billing_phone', 50)->nullable()->comment('Billing phone');
            $table->json('billing_address')->nullable()->comment('Billing address');
            $table->boolean('is_default')->default(false)->comment('Is this the default payment method');
            $table->enum('status', ['active', 'expired', 'failed', 'removed'])->default('active')->comment('Payment method status');
            $table->dateTime('expires_at')->nullable()->comment('When the payment method expires');
            $table->dateTime('last_used_at')->nullable()->comment('When last used for payment');
            $table->json('metadata')->nullable()->comment('Additional metadata');
            $table->timestamps();

            $table->index('user_uuid');
            $table->index('stripe_customer_id');
            $table->index('is_default');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};

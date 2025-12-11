<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
                $table->smallInteger('status')->default(1);
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
    }
};

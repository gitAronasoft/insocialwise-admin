<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('billing_interval', ['monthly', 'yearly', 'weekly'])->default('monthly');
            $table->integer('trial_days')->default(0);
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_product_id')->nullable();
            $table->json('features')->nullable();
            $table->integer('max_social_accounts')->default(5);
            $table->integer('max_posts_per_month')->default(100);
            $table->integer('max_team_members')->default(1);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->unsignedBigInteger('plan_id');
            $table->string('stripe_subscription_id')->nullable();
            $table->enum('status', ['active', 'canceled', 'past_due', 'trialing', 'paused', 'incomplete'])->default('active');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('subscription_plans')->onDelete('restrict');
        });

        Schema::create('subscription_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id');
            $table->string('event_type');
            $table->json('event_data')->nullable();
            $table->string('stripe_event_id')->nullable();
            $table->timestamps();
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_invoice_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'succeeded', 'failed', 'refunded', 'partially_refunded'])->default('pending');
            $table->string('payment_method_type')->nullable();
            $table->string('payment_method_last4')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null');
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->string('stripe_payment_method_id')->nullable();
            $table->string('type')->default('card');
            $table->string('brand')->nullable();
            $table->string('last4')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('exp_year')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
        });

        Schema::create('billing_notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null');
        });

        Schema::create('billing_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->string('action');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_activity_logs');
        Schema::dropIfExists('billing_notifications');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('subscription_events');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_plans');
    }
};

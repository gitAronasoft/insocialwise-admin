<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
                $table->string('failure_code', 100)->nullable();
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
    }

    public function down(): void
    {
    }
};

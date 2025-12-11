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
                $table->smallInteger('status')->default(0);
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
    }

    public function down(): void
    {
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('billing_activity_logs')) {
            Schema::create('billing_activity_logs', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid')->nullable();
                $table->unsignedBigInteger('subscription_id')->nullable();
                $table->unsignedBigInteger('transaction_id')->nullable();
                $table->string('action_type');
                $table->smallInteger('action_status')->default(1);
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
    }

    public function down(): void
    {
    }
};

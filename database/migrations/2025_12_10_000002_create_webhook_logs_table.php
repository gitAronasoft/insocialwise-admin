<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('webhook_logs')) {
            Schema::create('webhook_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('webhook_id')->nullable();
                $table->unsignedBigInteger('webhook_event_id')->nullable();
                $table->string('log_level', 50)->default('info');
                $table->string('event_type');
                $table->string('stripe_event_id')->nullable();
                $table->text('message')->nullable();
                $table->json('context')->nullable();
                $table->json('request_data')->nullable();
                $table->json('response_data')->nullable();
                $table->json('payload')->nullable();
                $table->integer('response_code')->nullable();
                $table->text('response_body')->nullable();
                $table->smallInteger('status')->default(1);
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
    }

    public function down(): void
    {
    }
};

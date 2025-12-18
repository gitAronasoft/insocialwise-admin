<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Create PostgreSQL ENUM type
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_webhook_events_status') THEN
                    CREATE TYPE enum_webhook_events_status AS ENUM (
                        'received',
                        'processing',
                        'processed',
                        'failed',
                        'skipped',
                        'retrying'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
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

                // TEMP string (will convert to ENUM)
                $table->string('status')->default('received');

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

            // 3️⃣ Drop default → Convert → Restore default
            DB::statement("
                ALTER TABLE webhook_events
                ALTER COLUMN status DROP DEFAULT;

                ALTER TABLE webhook_events
                ALTER COLUMN status TYPE enum_webhook_events_status
                USING status::enum_webhook_events_status;

                ALTER TABLE webhook_events
                ALTER COLUMN status SET DEFAULT 'received';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_events');

        DB::statement("DROP TYPE IF EXISTS enum_webhook_events_status");
    }
};

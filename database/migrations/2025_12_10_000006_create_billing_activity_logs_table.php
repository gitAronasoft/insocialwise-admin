<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Create PostgreSQL ENUM types
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_activity_logs_action_type') THEN
                    CREATE TYPE enum_billing_activity_logs_action_type AS ENUM (
                        'subscription_created',
                        'subscription_updated',
                        'subscription_canceled',
                        'subscription_reactivated',
                        'subscription_paused',
                        'subscription_resumed',
                        'plan_upgraded',
                        'plan_downgraded',
                        'trial_started',
                        'trial_extended',
                        'trial_ended',
                        'payment_attempted',
                        'payment_succeeded',
                        'payment_failed',
                        'payment_refunded',
                        'invoice_created',
                        'invoice_sent',
                        'invoice_paid',
                        'invoice_voided',
                        'card_added',
                        'card_updated',
                        'card_removed',
                        'card_set_default',
                        'billing_info_updated',
                        'coupon_applied',
                        'coupon_removed',
                        'webhook_received',
                        'webhook_processed',
                        'notification_sent',
                        'dunning_started',
                        'dunning_escalated',
                        'dunning_resolved',
                        'admin_action',
                        'system_action'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_activity_logs_action_status') THEN
                    CREATE TYPE enum_billing_activity_logs_action_status AS ENUM (
                        'success',
                        'failed',
                        'pending',
                        'skipped'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_activity_logs_actor_type') THEN
                    CREATE TYPE enum_billing_activity_logs_actor_type AS ENUM (
                        'user',
                        'admin',
                        'system',
                        'stripe',
                        'cron'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar columns
        if (!Schema::hasTable('billing_activity_logs')) {
            Schema::create('billing_activity_logs', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid')->nullable();
                $table->unsignedBigInteger('subscription_id')->nullable();
                $table->unsignedBigInteger('transaction_id')->nullable();

                // TEMP strings → will be converted to ENUMs
                $table->string('action_type');
                $table->string('action_status')->default('success');
                $table->string('actor_type')->default('system');

                $table->text('description')->nullable();
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

            // 3️⃣ Drop defaults → Convert → Restore defaults
            DB::statement("
                ALTER TABLE billing_activity_logs
                ALTER COLUMN action_status DROP DEFAULT,
                ALTER COLUMN actor_type DROP DEFAULT;

                ALTER TABLE billing_activity_logs
                ALTER COLUMN action_type TYPE enum_billing_activity_logs_action_type
                USING action_type::enum_billing_activity_logs_action_type;

                ALTER TABLE billing_activity_logs
                ALTER COLUMN action_status TYPE enum_billing_activity_logs_action_status
                USING action_status::enum_billing_activity_logs_action_status;

                ALTER TABLE billing_activity_logs
                ALTER COLUMN actor_type TYPE enum_billing_activity_logs_actor_type
                USING actor_type::enum_billing_activity_logs_actor_type;

                ALTER TABLE billing_activity_logs
                ALTER COLUMN action_status SET DEFAULT 'success',
                ALTER COLUMN actor_type SET DEFAULT 'system';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_activity_logs');

        DB::statement("DROP TYPE IF EXISTS enum_billing_activity_logs_action_type");
        DB::statement("DROP TYPE IF EXISTS enum_billing_activity_logs_action_status");
        DB::statement("DROP TYPE IF EXISTS enum_billing_activity_logs_actor_type");
    }
};

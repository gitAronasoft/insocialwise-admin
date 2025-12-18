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
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_notifications_notification_type') THEN
                    CREATE TYPE enum_billing_notifications_notification_type AS ENUM (
                        'trial_ending_24h',
                        'trial_ending_1h',
                        'trial_ended',
                        'subscription_created',
                        'subscription_renewed',
                        'subscription_canceled',
                        'subscription_paused',
                        'subscription_resumed',
                        'renewal_reminder_7d',
                        'renewal_reminder_3d',
                        'renewal_reminder_1d',
                        'payment_succeeded',
                        'payment_failed',
                        'payment_failed_final',
                        'payment_method_expiring',
                        'payment_method_expired',
                        'invoice_created',
                        'invoice_paid',
                        'invoice_past_due',
                        'refund_processed',
                        'plan_upgraded',
                        'plan_downgraded',
                        'dunning_reminder'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_notifications_channel') THEN
                    CREATE TYPE enum_billing_notifications_channel AS ENUM (
                        'email', 'in_app', 'sms', 'push'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_notifications_priority') THEN
                    CREATE TYPE enum_billing_notifications_priority AS ENUM (
                        'low', 'normal', 'high', 'urgent'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_notifications_status') THEN
                    CREATE TYPE enum_billing_notifications_status AS ENUM (
                        'pending', 'queued', 'sent', 'delivered',
                        'failed', 'canceled', 'skipped'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar columns
        if (!Schema::hasTable('billing_notifications')) {
            Schema::create('billing_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid');
                $table->unsignedBigInteger('subscription_id')->nullable()->comment('Related subscription ID');
                $table->string('type');

                // TEMP strings → convert to ENUMs
                $table->string('notification_type');
                $table->string('channel')->default('email');
                $table->string('priority')->default('normal');
                $table->string('status')->default('pending');

                $table->string('title')->nullable();
                $table->text('message')->nullable();
                $table->string('recipient_email')->nullable();
                $table->string('subject')->nullable();
                $table->string('template_name')->nullable();
                $table->json('template_data')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamp('scheduled_at')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamp('read_at')->nullable();
                $table->timestamps();

                $table->index('user_uuid');
                $table->index('type');
                $table->index('status');
            });

            // 3️⃣ Drop defaults → Convert → Restore defaults
            DB::statement("
                ALTER TABLE billing_notifications
                ALTER COLUMN channel DROP DEFAULT,
                ALTER COLUMN priority DROP DEFAULT,
                ALTER COLUMN status DROP DEFAULT;

                ALTER TABLE billing_notifications
                ALTER COLUMN notification_type TYPE enum_billing_notifications_notification_type
                USING notification_type::enum_billing_notifications_notification_type;

                ALTER TABLE billing_notifications
                ALTER COLUMN channel TYPE enum_billing_notifications_channel
                USING channel::enum_billing_notifications_channel;

                ALTER TABLE billing_notifications
                ALTER COLUMN priority TYPE enum_billing_notifications_priority
                USING priority::enum_billing_notifications_priority;

                ALTER TABLE billing_notifications
                ALTER COLUMN status TYPE enum_billing_notifications_status
                USING status::enum_billing_notifications_status;

                ALTER TABLE billing_notifications
                ALTER COLUMN channel SET DEFAULT 'email',
                ALTER COLUMN priority SET DEFAULT 'normal',
                ALTER COLUMN status SET DEFAULT 'pending';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_notifications');

        DB::statement("DROP TYPE IF EXISTS enum_billing_notifications_notification_type");
        DB::statement("DROP TYPE IF EXISTS enum_billing_notifications_channel");
        DB::statement("DROP TYPE IF EXISTS enum_billing_notifications_priority");
        DB::statement("DROP TYPE IF EXISTS enum_billing_notifications_status");
    }
};

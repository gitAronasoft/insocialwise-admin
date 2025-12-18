<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        =====================================================
        payment_methods
        =====================================================
        */
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_payment_methods_type') THEN
                    CREATE TYPE enum_payment_methods_type AS ENUM (
                        'card','bank_account','sepa_debit','us_bank_account','link'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_payment_methods_funding') THEN
                    CREATE TYPE enum_payment_methods_funding AS ENUM (
                        'credit','debit','prepaid','unknown'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_payment_methods_status') THEN
                    CREATE TYPE enum_payment_methods_status AS ENUM (
                        'active','expired','deleted'
                    );
                END IF;
            END
            $$;
        ");

        DB::statement("
            ALTER TABLE payment_methods
            ALTER COLUMN type DROP DEFAULT,
            ALTER COLUMN status DROP DEFAULT;
        ");

        DB::statement("
            ALTER TABLE payment_methods
            ALTER COLUMN type TYPE enum_payment_methods_type
            USING type::enum_payment_methods_type;

            ALTER TABLE payment_methods
            ALTER COLUMN funding TYPE enum_payment_methods_funding
            USING funding::enum_payment_methods_funding;

            ALTER TABLE payment_methods
            ALTER COLUMN status TYPE enum_payment_methods_status
            USING status::enum_payment_methods_status;
        ");

        DB::statement("
            ALTER TABLE payment_methods
            ALTER COLUMN type SET DEFAULT 'card',
            ALTER COLUMN status SET DEFAULT 'active';
        ");


        /*
        =====================================================
        webhook_events
        =====================================================
        */
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_webhook_events_status') THEN
                    CREATE TYPE enum_webhook_events_status AS ENUM (
                        'received','processing','processed','failed','skipped','retrying'
                    );
                END IF;
            END
            $$;
        ");

        DB::statement("
            ALTER TABLE webhook_events
            ALTER COLUMN status DROP DEFAULT;
        ");

        DB::statement("
            ALTER TABLE webhook_events
            ALTER COLUMN status TYPE enum_webhook_events_status
            USING status::enum_webhook_events_status;
        ");

        DB::statement("
            ALTER TABLE webhook_events
            ALTER COLUMN status SET DEFAULT 'received';
        ");


        /*
        =====================================================
        billing_activity_logs
        =====================================================
        */
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_activity_logs_action_type') THEN
                    CREATE TYPE enum_billing_activity_logs_action_type AS ENUM (
                        'subscription_created','subscription_updated','subscription_canceled',
                        'subscription_reactivated','subscription_paused','subscription_resumed',
                        'plan_upgraded','plan_downgraded','trial_started','trial_extended',
                        'trial_ended','payment_attempted','payment_succeeded','payment_failed',
                        'payment_refunded','invoice_created','invoice_sent','invoice_paid',
                        'invoice_voided','card_added','card_updated','card_removed',
                        'card_set_default','billing_info_updated','coupon_applied',
                        'coupon_removed','webhook_received','webhook_processed',
                        'notification_sent','dunning_started','dunning_escalated',
                        'dunning_resolved','admin_action','system_action'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_activity_logs_action_status') THEN
                    CREATE TYPE enum_billing_activity_logs_action_status AS ENUM (
                        'success','failed','pending','skipped'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_activity_logs_actor_type') THEN
                    CREATE TYPE enum_billing_activity_logs_actor_type AS ENUM (
                        'user','admin','system','stripe','cron'
                    );
                END IF;
            END
            $$;
        ");

        DB::statement("
            ALTER TABLE billing_activity_logs
            ALTER COLUMN action_status DROP DEFAULT,
            ALTER COLUMN actor_type DROP DEFAULT;
        ");

        DB::statement("
            ALTER TABLE billing_activity_logs
            ALTER COLUMN action_type TYPE enum_billing_activity_logs_action_type
            USING action_type::enum_billing_activity_logs_action_type;

            ALTER TABLE billing_activity_logs
            ALTER COLUMN action_status TYPE enum_billing_activity_logs_action_status
            USING action_status::enum_billing_activity_logs_action_status;

            ALTER TABLE billing_activity_logs
            ALTER COLUMN actor_type TYPE enum_billing_activity_logs_actor_type
            USING actor_type::enum_billing_activity_logs_actor_type;
        ");

        DB::statement("
            ALTER TABLE billing_activity_logs
            ALTER COLUMN action_status SET DEFAULT 'success',
            ALTER COLUMN actor_type SET DEFAULT 'system';
        ");


        /*
        =====================================================
        billing_notifications
        =====================================================
        */
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_billing_notifications_status') THEN
                    CREATE TYPE enum_billing_notifications_status AS ENUM (
                        'pending','queued','sent','delivered','failed','canceled','skipped'
                    );
                END IF;
            END
            $$;
        ");

        DB::statement("
            ALTER TABLE billing_notifications
            ALTER COLUMN status DROP DEFAULT;
        ");

        DB::statement("
            ALTER TABLE billing_notifications
            ALTER COLUMN status TYPE enum_billing_notifications_status
            USING status::enum_billing_notifications_status;
        ");

        DB::statement("
            ALTER TABLE billing_notifications
            ALTER COLUMN status SET DEFAULT 'pending';
        ");


        /*
        =====================================================
        Remaining tables (simple enums)
        =====================================================
        */

       /*social_users */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_social_users_status') THEN
                    CREATE TYPE enum_social_users_status AS ENUM ('Connected','notConnected');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE social_users
            ALTER COLUMN status TYPE enum_social_users_status
            USING status::enum_social_users_status;
        ");

        /*social_page */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_social_page_status') THEN
                    CREATE TYPE enum_social_page_status AS ENUM ('notConnected','Connected');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE social_page
            ALTER COLUMN status TYPE enum_social_page_status
            USING status::enum_social_page_status;
        ");

        /*posts */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_posts_source') THEN
                    CREATE TYPE enum_posts_source AS ENUM ('Platform','API');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE posts
            ALTER COLUMN source TYPE enum_posts_source
            USING source::enum_posts_source;
        ");

        /* admin_settings */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_admin_settings_type') THEN
                    CREATE TYPE enum_admin_settings_type AS ENUM (
                        'string','integer','boolean','json','email','encrypted'
                    );
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE admin_settings
            ALTER COLUMN type TYPE enum_admin_settings_type
            USING type::enum_admin_settings_type;
        ");

        /* settings */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_settings_module_name') THEN
                    CREATE TYPE enum_settings_module_name AS ENUM (
                        'Comment','Message','Notification','User','System'
                    );
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE settings
            ALTER COLUMN module_name TYPE enum_settings_module_name
            USING module_name::enum_settings_module_name;
        ");

        /* notification */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_notification_is_read') THEN
                    CREATE TYPE enum_notification_is_read AS ENUM ('yes','no');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE notification
            ALTER COLUMN is_read TYPE enum_notification_is_read
            USING is_read::enum_notification_is_read;
        ");

        /* ads_accounts */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_ads_accounts_is_connected') THEN
                    CREATE TYPE enum_ads_accounts_is_connected AS ENUM ('notConnected','Connected');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE ads_accounts
            ALTER COLUMN is_connected TYPE enum_ads_accounts_is_connected
            USING is_connected::enum_ads_accounts_is_connected;
        ");

        /* demographics */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_demographics_platform') THEN
                    CREATE TYPE enum_demographics_platform AS ENUM (
                        'facebook','linkedin','instagram','NA'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_demographics_source') THEN
                    CREATE TYPE enum_demographics_source AS ENUM ('Sheet','API','NA');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE demographics
            ALTER COLUMN platform TYPE enum_demographics_platform
            USING platform::enum_demographics_platform;

            ALTER TABLE demographics
            ALTER COLUMN source TYPE enum_demographics_source
            USING source::enum_demographics_source;
        ");

        /* inbox_conversations */
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_inbox_conversations_social_platform') THEN
                    CREATE TYPE enum_inbox_conversations_social_platform AS ENUM (
                        'facebook','linkedin','instagram','NA'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_inbox_conversations_status') THEN
                    CREATE TYPE enum_inbox_conversations_status AS ENUM ('Active','InActive');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE inbox_conversations
            ALTER COLUMN social_platform TYPE enum_inbox_conversations_social_platform
            USING social_platform::enum_inbox_conversations_social_platform;

            ALTER TABLE inbox_conversations
            ALTER COLUMN status TYPE enum_inbox_conversations_status
            USING status::enum_inbox_conversations_status;
        ");

       /*inbox_messages*/
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_inbox_messages_sender_type') THEN
                    CREATE TYPE enum_inbox_messages_sender_type AS ENUM ('page','visitor');
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_inbox_messages_is_read') THEN
                    CREATE TYPE enum_inbox_messages_is_read AS ENUM ('yes','no');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE inbox_messages
            ALTER COLUMN sender_type TYPE enum_inbox_messages_sender_type
            USING sender_type::enum_inbox_messages_sender_type;

            ALTER TABLE inbox_messages
            ALTER COLUMN is_read TYPE enum_inbox_messages_is_read
            USING is_read::enum_inbox_messages_is_read;
        ");

       /*knowledge_base*/
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_knowledge_base_status') THEN
                    CREATE TYPE enum_knowledge_base_status AS ENUM ('notConnected','Connected');
                END IF;
            END $$;
        ");
        DB::statement("
            ALTER TABLE knowledge_base
            ALTER COLUMN status TYPE enum_knowledge_base_status
            USING status::enum_knowledge_base_status;
        ");
    }

    public function down(): void
    {
        // intentionally no rollback (data-safe)
    }
};

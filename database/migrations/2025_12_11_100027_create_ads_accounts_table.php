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
                IF NOT EXISTS (
                    SELECT 1 FROM pg_type WHERE typname = 'enum_ads_accounts_is_connected'
                ) THEN
                    CREATE TYPE enum_ads_accounts_is_connected AS ENUM (
                        'notConnected',
                        'Connected'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
        if (!Schema::hasTable('ads_accounts')) {
            Schema::create('ads_accounts', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('account_platform', 255)->nullable();
                $table->string('account_social_userid', 255)->nullable();
                $table->string('account_id', 255)->nullable();
                $table->string('account_name', 255)->nullable();
                $table->smallInteger('account_status')->default(0);

                // TEMP string → convert to ENUM
                $table->string('is_connected')->default('notConnected');

                $table->string('currency', 250)->nullable();
                $table->string('timezone_name', 250)->nullable();
                $table->string('timezone_offset_hours_utc', 250)->nullable();
                $table->bigInteger('amount_spent')->nullable();
                $table->bigInteger('balance')->nullable();
                $table->json('business_page_detail')->nullable();
                $table->bigInteger('min_campaign_group_spend_cap')->nullable();
                $table->bigInteger('spend_cap')->nullable();
                $table->timestamps();

                $table->index('user_uuid');
            });

            // 3️⃣ Drop default → Convert → Restore default
            DB::statement("
                ALTER TABLE ads_accounts
                ALTER COLUMN is_connected DROP DEFAULT;

                ALTER TABLE ads_accounts
                ALTER COLUMN is_connected TYPE enum_ads_accounts_is_connected
                USING is_connected::enum_ads_accounts_is_connected;

                ALTER TABLE ads_accounts
                ALTER COLUMN is_connected SET DEFAULT 'notConnected';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ads_accounts');

        DB::statement("DROP TYPE IF EXISTS enum_ads_accounts_is_connected");
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Create PostgreSQL ENUM types if not exist
        DB::statement("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_payment_methods_type') THEN
                    CREATE TYPE enum_payment_methods_type AS ENUM (
                        'card', 'bank_account', 'sepa_debit', 'us_bank_account', 'link'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_payment_methods_funding') THEN
                    CREATE TYPE enum_payment_methods_funding AS ENUM (
                        'credit', 'debit', 'prepaid', 'unknown'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_payment_methods_status') THEN
                    CREATE TYPE enum_payment_methods_status AS ENUM (
                        'active', 'expired', 'deleted'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table
        if (!Schema::hasTable('payment_methods')) {
            Schema::create('payment_methods', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid');
                $table->string('stripe_payment_method_id')->unique();
                $table->string('stripe_customer_id');

                // Temporary string columns (will be converted to ENUM)
                $table->string('type')->default('card');
                $table->string('brand')->nullable();
                $table->string('card_brand')->nullable();
                $table->string('last4', 4)->nullable();
                $table->string('card_last4', 4)->nullable();
                $table->integer('exp_month')->nullable();
                $table->integer('exp_year')->nullable();
                $table->string('card_holder_name')->nullable();
                $table->string('funding')->nullable();
                $table->string('country')->nullable();
                $table->json('billing_details')->nullable();
                $table->string('fingerprint')->nullable();
                $table->string('wallet')->nullable();
                $table->boolean('is_default')->default(false);
                $table->string('status')->default('active');
                $table->string('billing_email')->nullable();
                $table->string('billing_name')->nullable();
                $table->string('billing_phone')->nullable();
                $table->json('billing_address')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();

                $table->index('user_uuid');
                $table->index('stripe_customer_id');
            });

            // 3️⃣ Convert VARCHAR columns → PostgreSQL ENUM
            DB::statement("
    ALTER TABLE payment_methods
    ALTER COLUMN type DROP DEFAULT,
    ALTER COLUMN funding DROP DEFAULT,
    ALTER COLUMN status DROP DEFAULT;

    ALTER TABLE payment_methods
    ALTER COLUMN type TYPE enum_payment_methods_type
    USING type::enum_payment_methods_type;

    ALTER TABLE payment_methods
    ALTER COLUMN funding TYPE enum_payment_methods_funding
    USING funding::enum_payment_methods_funding;

    ALTER TABLE payment_methods
    ALTER COLUMN status TYPE enum_payment_methods_status
    USING status::enum_payment_methods_status;

    ALTER TABLE payment_methods
    ALTER COLUMN type SET DEFAULT 'card',
    ALTER COLUMN status SET DEFAULT 'active';
");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');

        DB::statement("DROP TYPE IF EXISTS enum_payment_methods_type");
        DB::statement("DROP TYPE IF EXISTS enum_payment_methods_funding");
        DB::statement("DROP TYPE IF EXISTS enum_payment_methods_status");
    }
};

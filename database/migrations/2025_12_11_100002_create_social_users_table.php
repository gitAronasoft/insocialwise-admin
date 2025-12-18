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
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_social_users_status') THEN
                    CREATE TYPE enum_social_users_status AS ENUM (
                        'Connected',
                        'notConnected'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
        if (!Schema::hasTable('social_users')) {
            Schema::create('social_users', function (Blueprint $table) {
                $table->id();
                $table->string('user_id', 250);
                $table->string('name', 100);
                $table->string('email', 200)->nullable();
                $table->string('img_url', 250)->nullable();
                $table->string('social_id', 200);
                $table->string('social_user_platform', 255)->nullable();
                $table->text('user_token');

                // TEMP string → convert to ENUM
                $table->string('status')->nullable()->default(null);

                $table->timestamps();

                $table->index('user_id');
                $table->index('social_id');
            });

            // 3️⃣ Convert VARCHAR → ENUM (no default to drop because it's NULL)
            DB::statement("
                ALTER TABLE social_users
                ALTER COLUMN status TYPE enum_social_users_status
                USING status::enum_social_users_status;
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('social_users');

        DB::statement("DROP TYPE IF EXISTS enum_social_users_status");
    }
};

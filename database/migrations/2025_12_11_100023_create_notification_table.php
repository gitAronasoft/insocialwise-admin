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
                    SELECT 1 FROM pg_type WHERE typname = 'enum_notification_is_read'
                ) THEN
                    CREATE TYPE enum_notification_is_read AS ENUM (
                        'no',
                        'yes'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
        if (!Schema::hasTable('notification')) {
            Schema::create('notification', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('social_userid', 255)->nullable();
                $table->string('accountplatform', 255)->nullable();
                $table->string('notificationtype', 255)->nullable();
                $table->string('notificationtype_id', 255)->nullable();
                $table->string('page_or_post_id', 255)->nullable();

                // TEMP string → convert to ENUM
                $table->string('is_read')->default('no');

                $table->timestamp('notification_datetime')->nullable();
                $table->timestamps();

                $table->index('user_uuid');
            });

            // 3️⃣ Drop default → Convert → Restore default
            DB::statement("
                ALTER TABLE notification
                ALTER COLUMN is_read DROP DEFAULT;

                ALTER TABLE notification
                ALTER COLUMN is_read TYPE enum_notification_is_read
                USING is_read::enum_notification_is_read;

                ALTER TABLE notification
                ALTER COLUMN is_read SET DEFAULT 'no';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notification');

        DB::statement("DROP TYPE IF EXISTS enum_notification_is_read");
    }
};

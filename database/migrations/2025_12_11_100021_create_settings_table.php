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
                    SELECT 1 FROM pg_type WHERE typname = 'enum_settings_module_name'
                ) THEN
                    CREATE TYPE enum_settings_module_name AS ENUM (
                        'Comment',
                        'Message',
                        'Notification',
                        'User',
                        'System'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();

                // TEMP string → convert to ENUM
                $table->string('module_name')->default('Comment');

                $table->smallInteger('module_status')->default(0);
                $table->timestamps();

                $table->index('user_uuid');
            });

            // 3️⃣ Drop default → Convert → Restore default
            DB::statement("
                ALTER TABLE settings
                ALTER COLUMN module_name DROP DEFAULT;

                ALTER TABLE settings
                ALTER COLUMN module_name TYPE enum_settings_module_name
                USING module_name::enum_settings_module_name;

                ALTER TABLE settings
                ALTER COLUMN module_name SET DEFAULT 'Comment';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');

        DB::statement("DROP TYPE IF EXISTS enum_settings_module_name");
    }
};

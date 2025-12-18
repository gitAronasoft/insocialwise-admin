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
                    SELECT 1 FROM pg_type WHERE typname = 'enum_admin_settings_type'
                ) THEN
                    CREATE TYPE enum_admin_settings_type AS ENUM (
                        'string',
                        'integer',
                        'boolean',
                        'json',
                        'email',
                        'encrypted'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
        if (!Schema::hasTable('admin_settings')) {
            Schema::create('admin_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 255)->unique();
                $table->text('value')->nullable();

                // TEMP string → convert to ENUM
                $table->string('type')->default('string');

                $table->string('group')->default('general');
                $table->text('description')->nullable();
                $table->string('section', 255)->nullable();
                $table->timestamps();
            });

            // 3️⃣ Drop default → Convert → Restore default
            DB::statement("
                ALTER TABLE admin_settings
                ALTER COLUMN type DROP DEFAULT;

                ALTER TABLE admin_settings
                ALTER COLUMN type TYPE enum_admin_settings_type
                USING type::enum_admin_settings_type;

                ALTER TABLE admin_settings
                ALTER COLUMN type SET DEFAULT 'string';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_settings');

        DB::statement("DROP TYPE IF EXISTS enum_admin_settings_type");
    }
};

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
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_demographics_platform') THEN
                    CREATE TYPE enum_demographics_platform AS ENUM (
                        'facebook',
                        'linkedin',
                        'instagram',
                        'NA'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_demographics_source') THEN
                    CREATE TYPE enum_demographics_source AS ENUM (
                        'Sheet',
                        'API',
                        'NA'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar columns
        if (!Schema::hasTable('demographics')) {
            Schema::create('demographics', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255);
                $table->string('platform_page_id', 255);
                $table->string('page_name', 255);
                $table->string('social_userid', 255);

                // TEMP strings → convert to ENUMs
                $table->string('platform')->default('NA');
                $table->string('metric_type', 200)->nullable();
                $table->string('metric_key', 250)->nullable();
                $table->bigInteger('metric_value')->default(0);
                $table->string('source')->default('NA');

                $table->timestamps();

                $table->index('user_uuid');
            });

            // 3️⃣ Drop defaults → Convert → Restore defaults
            DB::statement("
                ALTER TABLE demographics
                ALTER COLUMN platform DROP DEFAULT,
                ALTER COLUMN source DROP DEFAULT;

                ALTER TABLE demographics
                ALTER COLUMN platform TYPE enum_demographics_platform
                USING platform::enum_demographics_platform;

                ALTER TABLE demographics
                ALTER COLUMN source TYPE enum_demographics_source
                USING source::enum_demographics_source;

                ALTER TABLE demographics
                ALTER COLUMN platform SET DEFAULT 'NA',
                ALTER COLUMN source SET DEFAULT 'NA';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('demographics');

        DB::statement("DROP TYPE IF EXISTS enum_demographics_platform");
        DB::statement("DROP TYPE IF EXISTS enum_demographics_source");
    }
};

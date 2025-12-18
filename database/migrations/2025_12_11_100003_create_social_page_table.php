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
                    SELECT 1 FROM pg_type WHERE typname = 'enum_social_page_status'
                ) THEN
                    CREATE TYPE enum_social_page_status AS ENUM (
                        'notConnected',
                        'Connected'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
        if (!Schema::hasTable('social_page')) {
            Schema::create('social_page', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('social_userid', 250);
                $table->string('pagename', 150);
                $table->text('page_picture')->nullable();
                $table->text('page_cover')->nullable();
                $table->string('page_id', 150);
                $table->text('token');
                $table->string('category', 100)->nullable();
                $table->bigInteger('total_followers')->default(0);
                $table->string('page_platform', 255)->nullable();

                // TEMP string → convert to ENUM
                $table->string('status')->default('notConnected');

                $table->string('platform', 255)->nullable();
                $table->text('modify_to')->nullable();
                $table->timestamps();

                $table->index('user_uuid');
                $table->index('page_id'); // fixed index column name
            });

            // 3️⃣ Drop default → Convert → Restore default
            DB::statement("
                ALTER TABLE social_page
                ALTER COLUMN status DROP DEFAULT;

                ALTER TABLE social_page
                ALTER COLUMN status TYPE enum_social_page_status
                USING status::enum_social_page_status;

                ALTER TABLE social_page
                ALTER COLUMN status SET DEFAULT 'notConnected';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('social_page');

        DB::statement("DROP TYPE IF EXISTS enum_social_page_status");
    }
};

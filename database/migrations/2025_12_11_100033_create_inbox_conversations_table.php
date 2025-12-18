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
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_inbox_conversations_social_platform') THEN
                    CREATE TYPE enum_inbox_conversations_social_platform AS ENUM (
                        'facebook',
                        'linkedin',
                        'instagram',
                        'NA'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_inbox_conversations_status') THEN
                    CREATE TYPE enum_inbox_conversations_status AS ENUM (
                        'Active',
                        'InActive'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar columns
        if (!Schema::hasTable('inbox_conversations')) {
            Schema::create('inbox_conversations', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 250);
                $table->string('social_userid', 200);
                $table->string('social_pageid', 250);

                // TEMP strings → convert to ENUMs
                $table->string('social_platform')->default('NA');

                $table->string('conversation_id', 200);
                $table->string('external_userid', 200);
                $table->string('external_username', 200)->nullable();
                $table->string('external_userimg', 250)->nullable();
                $table->string('snippet', 250);

                // TEMP string → convert to ENUM
                $table->string('status')->default('InActive');

                $table->timestamps();

                $table->index('user_uuid');
                $table->index('conversation_id');
            });

            // 3️⃣ Drop defaults → Convert → Restore defaults
            DB::statement("
                ALTER TABLE inbox_conversations
                ALTER COLUMN social_platform DROP DEFAULT,
                ALTER COLUMN status DROP DEFAULT;

                ALTER TABLE inbox_conversations
                ALTER COLUMN social_platform TYPE enum_inbox_conversations_social_platform
                USING social_platform::enum_inbox_conversations_social_platform;

                ALTER TABLE inbox_conversations
                ALTER COLUMN status TYPE enum_inbox_conversations_status
                USING status::enum_inbox_conversations_status;

                ALTER TABLE inbox_conversations
                ALTER COLUMN social_platform SET DEFAULT 'NA',
                ALTER COLUMN status SET DEFAULT 'InActive';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inbox_conversations');

        DB::statement("DROP TYPE IF EXISTS enum_inbox_conversations_social_platform");
        DB::statement("DROP TYPE IF EXISTS enum_inbox_conversations_status");
    }
};

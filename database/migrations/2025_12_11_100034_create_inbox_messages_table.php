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
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_inbox_messages_sender_type') THEN
                    CREATE TYPE enum_inbox_messages_sender_type AS ENUM (
                        'page',
                        'visitor'
                    );
                END IF;

                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_inbox_messages_is_read') THEN
                    CREATE TYPE enum_inbox_messages_is_read AS ENUM (
                        'yes',
                        'no'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar columns
        if (!Schema::hasTable('inbox_messages')) {
            Schema::create('inbox_messages', function (Blueprint $table) {
                $table->id();
                $table->string('conversation_id', 200);
                $table->string('platform_message_id', 200);

                // TEMP strings → convert to ENUMs
                $table->string('sender_type')->default('page');

                $table->text('message_text');
                $table->string('message_type', 250);

                // TEMP string → convert to ENUM
                $table->string('is_read')->default('yes');

                $table->string('timestamp', 200)->nullable();
                $table->timestamps();

                $table->index('conversation_id');
            });

            // 3️⃣ Drop defaults → Convert → Restore defaults
            DB::statement("
                ALTER TABLE inbox_messages
                ALTER COLUMN sender_type DROP DEFAULT,
                ALTER COLUMN is_read DROP DEFAULT;

                ALTER TABLE inbox_messages
                ALTER COLUMN sender_type TYPE enum_inbox_messages_sender_type
                USING sender_type::enum_inbox_messages_sender_type;

                ALTER TABLE inbox_messages
                ALTER COLUMN is_read TYPE enum_inbox_messages_is_read
                USING is_read::enum_inbox_messages_is_read;

                ALTER TABLE inbox_messages
                ALTER COLUMN sender_type SET DEFAULT 'page',
                ALTER COLUMN is_read SET DEFAULT 'yes';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inbox_messages');

        DB::statement("DROP TYPE IF EXISTS enum_inbox_messages_sender_type");
        DB::statement("DROP TYPE IF EXISTS enum_inbox_messages_is_read");
    }
};

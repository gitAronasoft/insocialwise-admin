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
                    SELECT 1 FROM pg_type WHERE typname = 'enum_knowledge_base_status'
                ) THEN
                    CREATE TYPE enum_knowledge_base_status AS ENUM (
                        'notConnected',
                        'Connected'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
        if (!Schema::hasTable('knowledge_base')) {
            Schema::create('knowledge_base', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('knowledgeBase_title', 255)->nullable();
                $table->text('knowledgeBase_content')->nullable();
                $table->string('social_platform', 100)->nullable();
                $table->text('social_data_detail')->nullable();

                // TEMP string → convert to ENUM
                $table->string('status')->default('notConnected');

                $table->timestamps();

                $table->index('user_uuid');
            });

            // 3️⃣ Drop default → Convert → Restore default
            DB::statement("
                ALTER TABLE knowledge_base
                ALTER COLUMN status DROP DEFAULT;

                ALTER TABLE knowledge_base
                ALTER COLUMN status TYPE enum_knowledge_base_status
                USING status::enum_knowledge_base_status;

                ALTER TABLE knowledge_base
                ALTER COLUMN status SET DEFAULT 'notConnected';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_base');

        DB::statement("DROP TYPE IF EXISTS enum_knowledge_base_status");
    }
};

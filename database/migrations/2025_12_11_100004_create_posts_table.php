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
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'enum_posts_source') THEN
                    CREATE TYPE enum_posts_source AS ENUM (
                        'Platform',
                        'API'
                    );
                END IF;
            END
            $$;
        ");

        // 2️⃣ Create table with TEMP varchar column
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('social_user_id', 200);
                $table->string('page_id', 150);
                $table->text('content');
                $table->bigInteger('schedule_time')->nullable();
                $table->text('post_media')->nullable();
                $table->string('platform_post_id', 255)->nullable();
                $table->string('post_platform', 255)->nullable();

                // TEMP string → convert to ENUM
                $table->string('source')->default('Platform');

                $table->string('form_id', 250);
                $table->bigInteger('likes')->default(0);
                $table->bigInteger('comments')->default(0);
                $table->bigInteger('shares')->default(0);
                $table->decimal('engagements', 10, 2)->default(0);
                $table->bigInteger('impressions')->default(0);
                $table->bigInteger('unique_impressions')->default(0);
                $table->string('week_date', 255)->nullable();
                $table->smallInteger('status')->default(0);
                $table->timestamps();

                $table->index('user_uuid');
                $table->index('page_id');
            });

            // 3️⃣ Drop default → Convert → Restore default
            DB::statement("
                ALTER TABLE posts
                ALTER COLUMN source DROP DEFAULT;

                ALTER TABLE posts
                ALTER COLUMN source TYPE enum_posts_source
                USING source::enum_posts_source;

                ALTER TABLE posts
                ALTER COLUMN source SET DEFAULT 'Platform';
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');

        DB::statement("DROP TYPE IF EXISTS enum_posts_source");
    }
};

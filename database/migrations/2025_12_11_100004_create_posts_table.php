<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
                $table->enum('source', ['Platform', 'API'])->default('Platform');
                $table->string('form_id', 250);
                $table->bigInteger('likes')->default(0);
                $table->bigInteger('comments')->default(0);
                $table->bigInteger('shares')->default(0);
                $table->bigInteger('engagements')->default(0);
                $table->bigInteger('impressions')->default(0);
                $table->bigInteger('unique_impressions')->default(0);
                $table->string('week_date', 255)->nullable();
                $table->smallInteger('status')->default(0);
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('page_id');
            });
        }
    }

    public function down(): void
    {
    }
};

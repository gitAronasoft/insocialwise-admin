<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('social_media_page_score')) {
            Schema::create('social_media_page_score', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('social_score_id');
                $table->string('user_uuid', 255);
                $table->string('platform_name', 100);
                $table->string('page_id', 255);
                $table->string('page_name', 255)->nullable();
                $table->date('score_date');
                $table->decimal('score', 10, 2)->nullable();
                $table->bigInteger('engagement')->nullable();
                $table->bigInteger('reach')->nullable();
                $table->bigInteger('shares')->nullable();
                $table->decimal('follower_growth_percent', 10, 2)->nullable();
                $table->json('recommendations')->nullable();
                $table->decimal('overall_score', 10, 2)->nullable();
                $table->decimal('content_score', 10, 2)->nullable();
                $table->decimal('engagement_score', 10, 2)->nullable();
                $table->decimal('growth_score', 10, 2)->nullable();
                $table->decimal('consistency_score', 10, 2)->nullable();
                $table->timestamp('calculated_at')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('social_score_id');
            });
        }
    }

    public function down(): void
    {
    }
};

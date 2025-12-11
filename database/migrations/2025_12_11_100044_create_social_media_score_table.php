<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('social_media_score')) {
            Schema::create('social_media_score', function (Blueprint $table) {
                $table->id();
                $table->char('user_uuid', 36);
                $table->date('score_date');
                $table->decimal('total_score', 10, 2)->nullable();
                $table->bigInteger('total_engagement')->nullable();
                $table->bigInteger('total_reach')->nullable();
                $table->bigInteger('total_shares')->nullable();
                $table->decimal('follower_growth_percent', 10, 2)->nullable();
                $table->bigInteger('total_pages')->nullable();
                $table->json('recommendations')->nullable();
                $table->decimal('overall_score', 10, 2)->nullable();
                $table->decimal('content_score', 10, 2)->nullable();
                $table->decimal('engagement_score', 10, 2)->nullable();
                $table->decimal('growth_score', 10, 2)->nullable();
                $table->decimal('consistency_score', 10, 2)->nullable();
                $table->timestamp('calculated_at')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

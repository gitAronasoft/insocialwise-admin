<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('analytics')) {
            Schema::create('analytics', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('platform_page_id', 255)->nullable();
                $table->string('platform', 255)->nullable();
                $table->string('analytic_type', 255)->nullable();
                $table->bigInteger('total_page_followers')->nullable();
                $table->bigInteger('total_page_impressions')->nullable();
                $table->bigInteger('total_page_impressions_unique')->nullable();
                $table->bigInteger('total_page_views')->nullable();
                $table->bigInteger('page_post_engagements')->nullable();
                $table->bigInteger('page_actions_post_reactions_like_total')->nullable();
                $table->string('week_date', 255)->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('platform_page_id');
            });
        }
    }

    public function down(): void
    {
    }
};

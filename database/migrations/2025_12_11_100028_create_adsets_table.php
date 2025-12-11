<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('adsets')) {
            Schema::create('adsets', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('account_platform', 255)->nullable();
                $table->string('account_social_userid', 255)->nullable();
                $table->bigInteger('adsets_campaign_id')->nullable();
                $table->bigInteger('adsets_id')->nullable();
                $table->string('adsets_name', 255)->nullable();
                $table->json('adsets_countries')->nullable();
                $table->json('adsets_regions')->nullable();
                $table->json('adsets_cities')->nullable();
                $table->bigInteger('adsets_age_min')->nullable();
                $table->bigInteger('adsets_age_max')->nullable();
                $table->json('adsets_genders')->nullable();
                $table->json('adsets_publisher_platforms')->nullable();
                $table->json('adsets_facebook_positions')->nullable();
                $table->json('adsets_instagram_positions')->nullable();
                $table->json('adsets_device_platforms')->nullable();
                $table->timestamp('adsets_start_time')->nullable();
                $table->timestamp('adsets_end_time')->nullable();
                $table->smallInteger('adsets_status')->default(0);
                $table->string('adsets_insights_impressions', 255)->nullable();
                $table->string('adsets_insights_clicks', 255)->nullable();
                $table->string('adsets_insights_cpc', 255)->nullable();
                $table->string('adsets_insights_cpm', 255)->nullable();
                $table->string('adsets_insights_ctr', 255)->nullable();
                $table->string('adsets_insights_spend', 255)->nullable();
                $table->string('adsets_daily_budget', 255)->nullable();
                $table->string('adsets_lifetime_budget', 255)->nullable();
                $table->date('adsets_insights_date_start')->nullable();
                $table->date('adsets_insights_date_stop')->nullable();
                $table->string('adsets_insights_reach', 255)->nullable();
                $table->bigInteger('adsets_insights_results')->nullable();
                $table->string('adsets_result_type', 255)->nullable();
                $table->double('adsets_insights_cost_per_result')->nullable();
                $table->json('adsets_insights_actions')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

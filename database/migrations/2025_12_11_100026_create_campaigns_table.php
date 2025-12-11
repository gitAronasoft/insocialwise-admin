<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('campaigns')) {
            Schema::create('campaigns', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('account_platform', 255)->nullable();
                $table->bigInteger('account_social_userid')->nullable();
                $table->bigInteger('ad_account_id')->nullable();
                $table->string('campaign_id', 255)->nullable();
                $table->string('campaign_name', 255)->nullable();
                $table->string('campaign_category', 255)->nullable();
                $table->string('campaign_bid_strategy', 255)->nullable();
                $table->string('campaign_buying_type', 255)->nullable();
                $table->string('campaign_objective', 255)->nullable();
                $table->string('campaign_budget_remaining', 255)->nullable();
                $table->string('campaign_daily_budget', 255)->nullable();
                $table->string('campaign_lifetime_budget', 255)->nullable();
                $table->string('campaign_effective_status', 255)->nullable();
                $table->timestamp('campaign_start_time')->nullable();
                $table->timestamp('campaign_end_time')->nullable();
                $table->smallInteger('campaign_status')->default(0);
                $table->bigInteger('campaign_insights_clicks')->nullable();
                $table->string('campaign_insights_cpc', 255)->nullable();
                $table->string('campaign_insights_cpm', 255)->nullable();
                $table->string('campaign_insights_cpp', 255)->nullable();
                $table->string('campaign_insights_ctr', 255)->nullable();
                $table->date('campaign_insights_date_start')->nullable();
                $table->date('campaign_insights_date_stop')->nullable();
                $table->string('campaign_insights_impressions', 255)->nullable();
                $table->string('campaign_insights_spend', 255)->nullable();
                $table->bigInteger('campaign_insights_reach')->nullable();
                $table->double('campaign_insights_results')->nullable();
                $table->string('campaign_result_type', 255)->nullable();
                $table->double('campaign_insights_cost_per_result')->nullable();
                $table->json('campaign_insights_actions')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('campaign_id');
            });
        }
    }

    public function down(): void
    {
    }
};

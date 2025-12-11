<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('adsets_ads')) {
            Schema::create('adsets_ads', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('account_platform', 255)->nullable();
                $table->string('account_social_userid', 255)->nullable();
                $table->bigInteger('campaign_id')->nullable();
                $table->bigInteger('adsets_id')->nullable();
                $table->bigInteger('ads_id')->nullable();
                $table->string('ads_name', 255)->nullable();
                $table->smallInteger('ads_status')->default(0);
                $table->string('ads_effective_status', 255)->nullable();
                $table->string('ads_insights_impressions', 255)->nullable();
                $table->string('ads_insights_clicks', 255)->nullable();
                $table->string('ads_insights_cpc', 255)->nullable();
                $table->string('ads_insights_cpm', 255)->nullable();
                $table->string('ads_insights_ctr', 255)->nullable();
                $table->string('ads_insights_spend', 255)->nullable();
                $table->string('ads_insights_reach', 255)->nullable();
                $table->date('ads_insights_date_start')->nullable();
                $table->date('ads_insights_date_stop')->nullable();
                $table->string('ads_insights_cost_per_result', 255)->nullable();
                $table->string('ads_result_type', 255)->nullable();
                $table->json('ads_insights_actions')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

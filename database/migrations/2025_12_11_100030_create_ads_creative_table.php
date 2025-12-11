<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ads_creative')) {
            Schema::create('ads_creative', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('account_platform', 255)->nullable();
                $table->string('social_page_id', 250)->nullable();
                $table->string('account_social_userid', 255)->nullable();
                $table->string('campaign_id', 255)->nullable();
                $table->string('adset_id', 255)->nullable();
                $table->string('ad_id', 255)->nullable();
                $table->string('creative_id', 255)->nullable();
                $table->string('creative_type', 255)->nullable();
                $table->json('image_urls')->nullable();
                $table->json('video_thumbnails')->nullable();
                $table->string('headline', 255)->nullable();
                $table->text('body')->nullable();
                $table->string('call_to_action', 100)->nullable();
                $table->string('call_to_action_link', 255)->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

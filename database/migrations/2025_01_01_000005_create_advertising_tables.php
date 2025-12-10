<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->string('platform');
            $table->string('account_id');
            $table->string('name');
            $table->string('currency', 3)->default('USD');
            $table->string('timezone')->nullable();
            $table->enum('status', ['active', 'disabled', 'pending_review'])->default('active');
            $table->decimal('spend_cap', 12, 2)->nullable();
            $table->decimal('amount_spent', 12, 2)->default(0);
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->unique(['user_uuid', 'platform', 'account_id']);
        });

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ads_account_id');
            $table->string('platform_campaign_id')->nullable();
            $table->string('name');
            $table->string('objective')->nullable();
            $table->enum('status', ['active', 'paused', 'archived', 'deleted'])->default('active');
            $table->decimal('budget', 12, 2)->nullable();
            $table->enum('budget_type', ['daily', 'lifetime'])->default('daily');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->decimal('spend', 12, 2)->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->integer('conversions')->default(0);
            $table->decimal('ctr', 5, 4)->default(0);
            $table->decimal('cpc', 10, 2)->default(0);
            $table->decimal('cpm', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('ads_account_id')->references('id')->on('ads_accounts')->onDelete('cascade');
        });

        Schema::create('adsets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->string('platform_adset_id')->nullable();
            $table->string('name');
            $table->enum('status', ['active', 'paused', 'archived', 'deleted'])->default('active');
            $table->decimal('budget', 12, 2)->nullable();
            $table->enum('budget_type', ['daily', 'lifetime'])->nullable();
            $table->json('targeting')->nullable();
            $table->string('optimization_goal')->nullable();
            $table->string('billing_event')->nullable();
            $table->decimal('bid_amount', 10, 2)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->decimal('spend', 12, 2)->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->integer('reach')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });

        Schema::create('ads_creative', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('creative_type');
            $table->text('headline')->nullable();
            $table->text('body')->nullable();
            $table->string('call_to_action')->nullable();
            $table->string('link_url')->nullable();
            $table->json('media_urls')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->timestamps();
        });

        Schema::create('adsets_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adset_id');
            $table->unsignedBigInteger('creative_id')->nullable();
            $table->string('platform_ad_id')->nullable();
            $table->string('name');
            $table->enum('status', ['active', 'paused', 'archived', 'deleted', 'pending_review'])->default('active');
            $table->decimal('spend', 12, 2)->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->integer('conversions')->default(0);
            $table->decimal('ctr', 5, 4)->default(0);
            $table->decimal('cpc', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('adset_id')->references('id')->on('adsets')->onDelete('cascade');
            $table->foreign('creative_id')->references('id')->on('ads_creative')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adsets_ads');
        Schema::dropIfExists('ads_creative');
        Schema::dropIfExists('adsets');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('ads_accounts');
    }
};

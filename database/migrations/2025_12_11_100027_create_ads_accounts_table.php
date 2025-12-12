<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ads_accounts')) {
            Schema::create('ads_accounts', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('account_platform', 255)->nullable();
                $table->string('account_social_userid', 255)->nullable();
                $table->string('account_id', 255)->nullable();
                $table->string('account_name', 255)->nullable();
                $table->smallInteger('account_status')->default(0);               
                $table->enum('is_connected', ['notConnected', 'Connected'])
                      ->default('notConnected');
                $table->string('currency', 250)->nullable();
                $table->string('timezone_name', 250)->nullable();
                $table->string('timezone_offset_hours_utc', 250)->nullable();
                $table->bigInteger('amount_spent')->nullable();
                $table->bigInteger('balance')->nullable();
                $table->json('business_page_detail')->nullable();
                $table->bigInteger('min_campaign_group_spend_cap')->nullable();
                $table->bigInteger('spend_cap')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('subscription_plans')) {
            Schema::create('subscription_plans', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('slug', 255)->nullable();
                $table->string('stripe_price_id', 255)->nullable();
                $table->string('stripe_yearly_price_id', 255)->nullable();
                $table->string('stripe_product_id', 255)->nullable();
                $table->decimal('price', 10, 2);
                $table->decimal('monthly_price_usd', 10, 2);
                $table->decimal('yearly_price_usd', 10, 2)->nullable();
                $table->decimal('monthly_price_inr', 10, 2);
                $table->decimal('yearly_price_inr', 10, 2)->nullable();
                $table->decimal('yearly_price', 10, 2)->nullable();
                $table->bigInteger('yearly_discount_percent')->default(0);
                $table->string('currency', 3)->default('USD');
                $table->string('billing_cycle', 50)->default('monthly');
                $table->json('features')->nullable();
                $table->json('display_features')->nullable();
                $table->text('description')->nullable();
                $table->bigInteger('max_social_accounts')->nullable();
                $table->bigInteger('max_team_members')->nullable();
                $table->bigInteger('max_scheduled_posts')->nullable();
                $table->bigInteger('ai_tokens_per_month')->default(0);
                $table->smallInteger('ai_auto_comment_reply')->default(0);
                $table->smallInteger('ai_auto_dm_reply')->default(0);
                $table->smallInteger('ai_semantic_analysis')->default(0);
                $table->smallInteger('ai_driven_reporting')->default(0);
                $table->smallInteger('ai_content_generator')->default(0);
                $table->smallInteger('calendar_scheduling')->default(0);
                $table->smallInteger('social_profile_score')->default(0);
                $table->smallInteger('unified_inbox')->default(0);
                $table->smallInteger('export_reports')->default(0);
                $table->smallInteger('white_label')->default(0);
                $table->smallInteger('fb_ads_analytics')->default(0);
                $table->smallInteger('fb_ads_creation')->default(0);
                $table->smallInteger('team_roles_permissions')->default(0);
                $table->smallInteger('client_workspaces')->default(0);
                $table->string('support_level', 255)->default('email');
                $table->json('platform_limits')->nullable();
                $table->smallInteger('active')->default(1);
                $table->smallInteger('is_featured')->default(0);
                $table->bigInteger('trial_period_days')->nullable();
                $table->smallInteger('trial_enabled')->default(0);
                $table->smallInteger('skip_trial_discount_enabled')->default(0);
                $table->bigInteger('skip_trial_discount_percent')->default(0);
                $table->smallInteger('is_contact_only')->default(0);
                $table->smallInteger('show_on_landing')->default(1);
                $table->bigInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

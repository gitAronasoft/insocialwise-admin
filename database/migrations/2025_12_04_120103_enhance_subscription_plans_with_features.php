<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            
            $table->decimal('monthly_price_usd', 10, 2)->default(0)->after('price');
            $table->decimal('yearly_price_usd', 10, 2)->nullable()->after('monthly_price_usd');
            $table->decimal('monthly_price_inr', 10, 2)->default(0)->after('yearly_price_usd');
            $table->decimal('yearly_price_inr', 10, 2)->nullable()->after('monthly_price_inr');
            
            $table->integer('ai_tokens_per_month')->default(0)->after('max_scheduled_posts');
            
            $table->boolean('ai_auto_comment_reply')->default(false)->after('ai_tokens_per_month');
            $table->boolean('ai_auto_dm_reply')->default(false)->after('ai_auto_comment_reply');
            $table->boolean('ai_semantic_analysis')->default(false)->after('ai_auto_dm_reply');
            $table->boolean('ai_driven_reporting')->default(false)->after('ai_semantic_analysis');
            $table->boolean('ai_content_generator')->default(false)->after('ai_driven_reporting');
            $table->string('social_profile_score')->default('none')->after('ai_content_generator');
            
            $table->string('calendar_scheduling')->default('none')->after('social_profile_score');
            $table->boolean('unified_inbox')->default(false)->after('calendar_scheduling');
            $table->string('export_reports')->default('none')->after('unified_inbox');
            $table->boolean('white_label')->default(false)->after('export_reports');
            $table->boolean('fb_ads_analytics')->default(false)->after('white_label');
            $table->boolean('fb_ads_creation')->default(false)->after('fb_ads_analytics');
            $table->boolean('team_roles_permissions')->default(false)->after('fb_ads_creation');
            $table->boolean('client_workspaces')->default(false)->after('team_roles_permissions');
            
            $table->json('display_features')->nullable()->after('features');
            
            $table->string('support_level')->default('standard')->after('client_workspaces');
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $columns = [
                'slug',
                'monthly_price_usd',
                'yearly_price_usd',
                'monthly_price_inr',
                'yearly_price_inr',
                'ai_tokens_per_month',
                'ai_auto_comment_reply',
                'ai_auto_dm_reply',
                'ai_semantic_analysis',
                'ai_driven_reporting',
                'ai_content_generator',
                'social_profile_score',
                'calendar_scheduling',
                'unified_inbox',
                'export_reports',
                'white_label',
                'fb_ads_analytics',
                'fb_ads_creation',
                'team_roles_permissions',
                'client_workspaces',
                'display_features',
                'support_level',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('subscription_plans', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

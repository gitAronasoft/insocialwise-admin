<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_plans', 'max_social_accounts')) {
                $table->integer('max_social_accounts')->nullable()->after('description');
            }
            if (!Schema::hasColumn('subscription_plans', 'max_team_members')) {
                $table->integer('max_team_members')->nullable()->after('max_social_accounts');
            }
            if (!Schema::hasColumn('subscription_plans', 'max_scheduled_posts')) {
                $table->integer('max_scheduled_posts')->nullable()->after('max_team_members');
            }
            if (!Schema::hasColumn('subscription_plans', 'platform_limits')) {
                $table->json('platform_limits')->nullable()->after('max_scheduled_posts');
            }
            if (!Schema::hasColumn('subscription_plans', 'yearly_price')) {
                $table->decimal('yearly_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('subscription_plans', 'yearly_discount_percent')) {
                $table->integer('yearly_discount_percent')->default(0)->after('yearly_price');
            }
            if (!Schema::hasColumn('subscription_plans', 'stripe_yearly_price_id')) {
                $table->string('stripe_yearly_price_id')->nullable()->after('stripe_price_id');
            }
            if (!Schema::hasColumn('subscription_plans', 'trial_enabled')) {
                $table->boolean('trial_enabled')->default(false)->after('trial_period_days');
            }
            if (!Schema::hasColumn('subscription_plans', 'skip_trial_discount_enabled')) {
                $table->boolean('skip_trial_discount_enabled')->default(false)->after('trial_enabled');
            }
            if (!Schema::hasColumn('subscription_plans', 'skip_trial_discount_percent')) {
                $table->integer('skip_trial_discount_percent')->default(0)->after('skip_trial_discount_enabled');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $columns = [
                'max_social_accounts',
                'max_team_members', 
                'max_scheduled_posts',
                'platform_limits',
                'yearly_price',
                'yearly_discount_percent',
                'stripe_yearly_price_id',
                'trial_enabled',
                'skip_trial_discount_enabled',
                'skip_trial_discount_percent',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('subscription_plans', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

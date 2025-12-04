<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->integer('max_social_accounts')->nullable()->after('description');
            $table->integer('max_team_members')->nullable()->after('max_social_accounts');
            $table->integer('max_scheduled_posts')->nullable()->after('max_team_members');
            $table->json('platform_limits')->nullable()->after('max_scheduled_posts');
            
            $table->decimal('yearly_price', 10, 2)->nullable()->after('price');
            $table->integer('yearly_discount_percent')->default(0)->after('yearly_price');
            $table->string('stripe_yearly_price_id')->nullable()->after('stripe_price_id');
            
            $table->boolean('trial_enabled')->default(false)->after('trial_period_days');
            $table->boolean('skip_trial_discount_enabled')->default(false)->after('trial_enabled');
            $table->integer('skip_trial_discount_percent')->default(0)->after('skip_trial_discount_enabled');
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

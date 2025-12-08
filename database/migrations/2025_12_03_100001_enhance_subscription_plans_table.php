<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_plans', 'badge_label')) {
                $table->string('badge_label')->nullable()->after('is_featured');
            }
            if (!Schema::hasColumn('subscription_plans', 'badge_color')) {
                $table->string('badge_color')->nullable()->after('badge_label');
            }
            if (!Schema::hasColumn('subscription_plans', 'highlight_color')) {
                $table->string('highlight_color')->nullable()->after('badge_color');
            }
            if (!Schema::hasColumn('subscription_plans', 'cta_label')) {
                $table->string('cta_label')->nullable()->after('highlight_color');
            }
            if (!Schema::hasColumn('subscription_plans', 'cta_url')) {
                $table->string('cta_url')->nullable()->after('cta_label');
            }
            if (!Schema::hasColumn('subscription_plans', 'display_price_text')) {
                $table->string('display_price_text')->nullable()->after('cta_url');
            }
            if (!Schema::hasColumn('subscription_plans', 'price_suffix')) {
                $table->string('price_suffix')->default('/month')->after('display_price_text');
            }
            if (!Schema::hasColumn('subscription_plans', 'trial_period_days')) {
                $table->integer('trial_period_days')->nullable()->after('price_suffix');
            }
            if (!Schema::hasColumn('subscription_plans', 'is_contact_only')) {
                $table->boolean('is_contact_only')->default(false)->after('trial_period_days');
            }
            if (!Schema::hasColumn('subscription_plans', 'show_on_landing')) {
                $table->boolean('show_on_landing')->default(true)->after('is_contact_only');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $columns = ['badge_label', 'badge_color', 'highlight_color', 'cta_label', 'cta_url', 
                        'display_price_text', 'price_suffix', 'trial_period_days', 'is_contact_only', 'show_on_landing'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('subscription_plans', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

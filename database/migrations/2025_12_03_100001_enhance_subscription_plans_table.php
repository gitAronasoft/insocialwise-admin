<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('badge_label')->nullable()->after('is_featured');
            $table->string('badge_color')->nullable()->after('badge_label');
            $table->string('highlight_color')->nullable()->after('badge_color');
            $table->string('cta_label')->nullable()->after('highlight_color');
            $table->string('cta_url')->nullable()->after('cta_label');
            $table->string('display_price_text')->nullable()->after('cta_url');
            $table->string('price_suffix')->default('/month')->after('display_price_text');
            $table->integer('trial_period_days')->nullable()->after('price_suffix');
            $table->boolean('is_contact_only')->default(false)->after('trial_period_days');
            $table->boolean('show_on_landing')->default(true)->after('is_contact_only');
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'badge_label',
                'badge_color', 
                'highlight_color',
                'cta_label',
                'cta_url',
                'display_price_text',
                'price_suffix',
                'trial_period_days',
                'is_contact_only',
                'show_on_landing',
            ]);
        });
    }
};

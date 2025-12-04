<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $columns = [
                'badge_label',
                'badge_color',
                'highlight_color',
                'cta_label',
                'cta_url',
                'display_price_text',
                'price_suffix',
                'customer_limit',
                'posts_limit',
                'pages_limit',
                'social_accounts_limit',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('subscription_plans', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('badge_label', 50)->nullable();
            $table->string('badge_color', 20)->nullable();
            $table->string('highlight_color', 50)->nullable();
            $table->string('cta_label', 50)->nullable();
            $table->string('cta_url', 255)->nullable();
            $table->string('display_price_text', 50)->nullable();
            $table->string('price_suffix', 20)->nullable();
            $table->integer('customer_limit')->nullable();
            $table->integer('posts_limit')->nullable();
            $table->integer('pages_limit')->nullable();
            $table->integer('social_accounts_limit')->nullable();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('social_page')) {
            Schema::table('social_page', function (Blueprint $table) {
                if (!Schema::hasColumn('social_page', 'platform')) {
                    $table->string('platform')->nullable()->after('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('social_page') && Schema::hasColumn('social_page', 'platform')) {
            Schema::table('social_page', function (Blueprint $table) {
                $table->dropColumn('platform');
            });
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $columns = ['overall_score', 'content_score', 'engagement_score', 'growth_score', 'consistency_score'];
        
        if (Schema::hasTable('social_media_score')) {
            foreach ($columns as $column) {
                try {
                    DB::statement("ALTER TABLE social_media_score ADD COLUMN $column DECIMAL(5,2) DEFAULT 0");
                } catch (\Exception $e) {}
            }
            try {
                DB::statement('ALTER TABLE social_media_score ADD COLUMN calculated_at TIMESTAMP NULL');
            } catch (\Exception $e) {}
        }

        if (Schema::hasTable('social_media_page_score')) {
            foreach ($columns as $column) {
                try {
                    DB::statement("ALTER TABLE social_media_page_score ADD COLUMN $column DECIMAL(5,2) DEFAULT 0");
                } catch (\Exception $e) {}
            }
            try {
                DB::statement('ALTER TABLE social_media_page_score ADD COLUMN calculated_at TIMESTAMP NULL');
            } catch (\Exception $e) {}
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = ['overall_score', 'content_score', 'engagement_score', 'growth_score', 'consistency_score', 'calculated_at'];
        
        if (Schema::hasTable('social_media_score')) {
            foreach ($columns as $column) {
                try {
                    DB::statement("ALTER TABLE social_media_score DROP COLUMN $column");
                } catch (\Exception $e) {}
            }
        }
        
        if (Schema::hasTable('social_media_page_score')) {
            foreach ($columns as $column) {
                try {
                    DB::statement("ALTER TABLE social_media_page_score DROP COLUMN $column");
                } catch (\Exception $e) {}
            }
        }
    }
};

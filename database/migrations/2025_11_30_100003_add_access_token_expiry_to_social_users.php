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
        if (!Schema::hasTable('social_users')) {
            return;
        }
        
        try {
            DB::statement("UPDATE social_users SET status = 'active' WHERE status = '' OR status IS NULL");
        } catch (\Exception $e) {
        }
        
        try {
            DB::statement("ALTER TABLE social_users MODIFY COLUMN `status` ENUM('active', 'inactive', 'expired') NOT NULL DEFAULT 'active'");
        } catch (\Exception $e) {
        }
        
        try {
            DB::statement('ALTER TABLE social_users ADD COLUMN `access_token_expiry` TIMESTAMP NULL');
        } catch (\Exception $e) {
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('social_users')) {
            return;
        }
        
        try {
            DB::statement('ALTER TABLE social_users DROP COLUMN `access_token_expiry`');
        } catch (\Exception $e) {
        }
    }
};

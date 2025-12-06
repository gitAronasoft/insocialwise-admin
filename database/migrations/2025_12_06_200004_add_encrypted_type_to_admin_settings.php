<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE admin_settings MODIFY COLUMN `type` ENUM('string', 'integer', 'boolean', 'json', 'email', 'encrypted') NOT NULL DEFAULT 'string'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE admin_settings MODIFY COLUMN `type` ENUM('string', 'integer', 'boolean', 'json', 'email') NOT NULL DEFAULT 'string'");
    }
};

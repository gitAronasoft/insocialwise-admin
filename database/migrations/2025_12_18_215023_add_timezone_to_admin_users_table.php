<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            if (!Schema::hasColumn('admin_users', 'timezone')) {
                $table->string('timezone', 100)->default('UTC')->after('is_active');
            }
        });
    }

    public function down(): void
    {
    }
};

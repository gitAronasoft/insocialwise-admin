<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'display_name')) {
                $table->string('display_name')->after('name')->default('');
            }
            if (!Schema::hasColumn('permissions', 'description')) {
                $table->string('description')->nullable()->after('display_name');
            }
            if (!Schema::hasColumn('permissions', 'group')) {
                $table->string('group')->after('description')->default('');
            }
            if (Schema::hasColumn('permissions', 'guard_name')) {
                $table->dropColumn('guard_name');
            }
        });

        Schema::table('roles', function (Blueprint $table) {
            if (!Schema::hasColumn('roles', 'display_name')) {
                $table->string('display_name')->after('name')->default('');
            }
            if (!Schema::hasColumn('roles', 'description')) {
                $table->string('description')->nullable()->after('display_name');
            }
            if (!Schema::hasColumn('roles', 'is_super_admin')) {
                $table->boolean('is_super_admin')->default(false)->after('description');
            }
            if (Schema::hasColumn('roles', 'guard_name')) {
                $table->dropColumn('guard_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (Schema::hasColumn('permissions', 'display_name')) {
                $table->dropColumn('display_name');
            }
            if (Schema::hasColumn('permissions', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('permissions', 'group')) {
                $table->dropColumn('group');
            }
            if (!Schema::hasColumn('permissions', 'guard_name')) {
                $table->string('guard_name')->after('name');
            }
        });

        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'display_name')) {
                $table->dropColumn('display_name');
            }
            if (Schema::hasColumn('roles', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('roles', 'is_super_admin')) {
                $table->dropColumn('is_super_admin');
            }
            if (!Schema::hasColumn('roles', 'guard_name')) {
                $table->string('guard_name')->after('name');
            }
        });
    }
};

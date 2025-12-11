<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_user_role')) {
            Schema::create('admin_user_role', function (Blueprint $table) {
                $table->unsignedBigInteger('admin_user_id');
                $table->unsignedBigInteger('role_id');
                $table->primary(['admin_user_id', 'role_id']);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

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
                $table->foreignId('admin_user_id')->constrained('admin_users')->onDelete('cascade');
                $table->foreignId('role_id')->constrained()->onDelete('cascade');
                $table->primary(['admin_user_id', 'role_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_user_role');
    }
};

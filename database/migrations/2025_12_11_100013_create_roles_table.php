<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255)->unique();
                $table->string('display_name', 255);
                $table->string('description', 255)->nullable();
                $table->smallInteger('is_super_admin')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

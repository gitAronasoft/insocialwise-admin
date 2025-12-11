<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255)->unique();
                $table->string('display_name', 255);
                $table->string('description', 255)->nullable();
                $table->string('group', 255);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

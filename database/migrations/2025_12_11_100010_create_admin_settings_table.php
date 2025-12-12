<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_settings')) {
            Schema::create('admin_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 255)->unique();
                $table->text('value')->nullable();
                $table->enum('type', ['string', 'integer', 'boolean', 'json', 'email', 'encrypted'])->default('string');           
                $table->string('group')->default('general'); 
                $table->text('description')->nullable();
                $table->string('section', 255)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

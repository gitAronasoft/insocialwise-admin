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
                $table->string('key')->unique();
                $table->longText('value')->nullable();
                $table->enum('type', ['string', 'integer', 'boolean', 'json', 'email'])->default('string');
                $table->string('group')->default('general'); // general, email, api, payment, feature, etc
                $table->text('description')->nullable();
                $table->string('section')->nullable(); // UI section grouping
                $table->timestamps();
                $table->index(['group', 'section']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};

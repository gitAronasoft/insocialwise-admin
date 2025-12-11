<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notification_settings')) {
            Schema::create('notification_settings', function (Blueprint $table) {
                $table->id();
                $table->string('notification_type', 100);
                $table->string('category', 100);
                $table->string('name', 255);
                $table->text('description')->nullable();
                $table->smallInteger('enabled')->default(1);
                $table->string('frequency', 50)->default('instant');
                $table->json('channels')->nullable();
                $table->string('template_name', 100)->nullable();
                $table->string('subject_template', 500)->nullable();
                $table->json('conditions')->nullable();
                $table->bigInteger('priority')->default(5);
                $table->smallInteger('retry_enabled')->default(1);
                $table->bigInteger('max_retries')->default(3);
                $table->bigInteger('cooldown_hours')->nullable();
                $table->smallInteger('user_configurable')->default(1);
                $table->json('metadata')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

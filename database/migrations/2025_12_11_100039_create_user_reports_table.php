<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user_reports')) {
            Schema::create('user_reports', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255);
                $table->string('report_name', 255);
                $table->string('report_type', 100);
                $table->string('template_id', 255)->nullable();
                $table->json('metrics')->nullable();
                $table->string('date_range', 255)->nullable();
                $table->string('file_path', 255)->nullable();
                $table->bigInteger('file_size')->nullable();
                $table->smallInteger('status')->default(0);
                $table->smallInteger('is_favorite')->default(0);
                $table->string('schedule_frequency', 50)->default('never');
                $table->smallInteger('schedule_enabled')->default(0);
                $table->bigInteger('schedule_day')->nullable();
                $table->string('schedule_time', 255)->nullable();
                $table->timestamp('last_generated_at')->nullable();
                $table->text('notes')->nullable();
                $table->json('report_data')->nullable();
                $table->json('insights')->nullable();
                $table->json('comparison_data')->nullable();
                $table->string('user_logo_path', 255)->nullable();
                $table->smallInteger('email_delivery_enabled')->default(0);
                $table->json('email_recipients')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

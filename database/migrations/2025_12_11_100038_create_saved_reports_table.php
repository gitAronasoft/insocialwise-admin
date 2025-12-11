<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('saved_reports')) {
            Schema::create('saved_reports', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255);
                $table->string('report_name', 255);
                $table->string('report_type', 255);
                $table->json('selected_metrics')->nullable();
                $table->json('date_range')->nullable();
                $table->string('export_format', 255)->nullable();
                $table->json('report_data')->nullable();
                $table->string('file_path', 255)->nullable();
                $table->smallInteger('status')->default(0);
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

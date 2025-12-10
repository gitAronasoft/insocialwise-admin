<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid')->nullable();
            $table->unsignedBigInteger('social_page_id')->nullable();
            $table->string('metric_type');
            $table->string('metric_name');
            $table->decimal('metric_value', 15, 4)->default(0);
            $table->string('period_type')->default('daily');
            $table->date('period_start');
            $table->date('period_end');
            $table->json('breakdown')->nullable();
            $table->timestamps();
            $table->index(['metric_type', 'period_start', 'period_end']);
        });

        Schema::create('demographics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_page_id');
            $table->string('dimension');
            $table->string('value');
            $table->decimal('percentage', 5, 2)->default(0);
            $table->integer('count')->default(0);
            $table->date('date');
            $table->timestamps();
            $table->foreign('social_page_id')->references('id')->on('social_page')->onDelete('cascade');
        });

        Schema::create('saved_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('report_type');
            $table->json('filters')->nullable();
            $table->json('columns')->nullable();
            $table->string('date_range')->nullable();
            $table->boolean('is_scheduled')->default(false);
            $table->string('schedule_frequency')->nullable();
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('set null');
        });

        Schema::create('user_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->string('report_type');
            $table->string('title');
            $table->json('parameters')->nullable();
            $table->json('data')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamp('generated_at')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
        });

        Schema::create('alert_thresholds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id')->nullable();
            $table->string('metric_type');
            $table->string('condition');
            $table->decimal('threshold_value', 15, 4);
            $table->string('alert_channel')->default('email');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_triggered_at')->nullable();
            $table->timestamps();
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_thresholds');
        Schema::dropIfExists('user_reports');
        Schema::dropIfExists('saved_reports');
        Schema::dropIfExists('demographics');
        Schema::dropIfExists('analytics');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('alert_thresholds')) {
            Schema::create('alert_thresholds', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255);
                $table->string('alert_name', 255);
                $table->string('metric_type', 100);
                $table->string('condition', 50);
                $table->double('threshold_value');
                $table->string('comparison_period', 50);
                $table->smallInteger('is_enabled')->default(1);
                $table->smallInteger('notify_email')->default(1);
                $table->smallInteger('notify_in_app')->default(1);
                $table->json('email_recipients')->nullable();
                $table->timestamp('last_triggered_at')->nullable();
                $table->double('last_value')->nullable();
                $table->bigInteger('trigger_count')->default(0);
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_alerts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['payment_failed', 'critical_error', 'suspicious_login', 'subscription_cancelled', 'api_failure', 'system_warning', 'general'])->default('general');
            $table->enum('severity', ['critical', 'warning', 'info'])->default('info');
            $table->string('title');
            $table->text('message');
            $table->json('metadata')->nullable();
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->unsignedBigInteger('read_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_alerts');
    }
};

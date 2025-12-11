<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('webhooks')) {
            Schema::create('webhooks', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('provider', 100)->default('stripe');
                $table->string('event_type', 255);
                $table->string('endpoint_url', 255);
                $table->text('secret')->nullable();
                $table->smallInteger('active')->default(1);
                $table->timestamp('last_triggered_at')->nullable();
                $table->smallInteger('last_status')->nullable();
                $table->text('last_response')->nullable();
                $table->bigInteger('success_count')->default(0);
                $table->bigInteger('failure_count')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

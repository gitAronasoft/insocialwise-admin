<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('data_requests')) {
            Schema::create('data_requests', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255);
                $table->string('user_email', 255);
                $table->string('request_type', 100);
                $table->smallInteger('status')->default(0);
                $table->text('notes')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->unsignedBigInteger('processed_by')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

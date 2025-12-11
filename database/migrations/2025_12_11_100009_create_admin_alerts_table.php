<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_alerts')) {
            Schema::create('admin_alerts', function (Blueprint $table) {
                $table->id();
                $table->string('type', 100);
                $table->smallInteger('severity')->default(0);
                $table->string('title', 255);
                $table->text('message');
                $table->json('metadata')->nullable();
                $table->smallInteger('read')->default(0);
                $table->timestamp('read_at')->nullable();
                $table->unsignedBigInteger('read_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

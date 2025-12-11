<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('data_retention_rules')) {
            Schema::create('data_retention_rules', function (Blueprint $table) {
                $table->id();
                $table->string('data_type', 255)->unique();
                $table->bigInteger('retention_days');
                $table->smallInteger('auto_delete')->default(0);
                $table->timestamp('last_cleanup_at')->nullable();
                $table->smallInteger('active')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

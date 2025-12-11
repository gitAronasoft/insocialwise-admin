<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('admin_feature_flags')) {
            Schema::create('admin_feature_flags', function (Blueprint $table) {
                $table->id();
                $table->string('feature_key', 255)->unique();
                $table->string('feature_name', 255);
                $table->text('description')->nullable();
                $table->string('category', 100)->default('general');
                $table->smallInteger('enabled')->default(0);
                $table->smallInteger('force_enabled')->default(0);
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

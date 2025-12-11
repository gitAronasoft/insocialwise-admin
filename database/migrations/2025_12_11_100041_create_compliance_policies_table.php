<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('compliance_policies')) {
            Schema::create('compliance_policies', function (Blueprint $table) {
                $table->id();
                $table->string('policy_type', 100);
                $table->text('content');
                $table->string('version', 255);
                $table->date('effective_date');
                $table->smallInteger('active')->default(1);
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('demographics')) {
            Schema::create('demographics', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255);
                $table->string('platform_page_id', 255);
                $table->string('page_name', 255);
                $table->string('social_userid', 255);  
                $table->enum('platform', ["facebook", "linkedin", "instagram", "NA"])->default('NA');
                $table->string('metric_type', 200)->nullable();
                $table->string('metric_key', 250)->nullable();
                $table->bigInteger('metric_value')->default(0);
                $table->enum('source', ["Sheet", "API", "NA"])->default('NA');
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

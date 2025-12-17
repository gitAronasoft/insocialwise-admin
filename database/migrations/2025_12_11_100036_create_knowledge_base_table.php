<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('knowledge_base')) {
            Schema::create('knowledge_base', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('knowledgeBase_title', 255)->nullable();
                $table->text('knowledgeBase_content')->nullable();
                $table->string('social_platform', 100)->nullable();
                $table->text('social_data_detail')->nullable();
                $table->enum('status', ['notConnected', 'Connected'])->default('notConnected');
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

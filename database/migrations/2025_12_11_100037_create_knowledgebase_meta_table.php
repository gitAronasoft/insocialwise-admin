<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('knowledgebase_meta')) {
            Schema::create('knowledgebase_meta', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255);
                $table->string('knowledgeBase_id', 255)->nullable();
                $table->string('pages_id', 255)->nullable();
                $table->string('social_account_id', 255)->nullable();
                $table->string('social_platform', 100)->nullable();
                $table->string('namespace_id', 255)->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
            });
        }
    }

    public function down(): void
    {
    }
};

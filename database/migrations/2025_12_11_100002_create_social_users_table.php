<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('social_users')) {
            Schema::create('social_users', function (Blueprint $table) {
                $table->id();
                $table->string('user_id', 250);
                $table->string('name', 100);
                $table->string('email', 200)->nullable();
                $table->string('img_url', 250)->nullable();
                $table->string('social_id', 200);
                $table->string('social_user_platform', 255)->nullable();
                $table->text('user_token');
                $table->smallInteger('status')->default(0);
                $table->timestamps();
                
                $table->index('user_id');
                $table->index('social_id');
            });
        }
    }

    public function down(): void
    {
    }
};

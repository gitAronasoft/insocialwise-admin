<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('social_page')) {
            Schema::create('social_page', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('social_userid', 250);
                $table->string('pagename', 150);
                $table->text('page_picture')->nullable();
                $table->text('page_cover')->nullable();
                $table->string('pageid', 150);
                $table->text('token');
                $table->string('category', 100)->nullable();
                $table->bigInteger('total_followers')->default(0);
                $table->string('page_platform', 255)->nullable();
                $table->smallInteger('status')->default(0);
                $table->string('platform', 255)->nullable();
                $table->text('modify_to')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('pageid');
            });
        }
    }

    public function down(): void
    {
    }
};

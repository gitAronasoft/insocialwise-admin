<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('post_comments')) {
            Schema::create('post_comments', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid', 255)->nullable();
                $table->string('social_userid', 255)->nullable();
                $table->string('platform_page_id', 255)->nullable();
                $table->string('platform', 255)->nullable();
                $table->string('post_id', 255)->nullable();
                $table->string('activity_id', 255)->nullable();
                $table->string('comment_id', 255)->nullable();
                $table->string('parent_comment_id', 255)->nullable();
                $table->string('from_id', 255)->nullable();
                $table->string('from_name', 255)->nullable();
                $table->text('comment')->nullable();
                $table->string('comment_created_time', 255)->nullable();
                $table->string('comment_type', 255)->nullable();
                $table->string('comment_behavior', 255)->nullable();
                $table->bigInteger('reaction_like')->default(0);
                $table->bigInteger('reaction_love')->default(0);
                $table->bigInteger('reaction_haha')->default(0);
                $table->bigInteger('reaction_wow')->default(0);
                $table->bigInteger('reaction_sad')->default(0);
                $table->bigInteger('reaction_angry')->default(0);
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('post_id');
            });
        }
    }

    public function down(): void
    {
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_users', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->string('platform');
            $table->string('platform_user_id');
            $table->string('username')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->json('scopes')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired', 'revoked'])->default('active');
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->unique(['user_uuid', 'platform', 'platform_user_id']);
        });

        Schema::create('social_page', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_user_id');
            $table->string('platform');
            $table->string('page_id');
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_photo')->nullable();
            $table->text('access_token')->nullable();
            $table->integer('followers_count')->default(0);
            $table->integer('following_count')->default(0);
            $table->integer('posts_count')->default(0);
            $table->enum('status', ['active', 'inactive', 'disconnected'])->default('active');
            $table->integer('health_score')->default(100);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->foreign('social_user_id')->references('id')->on('social_users')->onDelete('cascade');
            $table->unique(['social_user_id', 'platform', 'page_id']);
        });

        Schema::create('social_media_score', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_page_id');
            $table->integer('engagement_score')->default(0);
            $table->integer('reach_score')->default(0);
            $table->integer('growth_score')->default(0);
            $table->integer('overall_score')->default(0);
            $table->json('score_breakdown')->nullable();
            $table->date('calculated_date');
            $table->timestamps();
            $table->foreign('social_page_id')->references('id')->on('social_page')->onDelete('cascade');
        });

        Schema::create('social_media_page_score', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_page_id');
            $table->integer('score')->default(0);
            $table->string('metric_type');
            $table->json('details')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->foreign('social_page_id')->references('id')->on('social_page')->onDelete('cascade');
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid');
            $table->unsignedBigInteger('social_page_id')->nullable();
            $table->string('platform_post_id')->nullable();
            $table->string('platform');
            $table->text('content')->nullable();
            $table->json('media_urls')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'published', 'failed', 'deleted'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->integer('reach')->default(0);
            $table->integer('impressions')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('social_page_id')->references('id')->on('social_page')->onDelete('set null');
        });

        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('platform_comment_id')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_avatar')->nullable();
            $table->text('content');
            $table->enum('sentiment', ['positive', 'negative', 'neutral'])->nullable();
            $table->boolean('is_reply')->default(false);
            $table->unsignedBigInteger('parent_comment_id')->nullable();
            $table->timestamp('commented_at')->nullable();
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('parent_comment_id')->references('id')->on('post_comments')->onDelete('cascade');
        });

        Schema::create('activity', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_uuid')->nullable();
            $table->string('account_social_userid')->nullable();
            $table->string('account_platform')->nullable();
            $table->string('activity_type')->nullable();
            $table->string('activity_subType')->nullable();
            $table->string('action')->nullable();
            $table->string('source_type')->nullable();
            $table->string('post_form_id')->nullable();
            $table->text('reference_pageID')->nullable();
            $table->timestamp('activity_dateTime');
            $table->timestamp('nextAPI_call_dateTime')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity');
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('social_media_page_score');
        Schema::dropIfExists('social_media_score');
        Schema::dropIfExists('social_page');
        Schema::dropIfExists('social_users');
    }
};

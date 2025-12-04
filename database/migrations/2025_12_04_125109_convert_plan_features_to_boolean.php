<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE subscription_plans DROP COLUMN IF EXISTS calendar_scheduling");
        DB::statement("ALTER TABLE subscription_plans DROP COLUMN IF EXISTS export_reports");
        DB::statement("ALTER TABLE subscription_plans DROP COLUMN IF EXISTS social_profile_score");
        
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->boolean('calendar_scheduling')->default(false)->after('ai_content_generator');
            $table->boolean('export_reports')->default(false)->after('unified_inbox');
            $table->boolean('social_profile_score')->default(false)->after('calendar_scheduling');
        });
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE subscription_plans DROP COLUMN IF EXISTS calendar_scheduling");
        DB::statement("ALTER TABLE subscription_plans DROP COLUMN IF EXISTS export_reports");
        DB::statement("ALTER TABLE subscription_plans DROP COLUMN IF EXISTS social_profile_score");
        
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('calendar_scheduling')->default('none')->after('ai_content_generator');
            $table->string('export_reports')->default('none')->after('unified_inbox');
            $table->string('social_profile_score')->default('none')->after('ai_content_generator');
        });
    }
};

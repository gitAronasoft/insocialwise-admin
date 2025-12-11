<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inbox_messages')) {
            Schema::create('inbox_messages', function (Blueprint $table) {
                $table->id();
                $table->string('conversation_id', 200);
                $table->string('platform_message_id', 200);
                $table->string('sender_type', 50);
                $table->text('message_text');
                $table->string('message_type', 250);
                $table->smallInteger('is_read')->default(0);
                $table->string('timestamp', 200)->nullable();
                $table->timestamps();
                
                $table->index('conversation_id');
            });
        }
    }

    public function down(): void
    {
    }
};

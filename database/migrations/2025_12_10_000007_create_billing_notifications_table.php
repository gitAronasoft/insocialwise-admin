<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('billing_notifications')) {
            Schema::create('billing_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('user_uuid');           
                $table->unsignedBigInteger('subscription_id')->nullable()->comment('Related subscription ID');
                $table->string('type');
                $table->enum('notification_type', [
                'trial_ending_24h',
                'trial_ending_1h',
                'trial_ended',
                'subscription_created',
                'subscription_renewed',
                'subscription_canceled',
                'subscription_paused',
                'subscription_resumed',
                'renewal_reminder_7d',
                'renewal_reminder_3d',
                'renewal_reminder_1d',
                'payment_succeeded',
                'payment_failed',
                'payment_failed_final',
                'payment_method_expiring',
                'payment_method_expired',
                'invoice_created',
                'invoice_paid',
                'invoice_past_due',
                'refund_processed',
                'plan_upgraded',
                'plan_downgraded',
                'dunning_reminder'
                ])->comment('Type of notification');
                $table->enum('channel', ['email', 'in_app', 'sms', 'push'])->default('email')->comment('Notification channel');
                $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->comment('Notification priority');
                $table->enum('status', ['pending', 'queued', 'sent', 'delivered', 'failed', 'canceled', 'skipped'])->default('pending')->comment('Notification status');
                $table->string('title')->nullable();
                $table->text('message')->nullable();
                $table->string('recipient_email')->nullable();
                $table->string('subject')->nullable();
                $table->string('template_name')->nullable();
                $table->json('template_data')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamp('scheduled_at')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
                
                $table->index('user_uuid');
                $table->index('type');
                $table->index('status');
            });
        }
    }

    public function down(): void
    {
    }
};

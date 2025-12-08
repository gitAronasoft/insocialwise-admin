<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('billing_notifications')) {
            return;
        }
        Schema::create('billing_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('user_uuid')->comment('User UUID reference');
            $table->unsignedInteger('subscription_id')->nullable()->comment('Related subscription ID');
            $table->unsignedInteger('transaction_id')->nullable()->comment('Related transaction ID');
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
            $table->string('recipient_email')->nullable()->comment('Email recipient');
            $table->string('recipient_phone', 50)->nullable()->comment('Phone recipient (for SMS)');
            $table->string('subject', 500)->nullable()->comment('Email subject');
            $table->string('template_name', 100)->nullable()->comment('Email template name');
            $table->json('template_data')->nullable()->comment('Data for template rendering');
            $table->text('content')->nullable()->comment('Rendered content (for logging)');
            $table->dateTime('scheduled_at')->comment('When to send the notification');
            $table->dateTime('sent_at')->nullable()->comment('When notification was sent');
            $table->dateTime('delivered_at')->nullable()->comment('When notification was delivered');
            $table->dateTime('opened_at')->nullable()->comment('When email was opened');
            $table->dateTime('clicked_at')->nullable()->comment('When link was clicked');
            $table->integer('retry_count')->default(0)->comment('Number of send attempts');
            $table->integer('max_retries')->default(3)->comment('Maximum retry attempts');
            $table->text('last_error')->nullable()->comment('Last error message');
            $table->string('external_id')->nullable()->comment('External service ID (SendGrid, etc.)');
            $table->json('metadata')->nullable()->comment('Additional metadata');
            $table->timestamps();

            $table->index('user_uuid');
            $table->index('subscription_id');
            $table->index('status');
            $table->index('scheduled_at');
            $table->index(['status', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_notifications');
    }
};

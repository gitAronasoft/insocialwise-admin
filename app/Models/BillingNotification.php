<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingNotification extends Model
{
    protected $table = 'billing_notifications';

    protected $fillable = [
        'user_uuid',
        'subscription_id',
        'transaction_id',
        'notification_type',
        'channel',
        'priority',
        'status',
        'recipient_email',
        'recipient_phone',
        'subject',
        'template_name',
        'template_data',
        'content',
        'scheduled_at',
        'sent_at',
        'delivered_at',
        'opened_at',
        'clicked_at',
        'retry_count',
        'max_retries',
        'last_error',
        'external_id',
        'metadata',
    ];

    protected $casts = [
        'template_data' => 'array',
        'metadata' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'retry_count' => 'integer',
        'max_retries' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeDue($query)
    {
        return $query->where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->where('retry_count', '<', 3);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'sent', 'delivered' => 'green',
            'pending', 'queued' => 'blue',
            'failed' => 'red',
            'canceled', 'skipped' => 'gray',
            default => 'gray',
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'normal' => 'blue',
            'low' => 'gray',
            default => 'gray',
        };
    }

    public function getNotificationTypeLabel(): string
    {
        return match ($this->notification_type) {
            'trial_ending_24h' => 'Trial Ending (24h)',
            'trial_ending_1h' => 'Trial Ending (1h)',
            'trial_ended' => 'Trial Ended',
            'subscription_created' => 'Subscription Created',
            'subscription_renewed' => 'Subscription Renewed',
            'subscription_canceled' => 'Subscription Canceled',
            'subscription_paused' => 'Subscription Paused',
            'subscription_resumed' => 'Subscription Resumed',
            'renewal_reminder_7d' => 'Renewal Reminder (7d)',
            'renewal_reminder_3d' => 'Renewal Reminder (3d)',
            'renewal_reminder_1d' => 'Renewal Reminder (1d)',
            'payment_succeeded' => 'Payment Succeeded',
            'payment_failed' => 'Payment Failed',
            'payment_failed_final' => 'Payment Failed (Final)',
            'payment_method_expiring' => 'Payment Method Expiring',
            'payment_method_expired' => 'Payment Method Expired',
            'invoice_created' => 'Invoice Created',
            'invoice_paid' => 'Invoice Paid',
            'invoice_past_due' => 'Invoice Past Due',
            'refund_processed' => 'Refund Processed',
            'plan_upgraded' => 'Plan Upgraded',
            'plan_downgraded' => 'Plan Downgraded',
            'dunning_reminder' => 'Dunning Reminder',
            default => ucwords(str_replace('_', ' ', $this->notification_type)),
        };
    }
}

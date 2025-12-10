<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionEvent extends Model
{
    protected $table = 'subscription_events';

    protected $fillable = [
        'subscription_id',
        'user_uuid',
        'stripe_subscription_id',
        'stripe_event_id',
        'event_type',
        'old_status',
        'new_status',
        'old_plan_id',
        'new_plan_id',
        'old_quantity',
        'new_quantity',
        'amount',
        'currency',
        'failure_code',
        'failure_message',
        'actor',
        'actor_id',
        'ip_address',
        'user_agent',
        'description',
        'metadata',
        'event_payload',
        'occurred_at',
        'processed_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'event_payload' => 'array',
        'occurred_at' => 'datetime',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'amount' => 'integer',
        'old_quantity' => 'integer',
        'new_quantity' => 'integer',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function getEventTypeColorAttribute(): string
    {
        return match ($this->event_type) {
            'subscription_created' => 'blue',
            'subscription_updated' => 'indigo',
            'subscription_deleted', 'canceled' => 'red',
            'subscription_paused' => 'purple',
            'subscription_resumed' => 'green',
            'trial_started', 'trial_ending' => 'cyan',
            'trial_ended', 'trial_converted' => 'teal',
            'payment_succeeded', 'invoice_paid' => 'green',
            'payment_failed', 'invoice_payment_failed' => 'red',
            'payment_refunded' => 'orange',
            'invoice_created', 'invoice_upcoming' => 'blue',
            'plan_changed' => 'purple',
            'quantity_changed' => 'indigo',
            'status_changed' => 'yellow',
            'reactivated' => 'green',
            'dunning_started', 'dunning_ended' => 'orange',
            default => 'gray',
        };
    }

    public function getEventTypeLabelAttribute(): string
    {
        return match ($this->event_type) {
            'subscription_created' => 'Subscription Created',
            'subscription_updated' => 'Subscription Updated',
            'subscription_deleted' => 'Subscription Deleted',
            'subscription_paused' => 'Subscription Paused',
            'subscription_resumed' => 'Subscription Resumed',
            'trial_started' => 'Trial Started',
            'trial_ending' => 'Trial Ending',
            'trial_ended' => 'Trial Ended',
            'trial_converted' => 'Trial Converted',
            'payment_succeeded' => 'Payment Succeeded',
            'payment_failed' => 'Payment Failed',
            'payment_refunded' => 'Payment Refunded',
            'invoice_created' => 'Invoice Created',
            'invoice_paid' => 'Invoice Paid',
            'invoice_payment_failed' => 'Invoice Payment Failed',
            'invoice_upcoming' => 'Invoice Upcoming',
            'plan_changed' => 'Plan Changed',
            'quantity_changed' => 'Quantity Changed',
            'status_changed' => 'Status Changed',
            'canceled' => 'Canceled',
            'reactivated' => 'Reactivated',
            'dunning_started' => 'Dunning Started',
            'dunning_ended' => 'Dunning Ended',
            default => ucfirst(str_replace('_', ' ', $this->event_type ?? 'Unknown')),
        };
    }

    public function getEventTypeIconAttribute(): string
    {
        return match ($this->event_type) {
            'subscription_created' => 'plus-circle',
            'subscription_updated' => 'pencil',
            'subscription_deleted', 'canceled' => 'x-circle',
            'subscription_paused' => 'pause-circle',
            'subscription_resumed', 'reactivated' => 'play-circle',
            'trial_started', 'trial_ending', 'trial_ended' => 'clock',
            'trial_converted' => 'check-badge',
            'payment_succeeded', 'invoice_paid' => 'check-circle',
            'payment_failed', 'invoice_payment_failed' => 'exclamation-circle',
            'payment_refunded' => 'arrow-uturn-left',
            'invoice_created', 'invoice_upcoming' => 'document-text',
            'plan_changed' => 'arrows-right-left',
            'quantity_changed' => 'hashtag',
            'status_changed' => 'arrow-path',
            'dunning_started', 'dunning_ended' => 'exclamation-triangle',
            default => 'information-circle',
        };
    }

    public function getActorLabelAttribute(): string
    {
        return match ($this->actor) {
            'user' => 'User',
            'admin' => 'Admin',
            'system' => 'System',
            'stripe' => 'Stripe',
            'webhook' => 'Webhook',
            default => ucfirst($this->actor ?? 'Unknown'),
        };
    }

    public function getFormattedAmountAttribute(): ?string
    {
        if (!$this->amount) {
            return null;
        }
        $currency = strtoupper($this->currency ?? 'USD');
        return $currency . ' ' . number_format($this->amount / 100, 2);
    }
}

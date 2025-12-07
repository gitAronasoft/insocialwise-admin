<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'user_uuid',
        'stripe_customer_id',
        'stripe_subscription_id',
        'price_id',
        'stripe_price_id',
        'status',
        'trial_start',
        'trial_end',
        'trial_days',
        'current_period_start',
        'current_period_end',
        'billing_cycle_anchor',
        'next_invoice_date',
        'cancel_at_period_end',
        'cancel_at',
        'canceled_at',
        'ended_at',
        'cancellation_reason',
        'cancellation_feedback',
        'pause_collection',
        'resume_at',
        'collection_method',
        'default_payment_method_id',
        'latest_invoice_id',
        'quantity',
        'amount',
        'currency',
        'billing_interval',
        'discount_percent',
        'coupon_code',
        'stripe_coupon_id',
        'past_due_since',
        'last_payment_attempt_at',
        'last_payment_error',
        'payment_retry_count',
        'next_payment_retry_at',
        'dunning_status',
        'status_reason',
        'metadata',
        'trial_reminder_sent',
        'trial_reminder_sent_at',
        'renewal_reminder_sent',
        'renewal_reminder_sent_at',
        'synced_at',
    ];

    protected $casts = [
        'trial_start' => 'datetime',
        'trial_end' => 'datetime',
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'billing_cycle_anchor' => 'datetime',
        'next_invoice_date' => 'datetime',
        'cancel_at' => 'datetime',
        'canceled_at' => 'datetime',
        'ended_at' => 'datetime',
        'resume_at' => 'datetime',
        'past_due_since' => 'datetime',
        'last_payment_attempt_at' => 'datetime',
        'next_payment_retry_at' => 'datetime',
        'trial_reminder_sent_at' => 'datetime',
        'renewal_reminder_sent_at' => 'datetime',
        'synced_at' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
        'cancel_at_period_end' => 'boolean',
        'trial_reminder_sent' => 'boolean',
        'renewal_reminder_sent' => 'boolean',
        'trial_days' => 'integer',
        'quantity' => 'integer',
        'amount' => 'integer',
        'discount_percent' => 'decimal:2',
        'payment_retry_count' => 'integer',
        'metadata' => 'array',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'price_id', 'stripe_price_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(BillingNotification::class, 'subscription_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(BillingActivityLog::class, 'subscription_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_uuid', 'user_uuid');
    }

    public function defaultPaymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'default_payment_method_id', 'stripe_payment_method_id');
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class, 'user_uuid', 'user_uuid');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isTrialing(): bool
    {
        return $this->status === 'trialing' && $this->trial_end && $this->trial_end->isFuture();
    }

    public function isCanceled(): bool
    {
        return $this->status === 'canceled' || $this->canceled_at !== null;
    }

    public function isPastDue(): bool
    {
        return $this->status === 'past_due';
    }

    public function isPaused(): bool
    {
        return $this->status === 'paused' || $this->pause_collection !== null;
    }

    public function isInGracePeriod(): bool
    {
        return $this->canceled_at !== null && $this->current_period_end && $this->current_period_end->isFuture();
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'green',
            'trialing' => 'blue',
            'past_due' => 'yellow',
            'canceled' => 'red',
            'incomplete', 'incomplete_expired' => 'orange',
            'paused' => 'purple',
            'unpaid' => 'red',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Active',
            'trialing' => 'Trialing',
            'past_due' => 'Past Due',
            'canceled' => 'Canceled',
            'incomplete' => 'Incomplete',
            'incomplete_expired' => 'Expired',
            'paused' => 'Paused',
            'unpaid' => 'Unpaid',
            default => ucfirst($this->status ?? 'Unknown'),
        };
    }

    public function getDaysUntilRenewalAttribute(): ?int
    {
        if (!$this->current_period_end) {
            return null;
        }
        return now()->diffInDays($this->current_period_end, false);
    }

    public function getDaysInTrialAttribute(): ?int
    {
        if (!$this->trial_start || !$this->trial_end) {
            return null;
        }
        return $this->trial_start->diffInDays($this->trial_end);
    }

    public function getFormattedAmountAttribute(): ?string
    {
        if (!$this->amount) {
            return null;
        }
        $currency = strtoupper($this->currency ?? 'USD');
        return $currency . ' ' . number_format($this->amount / 100, 2);
    }

    public function needsTrialReminder(): bool
    {
        if ($this->trial_reminder_sent || !$this->isTrialing()) {
            return false;
        }
        
        $hoursUntilEnd = now()->diffInHours($this->trial_end, false);
        return $hoursUntilEnd <= 24 && $hoursUntilEnd > 0;
    }

    public function needsRenewalReminder(): bool
    {
        if ($this->renewal_reminder_sent || !$this->isActive()) {
            return false;
        }
        
        $daysUntilRenewal = $this->days_until_renewal;
        return $daysUntilRenewal !== null && $daysUntilRenewal <= 7 && $daysUntilRenewal > 0;
    }

    public function getTimelineEventsAttribute(): array
    {
        $events = [];
        
        if ($this->createdAt) {
            $events[] = [
                'type' => 'created',
                'date' => $this->createdAt,
                'label' => 'Subscription Created',
                'icon' => 'heroicon-o-plus-circle',
                'color' => 'blue',
            ];
        }
        
        if ($this->trial_start) {
            $events[] = [
                'type' => 'trial_start',
                'date' => $this->trial_start,
                'label' => 'Trial Started',
                'icon' => 'heroicon-o-clock',
                'color' => 'purple',
            ];
        }
        
        if ($this->trial_end && $this->trial_end->isPast()) {
            $events[] = [
                'type' => 'trial_end',
                'date' => $this->trial_end,
                'label' => 'Trial Ended',
                'icon' => 'heroicon-o-check-circle',
                'color' => 'green',
            ];
        }
        
        if ($this->canceled_at) {
            $events[] = [
                'type' => 'canceled',
                'date' => $this->canceled_at,
                'label' => 'Subscription Canceled',
                'icon' => 'heroicon-o-x-circle',
                'color' => 'red',
            ];
        }
        
        if ($this->ended_at) {
            $events[] = [
                'type' => 'ended',
                'date' => $this->ended_at,
                'label' => 'Subscription Ended',
                'icon' => 'heroicon-o-stop-circle',
                'color' => 'gray',
            ];
        }
        
        usort($events, fn($a, $b) => $a['date'] <=> $b['date']);
        
        return $events;
    }
}

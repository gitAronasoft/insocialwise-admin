<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'subscription_id',
        'user_uuid',
        'plan_id',
        'stripe_invoice_id',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'stripe_payment_method_id',
        'invoice_number',
        'invoice_pdf_url',
        'invoice_hosted_url',
        'billing_reason',
        'amount_subtotal',
        'amount_tax',
        'amount_total',
        'amount',
        'amount_paid',
        'amount_due',
        'amount_remaining',
        'discount_amount',
        'coupon_code',
        'tax_rates',
        'currency',
        'status',
        'payment_status',
        'failure_code',
        'failure_message',
        'failure_reason',
        'attempt_count',
        'next_payment_attempt',
        'due_date',
        'paid_at',
        'period_start',
        'period_end',
        'refund_amount',
        'refunded_at',
        'refund_reason',
        'stripe_refund_id',
        'description',
        'receipt_url',
        'card_brand',
        'card_last4',
        'metadata',
        'disputed',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $casts = [
        'amount' => 'integer',
        'amount_subtotal' => 'integer',
        'amount_tax' => 'integer',
        'amount_total' => 'integer',
        'amount_paid' => 'integer',
        'amount_due' => 'integer',
        'amount_remaining' => 'integer',
        'discount_amount' => 'integer',
        'refund_amount' => 'integer',
        'attempt_count' => 'integer',
        'disputed' => 'boolean',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
        'next_payment_attempt' => 'datetime',
        'due_date' => 'datetime',
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'metadata' => 'array',
        'tax_rates' => 'array',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(BillingNotification::class, 'transaction_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(BillingActivityLog::class, 'transaction_id');
    }

    public function getFormattedAmountAttribute(): string
    {
        $currency = strtoupper($this->currency ?? 'USD');
        $amount = is_numeric($this->amount) ? $this->amount / 100 : $this->amount;
        return $currency . ' ' . number_format($amount, 2);
    }

    public function getFormattedRefundedAmountAttribute(): ?string
    {
        if (!$this->amount_refunded) {
            return null;
        }
        $currency = strtoupper($this->currency ?? 'USD');
        return $currency . ' ' . number_format($this->amount_refunded / 100, 2);
    }

    public function getNetAmountAttribute(): int
    {
        return ($this->amount ?? 0) - ($this->amount_refunded ?? 0);
    }

    public function getFormattedNetAmountAttribute(): string
    {
        $currency = strtoupper($this->currency ?? 'USD');
        return $currency . ' ' . number_format($this->net_amount / 100, 2);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'succeeded', 'paid' => 'green',
            'pending', 'processing' => 'yellow',
            'failed', 'canceled' => 'red',
            'refunded' => 'orange',
            'partially_refunded' => 'orange',
            'disputed' => 'red',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'succeeded' => 'Succeeded',
            'paid' => 'Paid',
            'pending' => 'Pending',
            'processing' => 'Processing',
            'failed' => 'Failed',
            'canceled' => 'Canceled',
            'refunded' => 'Refunded',
            'partially_refunded' => 'Partial Refund',
            'disputed' => 'Disputed',
            default => ucfirst($this->status ?? 'Unknown'),
        };
    }

    public function getPaymentMethodDisplayAttribute(): string
    {
        return 'Payment received';
    }

    public function getCardExpiryAttribute(): ?string
    {
        return null;
    }

    public function isSuccessful(): bool
    {
        return in_array($this->status, ['succeeded', 'paid']);
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isRefunded(): bool
    {
        return in_array($this->status, ['refunded', 'partially_refunded']);
    }

    public function isPartiallyRefunded(): bool
    {
        return $this->amount_refunded > 0 && $this->amount_refunded < $this->amount;
    }

    public function isDisputed(): bool
    {
        return $this->disputed || $this->status === 'disputed';
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type ?? 'payment') {
            'payment', 'charge' => 'heroicon-o-credit-card',
            'refund' => 'heroicon-o-arrow-uturn-left',
            'invoice' => 'heroicon-o-document-text',
            'subscription' => 'heroicon-o-arrow-path',
            default => 'heroicon-o-banknotes',
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type ?? 'payment') {
            'payment', 'charge' => 'green',
            'refund' => 'orange',
            'invoice' => 'blue',
            'subscription' => 'purple',
            default => 'gray',
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_uuid',
        'stripe_payment_id',
        'stripe_invoice_id',
        'stripe_charge_id',
        'stripe_refund_id',
        'subscription_id',
        'amount',
        'amount_refunded',
        'currency',
        'status',
        'type',
        'description',
        'payment_method',
        'payment_method_type',
        'card_brand',
        'card_last4',
        'card_exp_month',
        'card_exp_year',
        'receipt_url',
        'invoice_pdf_url',
        'invoice_number',
        'billing_reason',
        'failure_code',
        'failure_message',
        'refund_reason',
        'refunded_at',
        'disputed',
        'dispute_status',
        'dispute_reason',
        'disputed_at',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'integer',
        'amount_refunded' => 'integer',
        'card_exp_month' => 'integer',
        'card_exp_year' => 'integer',
        'disputed' => 'boolean',
        'refunded_at' => 'datetime',
        'disputed_at' => 'datetime',
        'metadata' => 'array',
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
        if ($this->card_brand && $this->card_last4) {
            return ucfirst($this->card_brand) . ' •••• ' . $this->card_last4;
        }
        return $this->payment_method_type ?? $this->payment_method ?? 'Unknown';
    }

    public function getCardExpiryAttribute(): ?string
    {
        if (!$this->card_exp_month || !$this->card_exp_year) {
            return null;
        }
        return sprintf('%02d/%02d', $this->card_exp_month, $this->card_exp_year % 100);
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

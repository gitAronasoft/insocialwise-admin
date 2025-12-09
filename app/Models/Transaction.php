<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction where($column, $operator = null, $value = null)
 * @method static Builder|Transaction whereIn($column, $values)
 * @method static Builder|Transaction whereDate($column, $operator, $value = null)
 * @method static Builder|Transaction selectRaw($expression, array $bindings = [])
 * @method static int count($columns = '*')
 * @method static float|int sum($column)
 * @mixin Builder
 */
class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_uuid',
        'stripe_payment_intent_id',
        'stripe_invoice_id',
        'stripe_charge_id',
        'stripe_refund_id',
        'subscription_id',
        'amount',
        'currency',
        'status',
        'plan_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'stripe_payment_method_id',
        'invoice_number',
        'invoice_pdf_url',
        'billing_reason',
        'failure_code',
        'failure_message',
        'refund_reason',
        'refunded_at',
        'disputed',
        'metadata',
    ];

    public $timestamps = false;

    protected $casts = [
        'amount' => 'integer',
        'disputed' => 'boolean',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
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

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'stripe_payment_method_id', 'stripe_payment_method_id');
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

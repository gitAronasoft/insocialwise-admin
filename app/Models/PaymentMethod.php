<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    protected $fillable = [
        'user_uuid',
        'stripe_payment_method_id',
        'stripe_customer_id',
        'type',
        'brand',
        'card_brand',
        'last4',
        'card_last4',
        'exp_month',
        'exp_year',
        'card_holder_name',
        'funding',
        'country',
        'billing_details',
        'fingerprint',
        'wallet',
        'is_default',
        'status',
        'billing_email',
        'billing_name',
        'billing_phone',
        'billing_address',
        'metadata',
    ];

    protected $casts = [
        'billing_details' => 'array',
        'billing_address' => 'array',
        'metadata' => 'array',
        'is_default' => 'boolean',
        'exp_month' => 'integer',
        'exp_year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDefault($query)
    {
        return $query->whereRaw('is_default IS TRUE');
    }

    public function getCardBrandIconAttribute(): string
    {
        return match (strtolower($this->brand ?? '')) {
            'visa' => 'fab fa-cc-visa',
            'mastercard' => 'fab fa-cc-mastercard',
            'amex', 'american express' => 'fab fa-cc-amex',
            'discover' => 'fab fa-cc-discover',
            'diners', 'diners club' => 'fab fa-cc-diners-club',
            'jcb' => 'fab fa-cc-jcb',
            default => 'fas fa-credit-card',
        };
    }

    public function getDisplayNameAttribute(): string
    {
        $brand = ucfirst($this->brand ?? 'Card');
        $last4 = $this->last4 ?? '****';
        return "{$brand} ending in {$last4}";
    }

    public function getExpiryDisplayAttribute(): string
    {
        if (!$this->exp_month || !$this->exp_year) {
            return '--/--';
        }
        return sprintf('%02d/%02d', $this->exp_month, $this->exp_year % 100);
    }

    public function getCardHolderAttribute(): ?string
    {
        if (!$this->billing_details) {
            return null;
        }
        return $this->billing_details['name'] ?? null;
    }

    public function isExpired(): bool
    {
        if (!$this->exp_month || !$this->exp_year) {
            return false;
        }

        $expiry = \Carbon\Carbon::createFromDate($this->exp_year, $this->exp_month)->endOfMonth();
        return $expiry->isPast();
    }

    public function isExpiringSoon(int $months = 2): bool
    {
        if (!$this->exp_month || !$this->exp_year) {
            return false;
        }

        $expiry = \Carbon\Carbon::createFromDate($this->exp_year, $this->exp_month)->endOfMonth();
        return $expiry->isBetween(now(), now()->addMonths($months));
    }

    public function getStatusColorAttribute(): string
    {
        if ($this->isExpired()) {
            return 'red';
        }
        
        if ($this->isExpiringSoon()) {
            return 'yellow';
        }

        return match ($this->status) {
            'active' => 'green',
            'expired' => 'red',
            'failed' => 'red',
            'removed' => 'gray',
            default => 'gray',
        };
    }
}

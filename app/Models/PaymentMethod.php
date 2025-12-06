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
        'card_brand',
        'card_last4',
        'card_exp_month',
        'card_exp_year',
        'card_funding',
        'card_country',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'is_default',
        'status',
        'expires_at',
        'last_used_at',
        'metadata',
    ];

    protected $casts = [
        'billing_address' => 'array',
        'metadata' => 'array',
        'is_default' => 'boolean',
        'card_exp_month' => 'integer',
        'card_exp_year' => 'integer',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

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
        return $query->where('is_default', true);
    }

    public function getCardBrandIconAttribute(): string
    {
        return match (strtolower($this->card_brand ?? '')) {
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
        $brand = ucfirst($this->card_brand ?? 'Card');
        return "{$brand} ending in {$this->card_last4}";
    }

    public function getExpiryDisplayAttribute(): string
    {
        return sprintf('%02d/%d', $this->card_exp_month, $this->card_exp_year % 100);
    }

    public function isExpired(): bool
    {
        if (!$this->card_exp_month || !$this->card_exp_year) {
            return false;
        }

        $expiry = \Carbon\Carbon::createFromDate($this->card_exp_year, $this->card_exp_month)->endOfMonth();
        return $expiry->isPast();
    }

    public function isExpiringSoon(int $months = 2): bool
    {
        if (!$this->card_exp_month || !$this->card_exp_year) {
            return false;
        }

        $expiry = \Carbon\Carbon::createFromDate($this->card_exp_year, $this->card_exp_month)->endOfMonth();
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

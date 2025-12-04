<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'stripe_price_id',
        'stripe_yearly_price_id',
        'stripe_product_id',
        'price',
        'yearly_price',
        'yearly_discount_percent',
        'currency',
        'billing_cycle',
        'features',
        'description',
        'max_social_accounts',
        'max_team_members',
        'max_scheduled_posts',
        'platform_limits',
        'active',
        'is_featured',
        'sort_order',
        'trial_period_days',
        'trial_enabled',
        'skip_trial_discount_enabled',
        'skip_trial_discount_percent',
        'is_contact_only',
        'show_on_landing',
    ];

    protected $casts = [
        'features' => 'array',
        'platform_limits' => 'array',
        'price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'active' => 'boolean',
        'is_featured' => 'boolean',
        'is_contact_only' => 'boolean',
        'show_on_landing' => 'boolean',
        'trial_enabled' => 'boolean',
        'skip_trial_discount_enabled' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getActivePlans()
    {
        return static::where('active', true)->orderBy('sort_order')->get();
    }

    public static function getLandingPagePlans()
    {
        return static::where('active', true)
            ->where('show_on_landing', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_contact_only) {
            return 'Custom';
        }

        $symbol = match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            default => $this->currency . ' ',
        };
        
        return $symbol . number_format($this->price, 0);
    }

    public function getFormattedYearlyPriceAttribute(): string
    {
        if ($this->is_contact_only || !$this->yearly_price) {
            return 'Custom';
        }

        $symbol = match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            default => $this->currency . ' ',
        };
        
        return $symbol . number_format($this->yearly_price, 0);
    }

    public function getYearlyMonthlyEquivalentAttribute(): float
    {
        if (!$this->yearly_price) {
            return 0;
        }
        return round($this->yearly_price / 12, 2);
    }

    public function getCalculatedYearlySavingsAttribute(): float
    {
        if (!$this->price || !$this->yearly_price) {
            return 0;
        }
        $fullYearlyPrice = $this->price * 12;
        return round($fullYearlyPrice - $this->yearly_price, 2);
    }

    public function getBillingCycleTextAttribute(): string
    {
        if ($this->is_contact_only) {
            return 'Tailored pricing';
        }

        return match ($this->billing_cycle) {
            'monthly' => '/month',
            'yearly' => '/year',
            'one_time' => 'one-time',
            default => '',
        };
    }

    public function canSyncToStripe(): bool
    {
        return !$this->is_contact_only && $this->price > 0;
    }

    public function hasTrialEnabled(): bool
    {
        return $this->trial_enabled && $this->trial_period_days > 0;
    }

    public function getTrialInfoAttribute(): ?array
    {
        if (!$this->hasTrialEnabled()) {
            return null;
        }

        return [
            'days' => $this->trial_period_days,
            'skip_discount_enabled' => $this->skip_trial_discount_enabled,
            'skip_discount_percent' => $this->skip_trial_discount_percent,
        ];
    }

    public function getLimitsAttribute(): array
    {
        return [
            'social_accounts' => $this->max_social_accounts,
            'team_members' => $this->max_team_members,
            'scheduled_posts' => $this->max_scheduled_posts,
            'platforms' => $this->platform_limits ?? [],
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    public function getActiveSubscriptionsCountAttribute(): int
    {
        return $this->subscriptions()->where('status', 'active')->count();
    }

    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'formatted_price' => $this->formatted_price,
            'yearly_price' => $this->yearly_price,
            'formatted_yearly_price' => $this->formatted_yearly_price,
            'yearly_discount_percent' => $this->yearly_discount_percent,
            'yearly_monthly_equivalent' => $this->yearly_monthly_equivalent,
            'yearly_savings' => $this->calculated_yearly_savings,
            'billing_cycle' => $this->billing_cycle,
            'billing_cycle_text' => $this->billing_cycle_text,
            'currency' => $this->currency,
            'features' => $this->features ?? [],
            'description' => $this->description,
            'limits' => $this->limits,
            'is_featured' => $this->is_featured,
            'is_contact_only' => $this->is_contact_only,
            'trial_info' => $this->trial_info,
            'stripe_price_id' => $this->is_contact_only ? null : $this->stripe_price_id,
            'stripe_yearly_price_id' => $this->is_contact_only ? null : $this->stripe_yearly_price_id,
        ];
    }
}

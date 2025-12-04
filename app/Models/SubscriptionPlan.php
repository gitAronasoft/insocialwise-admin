<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'stripe_price_id',
        'stripe_yearly_price_id',
        'stripe_product_id',
        'price',
        'yearly_price',
        'yearly_discount_percent',
        'monthly_price_usd',
        'yearly_price_usd',
        'monthly_price_inr',
        'yearly_price_inr',
        'currency',
        'billing_cycle',
        'features',
        'display_features',
        'max_social_accounts',
        'max_team_members',
        'max_scheduled_posts',
        'ai_tokens_per_month',
        'ai_auto_comment_reply',
        'ai_auto_dm_reply',
        'ai_semantic_analysis',
        'ai_driven_reporting',
        'ai_content_generator',
        'social_profile_score',
        'calendar_scheduling',
        'unified_inbox',
        'export_reports',
        'white_label',
        'fb_ads_analytics',
        'fb_ads_creation',
        'team_roles_permissions',
        'client_workspaces',
        'support_level',
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
        'display_features' => 'array',
        'platform_limits' => 'array',
        'price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'monthly_price_usd' => 'decimal:2',
        'yearly_price_usd' => 'decimal:2',
        'monthly_price_inr' => 'decimal:2',
        'yearly_price_inr' => 'decimal:2',
        'active' => 'boolean',
        'is_featured' => 'boolean',
        'is_contact_only' => 'boolean',
        'show_on_landing' => 'boolean',
        'trial_enabled' => 'boolean',
        'skip_trial_discount_enabled' => 'boolean',
        'ai_auto_comment_reply' => 'boolean',
        'ai_auto_dm_reply' => 'boolean',
        'ai_semantic_analysis' => 'boolean',
        'ai_driven_reporting' => 'boolean',
        'ai_content_generator' => 'boolean',
        'unified_inbox' => 'boolean',
        'white_label' => 'boolean',
        'fb_ads_analytics' => 'boolean',
        'fb_ads_creation' => 'boolean',
        'team_roles_permissions' => 'boolean',
        'client_workspaces' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($plan) {
            if (empty($plan->slug)) {
                $plan->slug = Str::slug($plan->name);
            }
        });
        
        static::updating(function ($plan) {
            if ($plan->isDirty('name') && empty($plan->slug)) {
                $plan->slug = Str::slug($plan->name);
            }
        });
    }

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

    public function getFormattedPriceUsdAttribute(): string
    {
        if ($this->is_contact_only) {
            return 'Custom';
        }
        return '$' . number_format($this->monthly_price_usd, 0);
    }

    public function getFormattedYearlyPriceUsdAttribute(): string
    {
        if ($this->is_contact_only || !$this->yearly_price_usd) {
            return 'Custom';
        }
        return '$' . number_format($this->yearly_price_usd, 0);
    }

    public function getFormattedPriceInrAttribute(): string
    {
        if ($this->is_contact_only) {
            return 'Custom';
        }
        return '₹' . number_format($this->monthly_price_inr, 0);
    }

    public function getFormattedYearlyPriceInrAttribute(): string
    {
        if ($this->is_contact_only || !$this->yearly_price_inr) {
            return 'Custom';
        }
        return '₹' . number_format($this->yearly_price_inr, 0);
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

    public function getYearlySavingsUsdAttribute(): float
    {
        if (!$this->monthly_price_usd || !$this->yearly_price_usd) {
            return 0;
        }
        return round(($this->monthly_price_usd * 12) - $this->yearly_price_usd, 2);
    }

    public function getYearlySavingsInrAttribute(): float
    {
        if (!$this->monthly_price_inr || !$this->yearly_price_inr) {
            return 0;
        }
        return round(($this->monthly_price_inr * 12) - $this->yearly_price_inr, 2);
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
        return !$this->is_contact_only && ($this->price > 0 || $this->monthly_price_usd > 0);
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
            'ai_tokens' => $this->ai_tokens_per_month,
            'platforms' => $this->platform_limits ?? [],
        ];
    }

    public function getAiFeaturesAttribute(): array
    {
        return [
            'auto_comment_reply' => $this->ai_auto_comment_reply,
            'auto_dm_reply' => $this->ai_auto_dm_reply,
            'semantic_analysis' => $this->ai_semantic_analysis,
            'driven_reporting' => $this->ai_driven_reporting,
            'content_generator' => $this->ai_content_generator,
            'profile_score' => $this->social_profile_score,
        ];
    }

    public function getCoreFeaturesAttribute(): array
    {
        return [
            'calendar_scheduling' => $this->calendar_scheduling,
            'unified_inbox' => $this->unified_inbox,
            'export_reports' => $this->export_reports,
            'white_label' => $this->white_label,
            'fb_ads_analytics' => $this->fb_ads_analytics,
            'fb_ads_creation' => $this->fb_ads_creation,
            'team_roles_permissions' => $this->team_roles_permissions,
            'client_workspaces' => $this->client_workspaces,
        ];
    }

    public function getSupportLevelLabelAttribute(): string
    {
        return match ($this->support_level) {
            'standard' => 'Standard Email Support',
            'priority' => 'Priority Support',
            'priority_chat' => 'Priority Chat + Email',
            'enterprise' => '24×7 Enterprise Support',
            default => 'Standard Support',
        };
    }

    public function getCalendarSchedulingLabelAttribute(): string
    {
        return match ($this->calendar_scheduling) {
            'none' => 'Not Available',
            'basic' => 'Basic',
            'advanced' => 'Advanced + Bulk',
            default => 'Not Available',
        };
    }

    public function getExportReportsLabelAttribute(): string
    {
        return match ($this->export_reports) {
            'none' => 'Not Available',
            'basic' => 'PDF/CSV',
            'white_label' => 'White-Label',
            default => 'Not Available',
        };
    }

    public function getSocialProfileScoreLabelAttribute(): string
    {
        return match ($this->social_profile_score) {
            'none' => 'Not Available',
            'basic' => 'Basic',
            'full' => 'Full',
            default => 'Not Available',
        };
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
            'slug' => $this->slug,
            'description' => $this->description,
            'pricing' => [
                'usd' => [
                    'monthly' => $this->monthly_price_usd,
                    'yearly' => $this->yearly_price_usd,
                    'formatted_monthly' => $this->formatted_price_usd,
                    'formatted_yearly' => $this->formatted_yearly_price_usd,
                    'yearly_savings' => $this->yearly_savings_usd,
                ],
                'inr' => [
                    'monthly' => $this->monthly_price_inr,
                    'yearly' => $this->yearly_price_inr,
                    'formatted_monthly' => $this->formatted_price_inr,
                    'formatted_yearly' => $this->formatted_yearly_price_inr,
                    'yearly_savings' => $this->yearly_savings_inr,
                ],
            ],
            'yearly_discount_percent' => $this->yearly_discount_percent,
            'limits' => $this->limits,
            'ai_features' => $this->ai_features,
            'core_features' => $this->core_features,
            'support_level' => $this->support_level,
            'display_features' => $this->display_features ?? [],
            'is_featured' => $this->is_featured,
            'is_contact_only' => $this->is_contact_only,
            'trial_info' => $this->trial_info,
            'stripe_price_id' => $this->is_contact_only ? null : $this->stripe_price_id,
            'stripe_yearly_price_id' => $this->is_contact_only ? null : $this->stripe_yearly_price_id,
        ];
    }

    public function toLandingPageArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'pricing' => [
                'usd' => [
                    'monthly' => $this->formatted_price_usd,
                    'yearly' => $this->formatted_yearly_price_usd,
                    'yearly_savings' => $this->yearly_savings_usd,
                ],
                'inr' => [
                    'monthly' => $this->formatted_price_inr,
                    'yearly' => $this->formatted_yearly_price_inr,
                    'yearly_savings' => $this->yearly_savings_inr,
                ],
            ],
            'yearly_discount_percent' => $this->yearly_discount_percent,
            'limits' => [
                'social_profiles' => $this->max_social_accounts == -1 ? 'Unlimited' : $this->max_social_accounts,
                'users' => $this->max_team_members == -1 ? 'Unlimited' : $this->max_team_members,
                'ai_tokens' => $this->ai_tokens_per_month == -1 ? 'Unlimited' : $this->ai_tokens_per_month,
            ],
            'display_features' => $this->display_features ?? [],
            'is_featured' => $this->is_featured,
            'is_contact_only' => $this->is_contact_only,
            'support_level' => $this->support_level_label,
        ];
    }
}

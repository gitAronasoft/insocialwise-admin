<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AnalyticsService
{
    private const CACHE_TTL = 300;

    public function getDateRange(string $period): array
    {
        $now = Carbon::now();
        
        switch ($period) {
            case 'week':
                return [
                    'start' => $now->copy()->startOfWeek(),
                    'end' => $now->copy()->endOfWeek(),
                    'previous_start' => $now->copy()->subWeek()->startOfWeek(),
                    'previous_end' => $now->copy()->subWeek()->endOfWeek(),
                    'label' => 'This Week',
                    'comparison_label' => 'vs Last Week',
                ];
            case 'month':
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth(),
                    'previous_start' => $now->copy()->subMonth()->startOfMonth(),
                    'previous_end' => $now->copy()->subMonth()->endOfMonth(),
                    'label' => 'This Month',
                    'comparison_label' => 'vs Last Month',
                ];
            case 'quarter':
                return [
                    'start' => $now->copy()->startOfQuarter(),
                    'end' => $now->copy()->endOfQuarter(),
                    'previous_start' => $now->copy()->subQuarter()->startOfQuarter(),
                    'previous_end' => $now->copy()->subQuarter()->endOfQuarter(),
                    'label' => 'This Quarter',
                    'comparison_label' => 'vs Last Quarter',
                ];
            case 'year':
                return [
                    'start' => $now->copy()->startOfYear(),
                    'end' => $now->copy()->endOfYear(),
                    'previous_start' => $now->copy()->subYear()->startOfYear(),
                    'previous_end' => $now->copy()->subYear()->endOfYear(),
                    'label' => 'This Year',
                    'comparison_label' => 'vs Last Year',
                ];
            default:
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth(),
                    'previous_start' => $now->copy()->subMonth()->startOfMonth(),
                    'previous_end' => $now->copy()->subMonth()->endOfMonth(),
                    'label' => 'This Month',
                    'comparison_label' => 'vs Last Month',
                ];
        }
    }

    public function calculateGrowth(float $current, float $previous): array
    {
        if ($previous == 0) {
            $percentage = $current > 0 ? 100 : 0;
        } else {
            $percentage = round((($current - $previous) / $previous) * 100, 1);
        }

        return [
            'current' => $current,
            'previous' => $previous,
            'difference' => $current - $previous,
            'percentage' => $percentage,
            'trend' => $percentage >= 0 ? 'up' : 'down',
            'is_positive' => $percentage >= 0,
        ];
    }

    public function getTotalRevenue(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_revenue_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $currentCents = Transaction::whereIn('status', ['succeeded', 'paid'])
                    ->whereBetween('paid_at', [$range['start'], $range['end']])
                    ->sum('amount');

                $previousCents = Transaction::whereIn('status', ['succeeded', 'paid'])
                    ->whereBetween('paid_at', [$range['previous_start'], $range['previous_end']])
                    ->sum('amount');

                $current = $currentCents / 100;
                $previous = $previousCents / 100;

                $growth = $this->calculateGrowth((float)$current, (float)$previous);

                return array_merge($growth, [
                    'formatted' => '$' . number_format($current, 2),
                    'period_label' => $range['label'],
                    'comparison_label' => $range['comparison_label'],
                ]);
            } catch (\Exception $e) {
                Log::warning('Analytics: getTotalRevenue error', ['error' => $e->getMessage()]);
                return $this->emptyRevenueResult($range);
            }
        });
    }

    private function emptyRevenueResult(array $range): array
    {
        return [
            'current' => 0,
            'previous' => 0,
            'difference' => 0,
            'percentage' => 0,
            'trend' => 'up',
            'is_positive' => true,
            'formatted' => '$0.00',
            'period_label' => $range['label'] ?? 'This Month',
            'comparison_label' => $range['comparison_label'] ?? 'vs Last Month',
        ];
    }

    public function getMRR(): array
    {
        $cacheKey = "analytics_mrr";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            try {
                $activeSubscriptions = Subscription::where('status', 'active')
                    ->get();

                $currentMRR = 0;
                foreach ($activeSubscriptions as $subscription) {
                    // Amount is stored in cents, convert to dollars
                    $currentMRR += ($subscription->amount ?? 0) / 100;
                }

                $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
                $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

                $previousMRR = Transaction::whereIn('status', ['succeeded', 'paid'])
                    ->whereBetween('paid_at', [$lastMonthStart, $lastMonthEnd])
                    ->sum('amount') / 100;

                $growth = $this->calculateGrowth($currentMRR, (float)$previousMRR);

                return array_merge($growth, [
                    'formatted' => '$' . number_format($currentMRR, 2),
                    'label' => 'Monthly Recurring Revenue',
                ]);
            } catch (\Exception $e) {
                Log::warning('Analytics: getMRR error', ['error' => $e->getMessage()]);
                return [
                    'current' => 0,
                    'previous' => 0,
                    'difference' => 0,
                    'percentage' => 0,
                    'trend' => 'up',
                    'is_positive' => true,
                    'formatted' => '$0.00',
                    'label' => 'Monthly Recurring Revenue',
                ];
            }
        });
    }

    public function getARPU(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_arpu_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $currentRevenueCents = Transaction::whereIn('status', ['succeeded', 'paid'])
                    ->whereBetween('paid_at', [$range['start'], $range['end']])
                    ->sum('amount');

                $currentRevenue = $currentRevenueCents / 100;
                $activeUsers = Subscription::where('status', 'active')->count();
                $currentARPU = $activeUsers > 0 ? $currentRevenue / $activeUsers : 0;

                $previousRevenueCents = Transaction::whereIn('status', ['succeeded', 'paid'])
                    ->whereBetween('paid_at', [$range['previous_start'], $range['previous_end']])
                    ->sum('amount');
                
                $previousRevenue = $previousRevenueCents / 100;

                $previousActiveUsers = Subscription::where('status', 'active')
                    ->where('createdAt', '<=', $range['previous_end'])
                    ->count();
                $previousARPU = $previousActiveUsers > 0 ? $previousRevenue / $previousActiveUsers : 0;

                $growth = $this->calculateGrowth($currentARPU, $previousARPU);

                return array_merge($growth, [
                    'formatted' => '$' . number_format($currentARPU, 2),
                    'label' => 'Avg Revenue Per User',
                    'period_label' => $range['label'],
                ]);
            } catch (\Exception $e) {
                Log::warning('Analytics: getARPU error', ['error' => $e->getMessage()]);
                return [
                    'current' => 0,
                    'previous' => 0,
                    'difference' => 0,
                    'percentage' => 0,
                    'trend' => 'up',
                    'is_positive' => true,
                    'formatted' => '$0.00',
                    'label' => 'Avg Revenue Per User',
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    public function getMostPopularPlan(): array
    {
        $cacheKey = "analytics_popular_plan";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            try {
                $plans = SubscriptionPlan::where('active', true)->get();
                $planStats = [];

                foreach ($plans as $plan) {
                    $subscriptionCount = Subscription::where(function ($query) use ($plan) {
                        $query->where('price_id', $plan->stripe_price_id)
                            ->orWhere('price_id', $plan->stripe_yearly_price_id);
                    })
                    ->where('status', 'active')
                    ->count();

                    $subscriptionIds = Subscription::where(function ($query) use ($plan) {
                        $query->where('price_id', $plan->stripe_price_id)
                            ->orWhere('price_id', $plan->stripe_yearly_price_id);
                    })->pluck('user_uuid');

                    $revenue = Transaction::whereIn('status', ['succeeded', 'paid'])
                        ->whereIn('user_uuid', $subscriptionIds)
                        ->sum('amount');

                    $planStats[] = [
                        'id' => $plan->id,
                        'name' => $plan->name,
                        'subscribers' => $subscriptionCount,
                        'revenue' => $revenue,
                        'price' => $plan->monthly_price_usd ?? $plan->price,
                    ];
                }

                usort($planStats, function ($a, $b) {
                    return $b['revenue'] <=> $a['revenue'];
                });

                $topPlan = $planStats[0] ?? null;

                return [
                    'plan' => $topPlan,
                    'all_plans' => $planStats,
                    'label' => 'Most Popular Plan',
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getMostPopularPlan error', ['error' => $e->getMessage()]);
                return [
                    'plan' => null,
                    'all_plans' => [],
                    'label' => 'Most Popular Plan',
                ];
            }
        });
    }

    public function getRevenueByPlan(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_revenue_by_plan_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $plans = SubscriptionPlan::where('active', true)->get();
                $planRevenue = [];
                $totalRevenue = 0;

                foreach ($plans as $plan) {
                    $subscriptionIds = Subscription::where(function ($query) use ($plan) {
                        $query->where('price_id', $plan->stripe_price_id)
                            ->orWhere('price_id', $plan->stripe_yearly_price_id);
                    })->pluck('user_uuid');

                    $revenue = Transaction::whereIn('status', ['succeeded', 'paid'])
                        ->whereIn('user_uuid', $subscriptionIds)
                        ->whereBetween('paid_at', [$range['start'], $range['end']])
                        ->sum('amount');

                    $totalRevenue += $revenue;

                    $planRevenue[] = [
                        'name' => $plan->name,
                        'revenue' => (float)$revenue,
                        'formatted' => '$' . number_format($revenue, 2),
                        'color' => $this->getPlanColor($plan->name),
                    ];
                }

                foreach ($planRevenue as &$plan) {
                    $plan['percentage'] = $totalRevenue > 0 
                        ? round(($plan['revenue'] / $totalRevenue) * 100, 1) 
                        : 0;
                }

                usort($planRevenue, function ($a, $b) {
                    return $b['revenue'] <=> $a['revenue'];
                });

                return [
                    'plans' => $planRevenue,
                    'total' => $totalRevenue,
                    'formatted_total' => '$' . number_format($totalRevenue, 2),
                    'period_label' => $range['label'],
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getRevenueByPlan error', ['error' => $e->getMessage()]);
                return [
                    'plans' => [],
                    'total' => 0,
                    'formatted_total' => '$0.00',
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    private function getPlanColor(string $planName): string
    {
        $colors = [
            'starter' => '#3B82F6',
            'growth' => '#10B981',
            'agency' => '#8B5CF6',
            'enterprise' => '#F59E0B',
        ];

        return $colors[strtolower($planName)] ?? '#6B7280';
    }

    public function getActiveSubscriptions(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_active_subs_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $current = Subscription::where('status', 'active')->count();

                $previous = Subscription::where('status', 'active')
                    ->where('createdAt', '<=', $range['previous_end'])
                    ->count();

                $newThisPeriod = Subscription::where('status', 'active')
                    ->whereBetween('createdAt', [$range['start'], $range['end']])
                    ->count();

                $growth = $this->calculateGrowth((float)$current, (float)$previous);

                return array_merge($growth, [
                    'new_this_period' => $newThisPeriod,
                    'label' => 'Active Subscriptions',
                    'period_label' => $range['label'],
                ]);
            } catch (\Exception $e) {
                Log::warning('Analytics: getActiveSubscriptions error', ['error' => $e->getMessage()]);
                return [
                    'current' => 0,
                    'previous' => 0,
                    'difference' => 0,
                    'percentage' => 0,
                    'trend' => 'up',
                    'is_positive' => true,
                    'new_this_period' => 0,
                    'label' => 'Active Subscriptions',
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    public function getFailedSubscriptions(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_failed_subs_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $current = Subscription::whereIn('status', ['past_due', 'unpaid', 'incomplete', 'incomplete_expired'])
                    ->whereBetween('updatedAt', [$range['start'], $range['end']])
                    ->count();

                $previous = Subscription::whereIn('status', ['past_due', 'unpaid', 'incomplete', 'incomplete_expired'])
                    ->whereBetween('updatedAt', [$range['previous_start'], $range['previous_end']])
                    ->count();

                $failedPayments = Transaction::where('status', 'failed')
                    ->whereBetween('paid_at', [$range['start'], $range['end']])
                    ->count();

                $growth = $this->calculateGrowth((float)$current, (float)$previous);
                $growth['is_positive'] = $growth['percentage'] <= 0;

                return array_merge($growth, [
                    'failed_payments' => $failedPayments,
                    'label' => 'Failed Subscriptions',
                    'period_label' => $range['label'],
                ]);
            } catch (\Exception $e) {
                Log::warning('Analytics: getFailedSubscriptions error', ['error' => $e->getMessage()]);
                return [
                    'current' => 0,
                    'previous' => 0,
                    'difference' => 0,
                    'percentage' => 0,
                    'trend' => 'up',
                    'is_positive' => true,
                    'failed_payments' => 0,
                    'label' => 'Failed Subscriptions',
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    public function getChurnRate(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_churn_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $startingSubscriptions = Subscription::where('status', 'active')
                    ->where('createdAt', '<', $range['start'])
                    ->count();

                $churned = Subscription::where('status', 'canceled')
                    ->whereBetween('canceled_at', [$range['start'], $range['end']])
                    ->count();

                $currentChurnRate = $startingSubscriptions > 0 
                    ? round(($churned / $startingSubscriptions) * 100, 2) 
                    : 0;

                $previousStartingSubs = Subscription::where('status', 'active')
                    ->where('createdAt', '<', $range['previous_start'])
                    ->count();

                $previousChurned = Subscription::where('status', 'canceled')
                    ->whereBetween('canceled_at', [$range['previous_start'], $range['previous_end']])
                    ->count();

                $previousChurnRate = $previousStartingSubs > 0 
                    ? round(($previousChurned / $previousStartingSubs) * 100, 2) 
                    : 0;

                $growth = $this->calculateGrowth($currentChurnRate, $previousChurnRate);
                $growth['is_positive'] = $growth['percentage'] <= 0;

                return array_merge($growth, [
                    'churned_count' => $churned,
                    'formatted' => $currentChurnRate . '%',
                    'label' => 'Churn Rate',
                    'period_label' => $range['label'],
                ]);
            } catch (\Exception $e) {
                Log::warning('Analytics: getChurnRate error', ['error' => $e->getMessage()]);
                return [
                    'current' => 0,
                    'previous' => 0,
                    'difference' => 0,
                    'percentage' => 0,
                    'trend' => 'up',
                    'is_positive' => true,
                    'churned_count' => 0,
                    'formatted' => '0%',
                    'label' => 'Churn Rate',
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    public function getTrialMetrics(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_trial_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $totalTrials = Subscription::where('status', 'trialing')
                    ->orWhere(function ($query) use ($range) {
                        $query->whereNotNull('trial_end')
                            ->whereBetween('createdAt', [$range['start'], $range['end']]);
                    })
                    ->count();

                $convertedTrials = Subscription::where('status', 'active')
                    ->whereNotNull('trial_end')
                    ->where('trial_end', '<', Carbon::now())
                    ->whereBetween('createdAt', [$range['start'], $range['end']])
                    ->count();

                $conversionRate = $totalTrials > 0 
                    ? round(($convertedTrials / $totalTrials) * 100, 1) 
                    : 0;

                $activeTrials = Subscription::where('status', 'trialing')->count();

                $avgTrialDays = Subscription::where('status', 'active')
                    ->whereNotNull('trial_end')
                    ->where('trial_end', '<', Carbon::now())
                    ->selectRaw('AVG(DATEDIFF(trial_end, createdAt)) as avg_days')
                    ->first();

                $abandonedTrials = Subscription::whereIn('status', ['canceled', 'incomplete_expired'])
                    ->whereNotNull('trial_end')
                    ->whereBetween('createdAt', [$range['start'], $range['end']])
                    ->count();

                $abandonmentRate = $totalTrials > 0 
                    ? round(($abandonedTrials / $totalTrials) * 100, 1) 
                    : 0;

                return [
                    'total_trials' => $totalTrials,
                    'converted_trials' => $convertedTrials,
                    'conversion_rate' => $conversionRate,
                    'conversion_rate_formatted' => $conversionRate . '%',
                    'active_trials' => $activeTrials,
                    'avg_trial_days' => round($avgTrialDays->avg_days ?? 0),
                    'abandoned_trials' => $abandonedTrials,
                    'abandonment_rate' => $abandonmentRate,
                    'abandonment_rate_formatted' => $abandonmentRate . '%',
                    'period_label' => $range['label'],
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getTrialMetrics error', ['error' => $e->getMessage()]);
                return [
                    'total_trials' => 0,
                    'converted_trials' => 0,
                    'conversion_rate' => 0,
                    'conversion_rate_formatted' => '0%',
                    'active_trials' => 0,
                    'avg_trial_days' => 0,
                    'abandoned_trials' => 0,
                    'abandonment_rate' => 0,
                    'abandonment_rate_formatted' => '0%',
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    public function getSubscriptionTrends(string $period = 'month'): array
    {
        $cacheKey = "analytics_sub_trends_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($period) {
            try {
                $dataPoints = $this->getDataPointsForPeriod($period);
                
                $labels = [];
                $newSubscriptions = [];
                $canceledSubscriptions = [];
                $renewedSubscriptions = [];

                foreach ($dataPoints as $point) {
                    $labels[] = $point['label'];
                    
                    $new = Subscription::whereBetween('createdAt', [$point['start'], $point['end']])
                        ->count();
                    $newSubscriptions[] = $new;

                    $canceled = Subscription::where('status', 'canceled')
                        ->whereBetween('canceled_at', [$point['start'], $point['end']])
                        ->count();
                    $canceledSubscriptions[] = $canceled;

                    $renewed = Subscription::where('status', 'active')
                        ->whereBetween('current_period_start', [$point['start'], $point['end']])
                        ->where('createdAt', '<', $point['start'])
                        ->count();
                    $renewedSubscriptions[] = $renewed;
                }

                return [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => 'New',
                            'data' => $newSubscriptions,
                            'borderColor' => '#10B981',
                            'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                        ],
                        [
                            'label' => 'Renewed',
                            'data' => $renewedSubscriptions,
                            'borderColor' => '#3B82F6',
                            'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                        ],
                        [
                            'label' => 'Canceled',
                            'data' => $canceledSubscriptions,
                            'borderColor' => '#EF4444',
                            'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                        ],
                    ],
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getSubscriptionTrends error', ['error' => $e->getMessage()]);
                return [
                    'labels' => [],
                    'datasets' => [],
                ];
            }
        });
    }

    private function getDataPointsForPeriod(string $period): array
    {
        $now = Carbon::now();
        $points = [];

        switch ($period) {
            case 'week':
                for ($i = 6; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i);
                    $points[] = [
                        'label' => $date->format('D'),
                        'start' => $date->copy()->startOfDay(),
                        'end' => $date->copy()->endOfDay(),
                    ];
                }
                break;
            case 'month':
                for ($i = 3; $i >= 0; $i--) {
                    $date = $now->copy()->subWeeks($i);
                    $points[] = [
                        'label' => 'Week ' . (4 - $i),
                        'start' => $date->copy()->startOfWeek(),
                        'end' => $date->copy()->endOfWeek(),
                    ];
                }
                break;
            case 'quarter':
                for ($i = 2; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $points[] = [
                        'label' => $date->format('M'),
                        'start' => $date->copy()->startOfMonth(),
                        'end' => $date->copy()->endOfMonth(),
                    ];
                }
                break;
            case 'year':
                for ($i = 11; $i >= 0; $i--) {
                    $date = $now->copy()->subMonths($i);
                    $points[] = [
                        'label' => $date->format('M'),
                        'start' => $date->copy()->startOfMonth(),
                        'end' => $date->copy()->endOfMonth(),
                    ];
                }
                break;
        }

        return $points;
    }

    public function getRevenueTrends(string $period = 'month'): array
    {
        $cacheKey = "analytics_revenue_trends_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($period) {
            try {
                $dataPoints = $this->getDataPointsForPeriod($period);
                
                $labels = [];
                $revenues = [];
                $total = 0;

                foreach ($dataPoints as $point) {
                    $labels[] = $point['label'];
                    
                    $revenue = Transaction::whereIn('status', ['succeeded', 'paid'])
                        ->whereBetween('paid_at', [$point['start'], $point['end']])
                        ->sum('amount');
                    
                    $revenues[] = (float)$revenue;
                    $total += $revenue;
                }

                return [
                    'labels' => $labels,
                    'data' => $revenues,
                    'total' => $total,
                    'formatted_total' => '$' . number_format($total, 2),
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getRevenueTrends error', ['error' => $e->getMessage()]);
                return [
                    'labels' => [],
                    'data' => [],
                    'total' => 0,
                    'formatted_total' => '$0.00',
                ];
            }
        });
    }

    public function getSubscriptionHealth(): array
    {
        $cacheKey = "analytics_sub_health";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            try {
                $failedPayments = Transaction::where('status', 'failed')
                    ->where('paid_at', '>=', Carbon::now()->subDays(30))
                    ->count();

                $upcomingRenewals7Days = Subscription::where('status', 'active')
                    ->whereBetween('current_period_end', [Carbon::now(), Carbon::now()->addDays(7)])
                    ->count();

                $upcomingRenewals30Days = Subscription::where('status', 'active')
                    ->whereBetween('current_period_end', [Carbon::now(), Carbon::now()->addDays(30)])
                    ->count();

                $atRiskSubscriptions = Subscription::whereIn('status', ['past_due', 'unpaid'])
                    ->count();

                $expiringTrials = Subscription::where('status', 'trialing')
                    ->whereBetween('trial_end', [Carbon::now(), Carbon::now()->addDays(7)])
                    ->count();

                $pastDue = Subscription::where('status', 'past_due')->count();

                return [
                    'failed_payments_30d' => $failedPayments,
                    'upcoming_renewals_7d' => $upcomingRenewals7Days,
                    'upcoming_renewals_30d' => $upcomingRenewals30Days,
                    'at_risk_subscriptions' => $atRiskSubscriptions,
                    'expiring_trials_7d' => $expiringTrials,
                    'past_due_subscriptions' => $pastDue,
                    'health_score' => $this->calculateHealthScore($failedPayments, $atRiskSubscriptions, $pastDue),
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getSubscriptionHealth error', ['error' => $e->getMessage()]);
                return [
                    'failed_payments_30d' => 0,
                    'upcoming_renewals_7d' => 0,
                    'upcoming_renewals_30d' => 0,
                    'at_risk_subscriptions' => 0,
                    'expiring_trials_7d' => 0,
                    'past_due_subscriptions' => 0,
                    'health_score' => ['score' => 100, 'status' => 'excellent', 'color' => '#10B981'],
                ];
            }
        });
    }

    private function calculateHealthScore(int $failedPayments, int $atRisk, int $pastDue): array
    {
        try {
            $totalActive = Subscription::where('status', 'active')->count();
            $issues = $failedPayments + $atRisk + $pastDue;
            
            if ($totalActive == 0) {
                $score = 100;
            } else {
                $issueRate = ($issues / $totalActive) * 100;
                $score = max(0, 100 - $issueRate);
            }

            $status = 'excellent';
            $color = '#10B981';
            
            if ($score < 70) {
                $status = 'needs_attention';
                $color = '#F59E0B';
            }
            if ($score < 50) {
                $status = 'critical';
                $color = '#EF4444';
            }

            return [
                'score' => round($score),
                'status' => $status,
                'color' => $color,
            ];
        } catch (\Exception $e) {
            return ['score' => 100, 'status' => 'excellent', 'color' => '#10B981'];
        }
    }

    public function getChurnAnalytics(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_churn_details_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $recentlyChurned = Subscription::where('status', 'canceled')
                    ->whereBetween('canceled_at', [$range['start'], $range['end']])
                    ->with('customer')
                    ->orderBy('canceled_at', 'desc')
                    ->limit(10)
                    ->get()
                    ->map(function ($sub) {
                        return [
                            'customer_name' => $sub->customer 
                                ? ($sub->customer->firstName . ' ' . $sub->customer->lastName) 
                                : 'Unknown',
                            'canceled_at' => $sub->canceled_at?->format('M d, Y'),
                            'was_active_for' => $sub->createdAt 
                                ? $sub->createdAt->diffInDays($sub->canceled_at) . ' days'
                                : 'N/A',
                        ];
                    });

                $churnByPlan = [];
                $plans = SubscriptionPlan::where('active', true)->get();

                foreach ($plans as $plan) {
                    $churned = Subscription::where('status', 'canceled')
                        ->where(function ($query) use ($plan) {
                            $query->where('price_id', $plan->stripe_price_id)
                                ->orWhere('price_id', $plan->stripe_yearly_price_id);
                        })
                        ->whereBetween('canceled_at', [$range['start'], $range['end']])
                        ->count();

                    $total = Subscription::where(function ($query) use ($plan) {
                        $query->where('price_id', $plan->stripe_price_id)
                            ->orWhere('price_id', $plan->stripe_yearly_price_id);
                    })
                    ->where('createdAt', '<', $range['start'])
                    ->count();

                    $churnRate = $total > 0 ? round(($churned / $total) * 100, 1) : 0;

                    $churnByPlan[] = [
                        'name' => $plan->name,
                        'churned' => $churned,
                        'total' => $total,
                        'churn_rate' => $churnRate,
                        'churn_rate_formatted' => $churnRate . '%',
                    ];
                }

                return [
                    'recently_churned' => $recentlyChurned,
                    'churn_by_plan' => $churnByPlan,
                    'period_label' => $range['label'],
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getChurnAnalytics error', ['error' => $e->getMessage()]);
                return [
                    'recently_churned' => [],
                    'churn_by_plan' => [],
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    public function getPlanPerformance(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_plan_performance_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $plans = SubscriptionPlan::where('active', true)->get();
                $performance = [];

                foreach ($plans as $plan) {
                    $activeSubscribers = Subscription::where('status', 'active')
                        ->where(function ($query) use ($plan) {
                            $query->where('price_id', $plan->stripe_price_id)
                                ->orWhere('price_id', $plan->stripe_yearly_price_id);
                        })
                        ->count();

                    $subscriptionIds = Subscription::where(function ($query) use ($plan) {
                        $query->where('price_id', $plan->stripe_price_id)
                            ->orWhere('price_id', $plan->stripe_yearly_price_id);
                    })->pluck('user_uuid');

                    $revenue = Transaction::whereIn('status', ['succeeded', 'paid'])
                        ->whereIn('user_uuid', $subscriptionIds)
                        ->whereBetween('paid_at', [$range['start'], $range['end']])
                        ->sum('amount');

                    $totalRevenue = Transaction::whereIn('status', ['succeeded', 'paid'])
                        ->whereIn('user_uuid', $subscriptionIds)
                        ->sum('amount');

                    $trials = Subscription::whereNotNull('trial_end')
                        ->where(function ($query) use ($plan) {
                            $query->where('price_id', $plan->stripe_price_id)
                                ->orWhere('price_id', $plan->stripe_yearly_price_id);
                        })
                        ->whereBetween('createdAt', [$range['start'], $range['end']])
                        ->count();

                    $converted = Subscription::where('status', 'active')
                        ->whereNotNull('trial_end')
                        ->where('trial_end', '<', Carbon::now())
                        ->where(function ($query) use ($plan) {
                            $query->where('price_id', $plan->stripe_price_id)
                                ->orWhere('price_id', $plan->stripe_yearly_price_id);
                        })
                        ->whereBetween('createdAt', [$range['start'], $range['end']])
                        ->count();

                    $conversionRate = $trials > 0 ? round(($converted / $trials) * 100, 1) : 0;

                    $churned = Subscription::where('status', 'canceled')
                        ->where(function ($query) use ($plan) {
                            $query->where('price_id', $plan->stripe_price_id)
                                ->orWhere('price_id', $plan->stripe_yearly_price_id);
                        })
                        ->whereBetween('canceled_at', [$range['start'], $range['end']])
                        ->count();

                    $startingSubs = Subscription::where(function ($query) use ($plan) {
                        $query->where('price_id', $plan->stripe_price_id)
                            ->orWhere('price_id', $plan->stripe_yearly_price_id);
                    })
                    ->where('createdAt', '<', $range['start'])
                    ->count();

                    $churnRate = $startingSubs > 0 ? round(($churned / $startingSubs) * 100, 1) : 0;

                    $ltv = $activeSubscribers > 0 ? round($totalRevenue / $activeSubscribers, 2) : 0;

                    $performance[] = [
                        'id' => $plan->id,
                        'name' => $plan->name,
                        'price' => '$' . number_format($plan->monthly_price_usd ?? $plan->price ?? 0, 2),
                        'subscribers' => $activeSubscribers,
                        'revenue' => (float)$revenue,
                        'revenue_formatted' => '$' . number_format($revenue, 2),
                        'conversion_rate' => $conversionRate,
                        'conversion_rate_formatted' => $conversionRate . '%',
                        'churn_rate' => $churnRate,
                        'churn_rate_formatted' => $churnRate . '%',
                        'ltv' => $ltv,
                        'ltv_formatted' => '$' . number_format($ltv, 2),
                    ];
                }

                usort($performance, function ($a, $b) {
                    return $b['revenue'] <=> $a['revenue'];
                });

                return [
                    'plans' => $performance,
                    'period_label' => $range['label'],
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getPlanPerformance error', ['error' => $e->getMessage()]);
                return [
                    'plans' => [],
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    public function getLTV(): array
    {
        $cacheKey = "analytics_ltv";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            try {
                $totalRevenue = Transaction::whereIn('status', ['succeeded', 'paid'])->sum('amount');
                $totalCustomers = Customer::where('role', 'User')
                    ->whereHas('subscriptions')
                    ->count();

                $avgLTV = $totalCustomers > 0 ? round($totalRevenue / $totalCustomers, 2) : 0;

                $avgSubscriptionLength = Subscription::where('status', 'active')
                    ->selectRaw('AVG(DATEDIFF(NOW(), createdAt)) as avg_days')
                    ->first();

                return [
                    'average_ltv' => $avgLTV,
                    'formatted' => '$' . number_format($avgLTV, 2),
                    'total_customers' => $totalCustomers,
                    'total_revenue' => $totalRevenue,
                    'avg_subscription_days' => round($avgSubscriptionLength->avg_days ?? 0),
                    'label' => 'Customer Lifetime Value',
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getLTV error', ['error' => $e->getMessage()]);
                return [
                    'average_ltv' => 0,
                    'formatted' => '$0.00',
                    'total_customers' => 0,
                    'total_revenue' => 0,
                    'avg_subscription_days' => 0,
                    'label' => 'Customer Lifetime Value',
                ];
            }
        });
    }

    public function getNRR(string $period = 'month'): array
    {
        $range = $this->getDateRange($period);
        $cacheKey = "analytics_nrr_{$period}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($range) {
            try {
                $startingMRR = Transaction::whereIn('status', ['succeeded', 'paid'])
                    ->whereBetween('paid_at', [$range['previous_start'], $range['previous_end']])
                    ->sum('amount');

                $currentMRR = Transaction::whereIn('status', ['succeeded', 'paid'])
                    ->whereBetween('paid_at', [$range['start'], $range['end']])
                    ->sum('amount');

                $nrr = $startingMRR > 0 ? round(($currentMRR / $startingMRR) * 100, 1) : 100;

                $status = 'healthy';
                $color = '#10B981';
                
                if ($nrr < 100) {
                    $status = 'contracting';
                    $color = '#EF4444';
                } elseif ($nrr > 100) {
                    $status = 'expanding';
                    $color = '#10B981';
                }

                return [
                    'nrr' => $nrr,
                    'formatted' => $nrr . '%',
                    'starting_mrr' => $startingMRR,
                    'current_mrr' => $currentMRR,
                    'status' => $status,
                    'color' => $color,
                    'label' => 'Net Revenue Retention',
                    'period_label' => $range['label'],
                ];
            } catch (\Exception $e) {
                Log::warning('Analytics: getNRR error', ['error' => $e->getMessage()]);
                return [
                    'nrr' => 100,
                    'formatted' => '100%',
                    'starting_mrr' => 0,
                    'current_mrr' => 0,
                    'status' => 'healthy',
                    'color' => '#10B981',
                    'label' => 'Net Revenue Retention',
                    'period_label' => $range['label'],
                ];
            }
        });
    }

    public function getDashboardStats(string $period = 'month'): array
    {
        return [
            'revenue' => $this->getTotalRevenue($period),
            'mrr' => $this->getMRR(),
            'arpu' => $this->getARPU($period),
            'popular_plan' => $this->getMostPopularPlan(),
            'active_subscriptions' => $this->getActiveSubscriptions($period),
            'failed_subscriptions' => $this->getFailedSubscriptions($period),
            'churn_rate' => $this->getChurnRate($period),
            'trial_metrics' => $this->getTrialMetrics($period),
            'subscription_health' => $this->getSubscriptionHealth(),
            'ltv' => $this->getLTV(),
            'nrr' => $this->getNRR($period),
        ];
    }

    public function clearCache(): void
    {
        $keys = [
            'analytics_revenue_week',
            'analytics_revenue_month',
            'analytics_revenue_quarter',
            'analytics_revenue_year',
            'analytics_mrr',
            'analytics_arpu_week',
            'analytics_arpu_month',
            'analytics_arpu_quarter',
            'analytics_arpu_year',
            'analytics_popular_plan',
            'analytics_revenue_by_plan_week',
            'analytics_revenue_by_plan_month',
            'analytics_revenue_by_plan_quarter',
            'analytics_revenue_by_plan_year',
            'analytics_active_subs_week',
            'analytics_active_subs_month',
            'analytics_active_subs_quarter',
            'analytics_active_subs_year',
            'analytics_failed_subs_week',
            'analytics_failed_subs_month',
            'analytics_failed_subs_quarter',
            'analytics_failed_subs_year',
            'analytics_churn_week',
            'analytics_churn_month',
            'analytics_churn_quarter',
            'analytics_churn_year',
            'analytics_trial_week',
            'analytics_trial_month',
            'analytics_trial_quarter',
            'analytics_trial_year',
            'analytics_sub_trends_week',
            'analytics_sub_trends_month',
            'analytics_sub_trends_quarter',
            'analytics_sub_trends_year',
            'analytics_revenue_trends_week',
            'analytics_revenue_trends_month',
            'analytics_revenue_trends_quarter',
            'analytics_revenue_trends_year',
            'analytics_sub_health',
            'analytics_plan_performance_week',
            'analytics_plan_performance_month',
            'analytics_plan_performance_quarter',
            'analytics_plan_performance_year',
            'analytics_ltv',
            'analytics_nrr_week',
            'analytics_nrr_month',
            'analytics_nrr_quarter',
            'analytics_nrr_year',
            'analytics_churn_details_week',
            'analytics_churn_details_month',
            'analytics_churn_details_quarter',
            'analytics_churn_details_year',
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\UserPost;
use App\Models\Activity;
use App\Models\SocialUserPage;
use App\Models\Transaction;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private const CACHE_TTL = 300;
    private AnalyticsService $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index(Request $request)
    {
        $period = $request->get('period', 'month');
        $validPeriods = ['week', 'month', 'quarter', 'year'];
        if (!in_array($period, $validPeriods)) {
            $period = 'month';
        }

        try {
            $analyticsStats = $this->analyticsService->getDashboardStats($period);
        } catch (\Exception $e) {
            Log::error('Failed to fetch analytics stats: ' . $e->getMessage());
            $analyticsStats = $this->getDefaultAnalyticsStats();
        }

        try {
            $stats = Cache::remember("dashboard_stats_{$period}", self::CACHE_TTL, function () use ($period) {
                return $this->getDashboardStats($period);
            });
        } catch (\Exception $e) {
            Log::error('Failed to fetch dashboard stats: ' . $e->getMessage());
            $stats = $this->getDefaultStats();
        }

        try {
            $recentCustomers = Cache::remember('dashboard_recent_customers', self::CACHE_TTL, function () {
                return Customer::orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            });
        } catch (\Exception $e) {
            Log::error('Failed to fetch recent customers: ' . $e->getMessage());
            $recentCustomers = collect();
        }

        try {
            $subscriptionsByStatus = Cache::remember('dashboard_subscriptions_status', self::CACHE_TTL, function () {
                return Subscription::select('status', DB::raw('count(*) as count'))
                    ->groupBy('status')
                    ->get();
            });
        } catch (\Exception $e) {
            Log::error('Failed to fetch subscriptions by status: ' . $e->getMessage());
            $subscriptionsByStatus = collect();
        }

        try {
            $recentActivities = Cache::remember('dashboard_recent_activities', self::CACHE_TTL, function () {
                return Activity::with('customer')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
            });
        } catch (\Exception $e) {
            Log::error('Failed to fetch recent activities: ' . $e->getMessage());
            $recentActivities = collect();
        }

        return view('admin.dashboard.index', compact(
            'stats',
            'analyticsStats',
            'recentActivities',
            'recentCustomers',
            'subscriptionsByStatus',
            'period'
        ));
    }

    private function getDashboardStats(string $period = 'month'): array
    {
        $range = $this->analyticsService->getDateRange($period);

        return [
            'total_customers' => Customer::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'total_posts' => UserPost::count(),
            'total_pages' => SocialUserPage::count(),
            'new_customers_today' => Customer::whereDate('created_at', Carbon::today())->count(),
            'new_customers_week' => Customer::where('created_at', '>=', Carbon::now()->subWeek())->count(),
            'pending_subscriptions' => Subscription::where('status', 'trialing')->count(),
            'total_revenue' => Transaction::where('status', 'succeeded')->sum('amount'),
        ];
    }

    private function getDefaultStats(): array
    {
        return [
            'total_customers' => 0,
            'active_subscriptions' => 0,
            'total_posts' => 0,
            'total_pages' => 0,
            'new_customers_today' => 0,
            'new_customers_week' => 0,
            'pending_subscriptions' => 0,
            'total_revenue' => 0,
        ];
    }

    private function getDefaultAnalyticsStats(): array
    {
        return [
            'revenue' => ['current' => 0, 'percentage' => 0, 'trend' => 'up', 'is_positive' => true, 'formatted' => '$0.00'],
            'mrr' => ['current' => 0, 'percentage' => 0, 'trend' => 'up', 'is_positive' => true, 'formatted' => '$0.00'],
            'arpu' => ['current' => 0, 'percentage' => 0, 'trend' => 'up', 'is_positive' => true, 'formatted' => '$0.00'],
            'popular_plan' => ['plan' => null, 'all_plans' => []],
            'active_subscriptions' => ['current' => 0, 'percentage' => 0, 'trend' => 'up', 'is_positive' => true],
            'failed_subscriptions' => ['current' => 0, 'percentage' => 0, 'trend' => 'up', 'is_positive' => true],
            'churn_rate' => ['current' => 0, 'percentage' => 0, 'trend' => 'up', 'is_positive' => true, 'formatted' => '0%'],
            'trial_metrics' => ['conversion_rate' => 0, 'active_trials' => 0],
            'subscription_health' => ['health_score' => ['score' => 100, 'status' => 'excellent', 'color' => '#10B981']],
            'ltv' => ['average_ltv' => 0, 'formatted' => '$0.00'],
            'nrr' => ['nrr' => 100, 'formatted' => '100%', 'status' => 'healthy'],
        ];
    }

    public function getRevenueChart(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            $data = $this->analyticsService->getRevenueTrends($period);

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch revenue chart data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load revenue data',
                'data' => [
                    'labels' => [],
                    'data' => [],
                    'total' => 0,
                ],
            ], 500);
        }
    }

    public function getCustomerGrowthChart(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            $data = Cache::remember("dashboard_customer_growth_{$period}", self::CACHE_TTL, function () use ($period) {
                $months = [];
                $counts = [];
                $numMonths = $period === 'year' ? 12 : ($period === 'quarter' ? 3 : ($period === 'week' ? 7 : 4));
                
                if ($period === 'week') {
                    for ($i = 6; $i >= 0; $i--) {
                        $date = Carbon::now()->subDays($i);
                        $months[] = $date->format('D');
                        
                        $dayCount = Customer::whereDate('created_at', $date)->count();
                        
                        $counts[] = $dayCount;
                    }
                } else {
                    for ($i = $numMonths - 1; $i >= 0; $i--) {
                        $date = Carbon::now()->subMonths($i);
                        $months[] = $date->format('M Y');
                        
                        $monthCount = Customer::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->count();
                        
                        $counts[] = $monthCount;
                    }
                }
                
                return [
                    'labels' => $months,
                    'data' => $counts,
                    'total' => array_sum($counts),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch customer growth data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load customer growth data',
                'data' => [
                    'labels' => [],
                    'data' => [],
                    'total' => 0,
                ],
            ], 500);
        }
    }

    public function getSubscriptionPieData(): JsonResponse
    {
        try {
            $data = Cache::remember('dashboard_subscription_pie', self::CACHE_TTL, function () {
                $subscriptions = Subscription::select('status', DB::raw('count(*) as count'))
                    ->groupBy('status')
                    ->get();
                
                $labels = [];
                $counts = [];
                $colors = [];
                
                $colorMap = [
                    'active' => '#10B981',
                    'trialing' => '#3B82F6',
                    'canceled' => '#EF4444',
                    'past_due' => '#F59E0B',
                    'unpaid' => '#6B7280',
                    'incomplete' => '#8B5CF6',
                    'incomplete_expired' => '#EC4899',
                ];
                
                foreach ($subscriptions as $subscription) {
                    $labels[] = ucfirst($subscription->status);
                    $counts[] = $subscription->count;
                    $colors[] = $colorMap[$subscription->status] ?? '#6B7280';
                }
                
                return [
                    'labels' => $labels,
                    'data' => $counts,
                    'colors' => $colors,
                    'total' => array_sum($counts),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch subscription pie data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load subscription data',
                'data' => [
                    'labels' => [],
                    'data' => [],
                    'colors' => [],
                    'total' => 0,
                ],
            ], 500);
        }
    }

    public function getSubscriptionTrends(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            $data = $this->analyticsService->getSubscriptionTrends($period);

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch subscription trends: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load subscription trends',
                'data' => [
                    'labels' => [],
                    'datasets' => [],
                ],
            ], 500);
        }
    }

    public function getRevenueByPlan(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            $data = $this->analyticsService->getRevenueByPlan($period);

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch revenue by plan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load revenue by plan',
                'data' => [
                    'plans' => [],
                    'total' => 0,
                ],
            ], 500);
        }
    }

    public function getRecentActivity(): JsonResponse
    {
        try {
            $activities = Activity::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($activity) {
                    return [
                        'id' => $activity->id,
                        'user_name' => ($activity->customer->firstname ?? 'Unknown') . ' ' . ($activity->customer->lastname ?? ''),
                        'activity_type' => $activity->activity_type,
                        'action' => $activity->action,
                        'time' => $activity->created_at->diffForHumans(),
                        'timestamp' => $activity->created_at->toIso8601String(),
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $activities,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch recent activities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load activity data',
                'data' => [],
            ], 500);
        }
    }
}

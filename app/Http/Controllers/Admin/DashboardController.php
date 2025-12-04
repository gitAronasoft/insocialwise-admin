<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\UserPost;
use App\Models\Activity;
use App\Models\SocialUserPage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private const CACHE_TTL = 300;

    public function index()
    {
        try {
            $stats = Cache::remember('dashboard_stats', self::CACHE_TTL, function () {
                return $this->getDashboardStats();
            });
        } catch (\Exception $e) {
            Log::error('Failed to fetch dashboard stats: ' . $e->getMessage());
            $stats = $this->getDefaultStats();
        }

        try {
            $recentCustomers = Cache::remember('dashboard_recent_customers', self::CACHE_TTL, function () {
                return Customer::where('role', 'User')
                    ->orderBy('createdAt', 'desc')
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
                    ->orderBy('createdAt', 'desc')
                    ->limit(10)
                    ->get();
            });
        } catch (\Exception $e) {
            Log::error('Failed to fetch recent activities: ' . $e->getMessage());
            $recentActivities = collect();
        }

        return view('admin.dashboard.index', compact(
            'stats',
            'recentActivities',
            'recentCustomers',
            'subscriptionsByStatus'
        ));
    }

    private function getDashboardStats(): array
    {
        return [
            'total_customers' => Customer::where('role', 'User')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'total_posts' => UserPost::count(),
            'total_pages' => SocialUserPage::count(),
            'new_customers_today' => Customer::where('role', 'User')
                ->whereDate('createdAt', Carbon::today())
                ->count(),
            'new_customers_week' => Customer::where('role', 'User')
                ->where('createdAt', '>=', Carbon::now()->subWeek())
                ->count(),
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

    public function getRevenueChart(): JsonResponse
    {
        try {
            $data = Cache::remember('dashboard_revenue_chart', self::CACHE_TTL, function () {
                $months = [];
                $revenues = [];
                
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $months[] = $date->format('M Y');
                    $revenues[] = 0;
                }
                
                return [
                    'labels' => $months,
                    'data' => $revenues,
                    'total' => 0,
                ];
            });

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

    public function getCustomerGrowthChart(): JsonResponse
    {
        try {
            $data = Cache::remember('dashboard_customer_growth', self::CACHE_TTL, function () {
                $months = [];
                $counts = [];
                
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $months[] = $date->format('M Y');
                    
                    $monthCount = Customer::where('role', 'User')
                        ->whereYear('createdAt', $date->year)
                        ->whereMonth('createdAt', $date->month)
                        ->count();
                    
                    $counts[] = $monthCount;
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

    public function getRecentActivity(): JsonResponse
    {
        try {
            $activities = Activity::with('customer')
                ->orderBy('createdAt', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($activity) {
                    return [
                        'id' => $activity->id,
                        'user_name' => ($activity->customer->firstName ?? 'Unknown') . ' ' . ($activity->customer->lastName ?? ''),
                        'activity_type' => $activity->activity_type,
                        'action' => $activity->action,
                        'time' => $activity->createdAt->diffForHumans(),
                        'timestamp' => $activity->createdAt->toIso8601String(),
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Demographics;
use App\Models\SocialMediaScore;
use App\Models\SocialMediaPageScore;
use App\Models\UserPost;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
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
            $dashboardStats = $this->analyticsService->getDashboardStats($period);
            $planPerformance = $this->analyticsService->getPlanPerformance($period);
            $revenueByPlan = $this->analyticsService->getRevenueByPlan($period);
            $subscriptionTrends = $this->analyticsService->getSubscriptionTrends($period);
            $trialMetrics = $this->analyticsService->getTrialMetrics($period);
            $churnAnalytics = $this->analyticsService->getChurnAnalytics($period);
            $subscriptionHealth = $this->analyticsService->getSubscriptionHealth();
            $ltv = $this->analyticsService->getLTV();
            $nrr = $this->analyticsService->getNRR($period);
        } catch (\Exception $e) {
            Log::error('Analytics error: ' . $e->getMessage());
            $dashboardStats = [];
            $planPerformance = ['plans' => []];
            $revenueByPlan = ['plans' => [], 'total' => 0];
            $subscriptionTrends = ['labels' => [], 'datasets' => []];
            $trialMetrics = [];
            $churnAnalytics = ['recently_churned' => [], 'churn_by_plan' => []];
            $subscriptionHealth = [];
            $ltv = [];
            $nrr = [];
        }

        $stats = [
            'total_posts' => UserPost::count(),
            'total_impressions' => UserPost::sum('impressions'),
            'total_reach' => UserPost::sum('unique_impressions'),
            'total_engagement' => UserPost::sum('likes') + UserPost::sum('comments') + UserPost::sum('shares'),
        ];

        $platformBreakdown = UserPost::select('post_platform', DB::raw('count(*) as count'))
            ->groupBy('post_platform')
            ->get();

        $topPosts = UserPost::with(['customer', 'page'])
            ->orderBy(DB::raw('likes + comments + shares'), 'desc')
            ->limit(10)
            ->get();

        return view('admin.analytics.index', compact(
            'stats',
            'platformBreakdown',
            'topPosts',
            'period',
            'dashboardStats',
            'planPerformance',
            'revenueByPlan',
            'subscriptionTrends',
            'trialMetrics',
            'churnAnalytics',
            'subscriptionHealth',
            'ltv',
            'nrr'
        ));
    }

    public function scores(Request $request)
    {
        $query = SocialMediaScore::with('customer');

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        $scores = $query->orderBy('overall_score', 'desc')->paginate(20);

        $averageScores = SocialMediaScore::select(
            DB::raw('AVG(overall_score) as avg_overall'),
            DB::raw('AVG(content_score) as avg_content'),
            DB::raw('AVG(engagement_score) as avg_engagement'),
            DB::raw('AVG(growth_score) as avg_growth'),
            DB::raw('AVG(consistency_score) as avg_consistency')
        )->first();

        return view('admin.analytics.scores', compact('scores', 'averageScores'));
    }

    public function pageScores(Request $request)
    {
        $query = SocialMediaPageScore::with(['customer', 'page']);

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        $pageScores = $query->orderBy('overall_score', 'desc')->paginate(20);

        return view('admin.analytics.page-scores', compact('pageScores'));
    }

    public function demographics()
    {
        $demographics = Demographics::orderBy('createdAt', 'desc')->limit(100)->get();

        return view('admin.analytics.demographics', compact('demographics'));
    }

    public function getPlanPerformance(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            $data = $this->analyticsService->getPlanPerformance($period);
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('Plan performance error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to load data'], 500);
        }
    }

    public function getChurnAnalytics(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            $data = $this->analyticsService->getChurnAnalytics($period);
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('Churn analytics error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to load data'], 500);
        }
    }

    public function getTrialAnalytics(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month');
        
        try {
            $data = $this->analyticsService->getTrialMetrics($period);
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('Trial analytics error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to load data'], 500);
        }
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'posts');

        switch ($type) {
            case 'posts':
                $data = UserPost::with(['customer', 'page'])->get();
                break;
            case 'analytics':
                $data = Analytics::with(['customer', 'page'])->get();
                break;
            case 'scores':
                $data = SocialMediaScore::with('customer')->get();
                break;
            case 'subscriptions':
                $data = Subscription::with('customer')->get();
                break;
            case 'revenue':
                $data = Transaction::with('customer')->where('status', 'succeeded')->get();
                break;
            default:
                $data = collect();
        }

        return response()->json($data);
    }
}

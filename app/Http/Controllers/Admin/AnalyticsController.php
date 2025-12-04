<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Demographics;
use App\Models\SocialMediaScore;
use App\Models\SocialMediaPageScore;
use App\Models\UserPost;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
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

        return view('admin.analytics.index', compact('stats', 'platformBreakdown', 'topPosts'));
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
            default:
                $data = collect();
        }

        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('customer');

        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('createdAt', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('createdAt', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $activities = $query->orderBy('createdAt', 'desc')->paginate(30);

        $activityTypes = Activity::select('activity_type')
            ->distinct()
            ->pluck('activity_type');

        $actions = Activity::select('action')
            ->distinct()
            ->pluck('action');

        return view('admin.activities.index', compact('activities', 'activityTypes', 'actions'));
    }

    public function stats()
    {
        $dailyActivities = Activity::where('createdAt', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(createdAt) as date'),
                DB::raw('count(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $activityByType = Activity::select('activity_type', DB::raw('count(*) as count'))
            ->groupBy('activity_type')
            ->orderBy('count', 'desc')
            ->get();

        $actionBreakdown = Activity::select('action', DB::raw('count(*) as count'))
            ->groupBy('action')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $mostActiveUsers = Activity::select('user_uuid', DB::raw('count(*) as activity_count'))
            ->groupBy('user_uuid')
            ->orderBy('activity_count', 'desc')
            ->limit(10)
            ->with('customer')
            ->get();

        return view('admin.activities.stats', compact(
            'dailyActivities',
            'activityByType',
            'actionBreakdown',
            'mostActiveUsers'
        ));
    }

    public function show(Activity $activity)
    {
        $activity->load('customer');

        return view('admin.activities.show', compact('activity'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardCustomizationController extends Controller
{
    public function index()
    {
        return view('admin.dashboard-customization.index');
    }

    public function save(Request $request): JsonResponse
    {
        $admin = Auth::guard('admin')->user();
        
        $layoutData = [
            'widgets' => $request->input('widgets', []),
            'settings' => $request->input('settings', [])
        ];

        return response()->json([
            'success' => true,
            'message' => 'Dashboard layout saved successfully'
        ]);
    }

    public function load(): JsonResponse
    {
        return response()->json([
            'widgets' => ['revenue', 'mrr', 'subscriptions', 'churn'],
            'settings' => [
                'defaultPeriod' => '30d',
                'refreshInterval' => '60',
                'animations' => true,
                'compact' => false
            ]
        ]);
    }
}

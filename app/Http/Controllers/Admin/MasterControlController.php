<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminFeatureFlag;
use App\Services\FeatureFlagService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MasterControlController extends Controller
{
    public function index()
    {
        $flagsByCategory = FeatureFlagService::getAllByCategory();
        
        $categories = [
            'core' => ['label' => 'Core Features', 'icon' => 'cube', 'description' => 'Main application features'],
            'admin' => ['label' => 'Admin Features', 'icon' => 'cog', 'description' => 'Administrative controls'],
            'security' => ['label' => 'Security Features', 'icon' => 'shield-check', 'description' => 'Security and authentication'],
            'monitoring' => ['label' => 'Monitoring & Alerts', 'icon' => 'chart-bar', 'description' => 'System monitoring'],
            'data' => ['label' => 'Data & Export', 'icon' => 'database', 'description' => 'Data management features'],
        ];

        return view('admin.master-control.index', compact('flagsByCategory', 'categories'));
    }

    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'feature_key' => 'required|string|exists:admin_feature_flags,feature_key',
            'enabled' => 'required|boolean',
        ]);

        $flag = AdminFeatureFlag::where('feature_key', $request->feature_key)->first();

        if ($flag->force_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'This feature cannot be disabled.',
            ], 403);
        }

        $success = FeatureFlagService::toggle(
            $request->feature_key,
            $request->enabled,
            auth()->guard('admin')->id()
        );

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Feature ' . ($request->enabled ? 'enabled' : 'disabled') . ' successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to toggle feature.',
        ], 500);
    }

    public function seed(): JsonResponse
    {
        try {
            FeatureFlagService::seedDefaultFlags();
            return response()->json([
                'success' => true,
                'message' => 'Default feature flags seeded successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to seed feature flags: ' . $e->getMessage(),
            ], 500);
        }
    }
}

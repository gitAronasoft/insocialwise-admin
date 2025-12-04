<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Services\StripeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SubscriptionPlanApiController extends Controller
{
    public function index(): JsonResponse
    {
        $plans = Cache::remember('landing_page_plans', 300, function () {
            return SubscriptionPlan::getLandingPagePlans()
                ->map(fn($plan) => $plan->toApiArray())
                ->values()
                ->toArray();
        });

        return response()->json([
            'success' => true,
            'data' => $plans,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $plan = SubscriptionPlan::where('active', true)
            ->where('id', $id)
            ->first();

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'Plan not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $plan->toApiArray(),
        ]);
    }

    public function stripeConfig(): JsonResponse
    {
        $stripeService = app(StripeService::class);
        
        return response()->json([
            'success' => true,
            'publishable_key' => $stripeService->getPublishableKey(),
            'configured' => $stripeService->isConfigured(),
        ]);
    }
}

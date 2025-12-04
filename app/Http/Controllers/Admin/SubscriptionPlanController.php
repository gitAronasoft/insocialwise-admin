<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SubscriptionPlanController extends Controller
{
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function index()
    {
        $plans = SubscriptionPlan::orderBy('sort_order')->get();
        
        $stats = [
            'total' => $plans->count(),
            'active' => $plans->where('active', true)->count(),
            'featured' => $plans->where('is_featured', true)->count(),
            'synced' => $plans->whereNotNull('stripe_product_id')->count(),
        ];

        $stripeConfigured = $this->stripeService->isConfigured();

        return view('admin.subscription-plans.index', compact('plans', 'stats', 'stripeConfigured'));
    }

    public function create()
    {
        $stripeConfigured = $this->stripeService->isConfigured();
        $platforms = $this->getAvailablePlatforms();
        return view('admin.subscription-plans.create', compact('stripeConfigured', 'platforms'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'currency' => 'required|string|size:3',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'is_featured' => 'boolean',
            'trial_period_days' => 'nullable|integer|min:0',
            'trial_enabled' => 'boolean',
            'skip_trial_discount_enabled' => 'boolean',
            'skip_trial_discount_percent' => 'nullable|integer|min:0|max:100',
            'is_contact_only' => 'boolean',
            'show_on_landing' => 'boolean',
            'max_social_accounts' => 'nullable|integer|min:-1',
            'max_team_members' => 'nullable|integer|min:-1',
            'max_scheduled_posts' => 'nullable|integer|min:-1',
            'platform_limits' => 'nullable|array',
            'yearly_price' => 'nullable|numeric|min:0',
            'yearly_discount_percent' => 'nullable|integer|min:0|max:100',
        ];

        if (!$request->has('is_contact_only')) {
            $rules['price'] = 'required|numeric|min:0';
        } else {
            $rules['price'] = 'nullable|numeric|min:0';
        }

        $validated = $request->validate($rules);

        $validated['features'] = array_filter($request->features ?? []);
        $validated['active'] = $request->has('active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_contact_only'] = $request->has('is_contact_only');
        $validated['show_on_landing'] = $request->has('show_on_landing');
        $validated['trial_enabled'] = $request->has('trial_enabled');
        $validated['skip_trial_discount_enabled'] = $request->has('skip_trial_discount_enabled');
        $validated['sort_order'] = SubscriptionPlan::max('sort_order') + 1;
        $validated['price'] = $validated['price'] ?? 0;
        
        $validated['platform_limits'] = $this->processPlatformLimits($request->platform_limits ?? []);

        if ($request->filled('yearly_discount_percent') && $request->filled('price')) {
            $monthlyPrice = (float)$request->price;
            $discountPercent = (int)$request->yearly_discount_percent;
            $validated['yearly_price'] = round($monthlyPrice * 12 * (1 - $discountPercent / 100), 2);
        }

        $plan = SubscriptionPlan::create($validated);

        Cache::forget('landing_page_plans');

        $stripeMessage = '';
        if ($plan->canSyncToStripe() && $this->stripeService->isConfigured()) {
            $result = $this->stripeService->syncPlanToStripe($plan);
            if ($result['success']) {
                $stripeMessage = ' Plan synced to Stripe automatically.';
            } else {
                $stripeMessage = ' Stripe sync failed: ' . ($result['error'] ?? 'Unknown error');
                Log::warning('Auto Stripe sync failed for plan ' . $plan->id . ': ' . ($result['error'] ?? 'Unknown'));
            }
        }

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan created successfully.' . $stripeMessage);
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        $stripeConfigured = $this->stripeService->isConfigured();
        return view('admin.subscription-plans.show', ['plan' => $subscriptionPlan, 'stripeConfigured' => $stripeConfigured]);
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        $stripeConfigured = $this->stripeService->isConfigured();
        $platforms = $this->getAvailablePlatforms();
        return view('admin.subscription-plans.edit', ['plan' => $subscriptionPlan, 'stripeConfigured' => $stripeConfigured, 'platforms' => $platforms]);
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'currency' => 'required|string|size:3',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'is_featured' => 'boolean',
            'trial_period_days' => 'nullable|integer|min:0',
            'trial_enabled' => 'boolean',
            'skip_trial_discount_enabled' => 'boolean',
            'skip_trial_discount_percent' => 'nullable|integer|min:0|max:100',
            'is_contact_only' => 'boolean',
            'show_on_landing' => 'boolean',
            'max_social_accounts' => 'nullable|integer|min:-1',
            'max_team_members' => 'nullable|integer|min:-1',
            'max_scheduled_posts' => 'nullable|integer|min:-1',
            'platform_limits' => 'nullable|array',
            'yearly_price' => 'nullable|numeric|min:0',
            'yearly_discount_percent' => 'nullable|integer|min:0|max:100',
        ];

        if (!$request->has('is_contact_only')) {
            $rules['price'] = 'required|numeric|min:0';
        } else {
            $rules['price'] = 'nullable|numeric|min:0';
        }

        $validated = $request->validate($rules);

        $validated['features'] = array_filter($request->features ?? []);
        $validated['active'] = $request->has('active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_contact_only'] = $request->has('is_contact_only');
        $validated['show_on_landing'] = $request->has('show_on_landing');
        $validated['trial_enabled'] = $request->has('trial_enabled');
        $validated['skip_trial_discount_enabled'] = $request->has('skip_trial_discount_enabled');
        $validated['price'] = $validated['price'] ?? 0;
        
        $validated['platform_limits'] = $this->processPlatformLimits($request->platform_limits ?? []);

        if ($request->filled('yearly_discount_percent') && $request->filled('price')) {
            $monthlyPrice = (float)$request->price;
            $discountPercent = (int)$request->yearly_discount_percent;
            $validated['yearly_price'] = round($monthlyPrice * 12 * (1 - $discountPercent / 100), 2);
        } elseif ($request->filled('yearly_price')) {
            $validated['yearly_price'] = (float)$request->yearly_price;
        } else {
            $validated['yearly_price'] = null;
        }

        $subscriptionPlan->update($validated);

        Cache::forget('landing_page_plans');

        $stripeMessage = '';
        if ($subscriptionPlan->canSyncToStripe() && $this->stripeService->isConfigured()) {
            $result = $this->stripeService->syncPlanToStripe($subscriptionPlan);
            if ($result['success']) {
                $stripeMessage = ' Plan synced to Stripe automatically.';
            } else {
                $stripeMessage = ' Stripe sync failed: ' . ($result['error'] ?? 'Unknown error');
                Log::warning('Auto Stripe sync failed for plan ' . $subscriptionPlan->id . ': ' . ($result['error'] ?? 'Unknown'));
            }
        }

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan updated successfully.' . $stripeMessage);
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $stripeMessage = '';
        if ($subscriptionPlan->stripe_product_id && $this->stripeService->isConfigured()) {
            $result = $this->stripeService->archivePlanFromStripe($subscriptionPlan);
            if ($result['success']) {
                $stripeMessage = ' Plan archived in Stripe automatically.';
            } else {
                $stripeMessage = ' Stripe archive failed: ' . ($result['error'] ?? 'Unknown error');
            }
        }

        $subscriptionPlan->delete();

        Cache::forget('landing_page_plans');

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan deleted successfully.' . $stripeMessage);
    }

    public function toggleActive(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->update(['active' => !$subscriptionPlan->active]);

        if ($subscriptionPlan->canSyncToStripe() && $this->stripeService->isConfigured()) {
            $this->stripeService->syncPlanToStripe($subscriptionPlan);
        }

        Cache::forget('landing_page_plans');

        return response()->json([
            'success' => true,
            'active' => $subscriptionPlan->active,
            'message' => 'Plan ' . ($subscriptionPlan->active ? 'activated' : 'deactivated') . ' successfully.',
        ]);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'plans' => 'required|array',
            'plans.*' => 'integer|exists:subscription_plans,id',
        ]);

        foreach ($request->plans as $index => $planId) {
            SubscriptionPlan::where('id', $planId)->update(['sort_order' => $index]);
        }

        Cache::forget('landing_page_plans');

        return response()->json([
            'success' => true,
            'message' => 'Plans reordered successfully.',
        ]);
    }

    public function syncToStripe(SubscriptionPlan $subscriptionPlan)
    {
        if (!$this->stripeService->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Stripe is not configured. Add STRIPE_SECRET_KEY to your .env file.',
            ], 400);
        }

        if (!$subscriptionPlan->canSyncToStripe()) {
            return response()->json([
                'success' => false,
                'message' => 'This plan cannot be synced to Stripe (contact-only or zero price).',
            ], 400);
        }

        $result = $this->stripeService->syncPlanToStripe($subscriptionPlan);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Plan synced to Stripe successfully.',
                'product_id' => $result['product_id'],
                'price_id' => $result['price_id'],
                'yearly_price_id' => $result['yearly_price_id'] ?? null,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Stripe sync failed: ' . ($result['error'] ?? 'Unknown error'),
        ], 400);
    }

    public function syncAllToStripe()
    {
        if (!$this->stripeService->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Stripe is not configured. Add STRIPE_SECRET_KEY to your .env file.',
            ], 400);
        }

        $plans = SubscriptionPlan::where('active', true)
            ->where('is_contact_only', false)
            ->where('price', '>', 0)
            ->get();
            
        $synced = 0;
        $failed = 0;
        $errors = [];

        foreach ($plans as $plan) {
            $result = $this->stripeService->syncPlanToStripe($plan);
            if ($result['success']) {
                $synced++;
            } else {
                $failed++;
                $errors[] = $plan->name . ': ' . ($result['error'] ?? 'Unknown error');
            }
        }

        return response()->json([
            'success' => $failed === 0,
            'message' => "Synced {$synced} plans. Failed: {$failed}.",
            'errors' => $errors,
        ]);
    }

    protected function getAvailablePlatforms(): array
    {
        return [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter / X',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube',
            'tiktok' => 'TikTok',
            'pinterest' => 'Pinterest',
            'threads' => 'Threads',
        ];
    }

    protected function processPlatformLimits(array $limits): array
    {
        $processed = [];
        foreach ($limits as $platform => $data) {
            if (isset($data['enabled']) && $data['enabled']) {
                $processed[$platform] = [
                    'enabled' => true,
                    'max_pages' => isset($data['max_pages']) ? (int)$data['max_pages'] : -1,
                ];
            }
        }
        return $processed;
    }
}

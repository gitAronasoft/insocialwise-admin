<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
        $supportLevels = $this->getSupportLevels();
        $calendarOptions = $this->getCalendarOptions();
        $exportOptions = $this->getExportOptions();
        $profileScoreOptions = $this->getProfileScoreOptions();
        
        return view('admin.subscription-plans.create', compact(
            'stripeConfigured', 
            'platforms',
            'supportLevels',
            'calendarOptions',
            'exportOptions',
            'profileScoreOptions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules($request));
        $validated = $this->processFormData($request, $validated);
        $validated['sort_order'] = SubscriptionPlan::max('sort_order') + 1;

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
        $supportLevels = $this->getSupportLevels();
        $calendarOptions = $this->getCalendarOptions();
        $exportOptions = $this->getExportOptions();
        $profileScoreOptions = $this->getProfileScoreOptions();
        
        return view('admin.subscription-plans.edit', [
            'plan' => $subscriptionPlan,
            'stripeConfigured' => $stripeConfigured,
            'platforms' => $platforms,
            'supportLevels' => $supportLevels,
            'calendarOptions' => $calendarOptions,
            'exportOptions' => $exportOptions,
            'profileScoreOptions' => $profileScoreOptions,
        ]);
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validated = $request->validate($this->getValidationRules($request));
        $validated = $this->processFormData($request, $validated);

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
            ->where(function($q) {
                $q->where('price', '>', 0)
                  ->orWhere('monthly_price_usd', '>', 0);
            })
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

    protected function getValidationRules(Request $request): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'currency' => 'required|string|size:3',
            
            'monthly_price_usd' => 'nullable|numeric|min:0',
            'yearly_price_usd' => 'nullable|numeric|min:0',
            'monthly_price_inr' => 'nullable|numeric|min:0',
            'yearly_price_inr' => 'nullable|numeric|min:0',
            'yearly_discount_percent' => 'nullable|integer|min:0|max:100',
            
            'max_social_accounts' => 'nullable|integer|min:-1',
            'max_team_members' => 'nullable|integer|min:-1',
            'max_scheduled_posts' => 'nullable|integer|min:-1',
            'ai_tokens_per_month' => 'nullable|integer|min:-1',
            
            'ai_auto_comment_reply' => 'boolean',
            'ai_auto_dm_reply' => 'boolean',
            'ai_semantic_analysis' => 'boolean',
            'ai_driven_reporting' => 'boolean',
            'ai_content_generator' => 'boolean',
            'social_profile_score' => 'boolean',
            'calendar_scheduling' => 'boolean',
            'unified_inbox' => 'boolean',
            'export_reports' => 'boolean',
            'white_label' => 'boolean',
            'fb_ads_analytics' => 'boolean',
            'fb_ads_creation' => 'boolean',
            'team_roles_permissions' => 'boolean',
            'client_workspaces' => 'boolean',
            'support_level' => 'nullable|string|in:standard,priority,priority_chat,enterprise',
            
            'features' => 'nullable|array',
            'features.*' => 'string',
            'display_features' => 'nullable|array',
            'display_features.*' => 'string',
            
            'platform_limits' => 'nullable|array',
            
            'active' => 'boolean',
            'is_featured' => 'boolean',
            'is_contact_only' => 'boolean',
            'show_on_landing' => 'boolean',
            'trial_enabled' => 'boolean',
            'trial_period_days' => 'nullable|integer|min:0',
            'skip_trial_discount_enabled' => 'boolean',
            'skip_trial_discount_percent' => 'nullable|integer|min:0|max:100',
        ];

        if (!$request->has('is_contact_only')) {
            $rules['price'] = 'nullable|numeric|min:0';
        } else {
            $rules['price'] = 'nullable|numeric|min:0';
        }

        return $rules;
    }

    protected function processFormData(Request $request, array $validated): array
    {
        if (empty($validated['slug']) && !empty($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $validated['features'] = array_values(array_filter($request->features ?? []));
        $validated['display_features'] = array_values(array_filter($request->display_features ?? []));
        
        $validated['active'] = $request->has('active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_contact_only'] = $request->has('is_contact_only');
        $validated['show_on_landing'] = $request->has('show_on_landing');
        $validated['trial_enabled'] = $request->has('trial_enabled');
        $validated['skip_trial_discount_enabled'] = $request->has('skip_trial_discount_enabled');
        
        $validated['ai_auto_comment_reply'] = $request->has('ai_auto_comment_reply');
        $validated['ai_auto_dm_reply'] = $request->has('ai_auto_dm_reply');
        $validated['ai_semantic_analysis'] = $request->has('ai_semantic_analysis');
        $validated['ai_driven_reporting'] = $request->has('ai_driven_reporting');
        $validated['ai_content_generator'] = $request->has('ai_content_generator');
        $validated['unified_inbox'] = $request->has('unified_inbox');
        $validated['white_label'] = $request->has('white_label');
        $validated['fb_ads_analytics'] = $request->has('fb_ads_analytics');
        $validated['fb_ads_creation'] = $request->has('fb_ads_creation');
        $validated['team_roles_permissions'] = $request->has('team_roles_permissions');
        $validated['client_workspaces'] = $request->has('client_workspaces');
        
        $validated['social_profile_score'] = $request->has('social_profile_score');
        $validated['calendar_scheduling'] = $request->has('calendar_scheduling');
        $validated['export_reports'] = $request->has('export_reports');
        $validated['support_level'] = $request->input('support_level', 'standard');
        
        $validated['price'] = $validated['price'] ?? 0;
        $validated['monthly_price_usd'] = $validated['monthly_price_usd'] ?? 0;
        $validated['monthly_price_inr'] = $validated['monthly_price_inr'] ?? 0;
        
        if ($request->filled('yearly_discount_percent')) {
            $discountPercent = (int)$request->yearly_discount_percent;
            
            if ($request->filled('monthly_price_usd')) {
                $validated['yearly_price_usd'] = round($validated['monthly_price_usd'] * 12 * (1 - $discountPercent / 100), 2);
            }
            if ($request->filled('monthly_price_inr')) {
                $validated['yearly_price_inr'] = round($validated['monthly_price_inr'] * 12 * (1 - $discountPercent / 100), 2);
            }
            if ($request->filled('price')) {
                $validated['yearly_price'] = round($validated['price'] * 12 * (1 - $discountPercent / 100), 2);
            }
        }
        
        $validated['platform_limits'] = $this->processPlatformLimits($request->platform_limits ?? []);

        return $validated;
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

    protected function getSupportLevels(): array
    {
        return [
            'standard' => 'Standard Email Support',
            'priority' => 'Priority Support',
            'priority_chat' => 'Priority Chat + Email',
            'enterprise' => '24×7 Enterprise Support',
        ];
    }

    protected function getCalendarOptions(): array
    {
        return [
            'none' => 'Not Available',
            'basic' => 'Basic',
            'advanced' => 'Advanced + Bulk',
        ];
    }

    protected function getExportOptions(): array
    {
        return [
            'none' => 'Not Available',
            'basic' => 'PDF/CSV',
            'white_label' => 'White-Label',
        ];
    }

    protected function getProfileScoreOptions(): array
    {
        return [
            'none' => 'Not Available',
            'basic' => 'Basic',
            'full' => 'Full',
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

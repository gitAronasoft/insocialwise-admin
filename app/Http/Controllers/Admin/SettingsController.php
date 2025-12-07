<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use App\Services\AdminSettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $groups = ['general', 'email', 'api', 'payment', 'feature', 'system', 'stripe', 'webhooks', 'notification'];
    protected $types = ['string', 'integer', 'boolean', 'json', 'email', 'encrypted'];
    protected AdminSettingsService $settingsService;

    public function __construct(AdminSettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index(Request $request)
    {
        $query = AdminSetting::query();

        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $settings = $query->orderBy('group')->orderBy('key')->paginate(20);

        $stats = [
            'total' => AdminSetting::count(),
            'general' => AdminSetting::where('group', 'general')->count(),
            'email' => AdminSetting::where('group', 'email')->count(),
            'api' => AdminSetting::where('group', 'api')->count(),
            'payment' => AdminSetting::where('group', 'payment')->count(),
            'stripe' => AdminSetting::where('group', 'stripe')->count(),
            'notification' => AdminSetting::where('group', 'notification')->count(),
        ];

        $groups = $this->groups;
        return view('admin.settings.index', compact('settings', 'stats', 'groups'));
    }

    public function create()
    {
        $groups = $this->groups;
        $types = $this->types;
        return view('admin.settings.create', compact('groups', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:admin_settings,key',
            'value' => 'nullable|string',
            'type' => 'required|in:' . implode(',', $this->types),
            'group' => 'required|in:' . implode(',', $this->groups),
            'description' => 'nullable|string|max:500',
            'section' => 'nullable|string|max:100',
        ]);

        AdminSetting::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    public function edit(string $group)
    {
        $settings = AdminSetting::where('group', $group)->get()->keyBy('key');
        $groups = $this->groups;
        $types = $this->types;
        
        return view('admin.settings.edit', compact('settings', 'group', 'groups', 'types'));
    }

    public function update(Request $request, string $group)
    {
        $settings = $request->input('settings', []);
        
        foreach ($settings as $key => $data) {
            $existing = AdminSetting::where('key', $key)->first();
            
            if ($existing) {
                if ($existing->type === 'encrypted' && empty($data['value'])) {
                    continue;
                }
                
                $this->settingsService->set(
                    $key,
                    $data['value'] ?? '',
                    $existing->type,
                    $group,
                    $data['description'] ?? $existing->description,
                    $data['section'] ?? $existing->section
                );
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', ucfirst($group) . ' settings updated successfully.');
    }

    public function destroy(AdminSetting $setting)
    {
        $key = $setting->key;
        $setting->delete();
        $this->settingsService->clearCache($key);

        return redirect()->route('admin.settings.index')
            ->with('success', "Setting '{$key}' deleted successfully.");
    }

    public function emailConfig()
    {
        $config = $this->settingsService->getEmailConfig();
        return view('admin.settings.email', compact('config'));
    }

    public function updateEmailConfig(Request $request)
    {
        $validated = $request->validate([
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:tls,ssl,none',
            'from_address' => 'nullable|email|max:255',
            'from_name' => 'nullable|string|max:255',
        ]);

        $this->settingsService->updateEmailConfig($validated);

        return redirect()->route('admin.settings.email')
            ->with('success', 'Email configuration updated successfully.');
    }

    public function testEmailConfig(Request $request)
    {
        $result = $this->settingsService->testSmtpConnection();
        
        if ($result['success']) {
            return back()->with('success', $result['message']);
        }
        
        return back()->with('error', $result['message']);
    }

    public function stripeConfig()
    {
        $config = $this->settingsService->getStripeConfig();
        return view('admin.settings.stripe', compact('config'));
    }

    public function updateStripeConfig(Request $request)
    {
        $validated = $request->validate([
            'stripe_publishable_key' => 'nullable|string|max:255',
            'stripe_secret_key' => 'nullable|string|max:255',
            'stripe_webhook_secret' => 'nullable|string|max:255',
            'stripe_mode' => 'nullable|in:test,live',
        ]);

        $this->settingsService->updateStripeConfig($validated);

        return redirect()->route('admin.settings.stripe')
            ->with('success', 'Stripe configuration updated successfully.');
    }

    public function testStripeConfig()
    {
        $result = $this->settingsService->testStripeConnection();
        
        if ($result['success']) {
            return back()->with('success', $result['message']);
        }
        
        return back()->with('error', $result['message']);
    }

    public function webhooksConfig()
    {
        $config = $this->settingsService->getWebhookUrls();
        return view('admin.settings.webhooks', compact('config'));
    }

    public function updateWebhooksConfig(Request $request)
    {
        $validated = $request->validate([
            'n8n_webhook_url' => 'nullable|url|max:500',
            'zapier_webhook_url' => 'nullable|url|max:500',
            'custom_webhook_url' => 'nullable|url|max:500',
            'webhook_secret' => 'nullable|string|max:255',
        ]);

        $this->settingsService->updateWebhookUrls($validated);

        return redirect()->route('admin.settings.webhooks')
            ->with('success', 'Webhook URLs updated successfully.');
    }

    public function notificationConfig()
    {
        $config = $this->settingsService->getNotificationConfig();
        return view('admin.settings.notifications', compact('config'));
    }

    public function updateNotificationConfig(Request $request)
    {
        $validated = $request->validate([
            'trial_reminder_enabled' => 'nullable|boolean',
            'trial_reminder_hours' => 'nullable|integer|min:1|max:168',
            'renewal_reminder_enabled' => 'nullable|boolean',
            'renewal_reminder_days' => 'nullable|integer|min:1|max:30',
            'payment_success_email' => 'nullable|boolean',
            'payment_failed_email' => 'nullable|boolean',
            'subscription_created_email' => 'nullable|boolean',
            'subscription_canceled_email' => 'nullable|boolean',
        ]);

        $booleanFields = [
            'trial_reminder_enabled',
            'renewal_reminder_enabled',
            'payment_success_email',
            'payment_failed_email',
            'subscription_created_email',
            'subscription_canceled_email',
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->has($field);
        }

        $this->settingsService->updateNotificationConfig($validated);

        return redirect()->route('admin.settings.notifications')
            ->with('success', 'Notification settings updated successfully.');
    }
}

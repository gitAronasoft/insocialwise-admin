<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webhook;
use App\Models\WebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function index()
    {
        $webhooks = Webhook::orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total' => $webhooks->count(),
            'active' => $webhooks->where('active', true)->count(),
            'success_rate' => $this->calculateOverallSuccessRate($webhooks),
        ];

        return view('admin.webhooks.index', compact('webhooks', 'stats'));
    }

    public function create()
    {
        $eventTypes = $this->getEventTypes();
        return view('admin.webhooks.create', compact('eventTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|in:stripe,facebook,linkedin,n8n,custom',
            'event_type' => 'required|string|max:255',
            'endpoint_url' => 'required|url',
            'secret' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active');
        
        if (empty($validated['secret'])) {
            $validated['secret'] = Str::random(32);
        }

        Webhook::create($validated);

        return redirect()->route('admin.webhooks.index')
            ->with('success', 'Webhook created successfully.');
    }

    public function show(Webhook $webhook)
    {
        $logs = $webhook->logs()->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.webhooks.show', compact('webhook', 'logs'));
    }

    public function edit(Webhook $webhook)
    {
        $eventTypes = $this->getEventTypes();
        return view('admin.webhooks.edit', compact('webhook', 'eventTypes'));
    }

    public function update(Request $request, Webhook $webhook)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|in:stripe,facebook,linkedin,n8n,custom',
            'event_type' => 'required|string|max:255',
            'endpoint_url' => 'required|url',
            'secret' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $validated['active'] = $request->has('active');
        
        if (!empty($validated['secret'])) {
            $webhook->secret = $validated['secret'];
        }
        unset($validated['secret']);
        
        $webhook->update($validated);

        return redirect()->route('admin.webhooks.index')
            ->with('success', 'Webhook updated successfully.');
    }

    public function destroy(Webhook $webhook)
    {
        $webhook->delete();

        return redirect()->route('admin.webhooks.index')
            ->with('success', 'Webhook deleted successfully.');
    }

    public function test(Webhook $webhook)
    {
        try {
            $testPayload = [
                'event' => 'test',
                'timestamp' => now()->toIso8601String(),
                'webhook_id' => $webhook->id,
                'message' => 'This is a test webhook from InSocialWise Admin Panel',
            ];

            $response = Http::timeout(10)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Webhook-Secret' => $webhook->decrypted_secret ?? '',
                    'X-Webhook-Event' => 'test',
                ])
                ->post($webhook->endpoint_url, $testPayload);

            $log = WebhookLog::create([
                'webhook_id' => $webhook->id,
                'event_type' => 'test',
                'payload' => $testPayload,
                'response_code' => $response->status(),
                'response_body' => substr($response->body(), 0, 1000),
                'status' => $response->successful() ? 'success' : 'failed',
                'executed_at' => now(),
            ]);

            $webhook->update([
                'last_triggered_at' => now(),
                'last_status' => $response->successful() ? 'success' : 'failed',
                'last_response' => substr($response->body(), 0, 500),
                $response->successful() ? 'success_count' : 'failure_count' => 
                    $webhook->{$response->successful() ? 'success_count' : 'failure_count'} + 1,
            ]);

            return response()->json([
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'message' => $response->successful() 
                    ? 'Webhook test successful!' 
                    : 'Webhook test failed with status ' . $response->status(),
                'response' => substr($response->body(), 0, 500),
            ]);
        } catch (\Exception $e) {
            Log::error('Webhook test failed: ' . $e->getMessage());

            WebhookLog::create([
                'webhook_id' => $webhook->id,
                'event_type' => 'test',
                'payload' => ['event' => 'test'],
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'executed_at' => now(),
            ]);

            $webhook->update([
                'last_triggered_at' => now(),
                'last_status' => 'failed',
                'failure_count' => $webhook->failure_count + 1,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Webhook test failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleActive(Webhook $webhook)
    {
        $webhook->update(['active' => !$webhook->active]);

        return response()->json([
            'success' => true,
            'active' => $webhook->active,
            'message' => 'Webhook ' . ($webhook->active ? 'activated' : 'deactivated') . ' successfully.',
        ]);
    }

    public function regenerateSecret(Webhook $webhook)
    {
        $webhook->secret = Str::random(32);
        $webhook->save();

        return response()->json([
            'success' => true,
            'message' => 'Secret regenerated successfully.',
            'masked_secret' => $webhook->masked_secret,
        ]);
    }

    private function getEventTypes(): array
    {
        return [
            'stripe' => [
                'payment.succeeded' => 'Payment Succeeded',
                'payment.failed' => 'Payment Failed',
                'subscription.created' => 'Subscription Created',
                'subscription.updated' => 'Subscription Updated',
                'subscription.cancelled' => 'Subscription Cancelled',
                'invoice.paid' => 'Invoice Paid',
                'invoice.payment_failed' => 'Invoice Payment Failed',
            ],
            'facebook' => [
                'page.post' => 'Page Post',
                'page.comment' => 'Page Comment',
                'page.message' => 'Page Message',
                'lead.created' => 'Lead Created',
            ],
            'linkedin' => [
                'share.created' => 'Share Created',
                'comment.created' => 'Comment Created',
            ],
            'n8n' => [
                'workflow.completed' => 'Workflow Completed',
                'workflow.error' => 'Workflow Error',
            ],
            'custom' => [
                'custom.event' => 'Custom Event',
            ],
        ];
    }

    private function calculateOverallSuccessRate($webhooks): float
    {
        $totalSuccess = $webhooks->sum('success_count');
        $totalFailure = $webhooks->sum('failure_count');
        $total = $totalSuccess + $totalFailure;

        if ($total === 0) return 0;

        return round(($totalSuccess / $total) * 100, 1);
    }
}

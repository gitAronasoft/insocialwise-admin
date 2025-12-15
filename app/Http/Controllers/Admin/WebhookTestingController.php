<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class WebhookTestingController extends Controller
{
    public function index()
    {
        return view('admin.webhook-testing.index');
    }

    public function send(Request $request): JsonResponse
    {
        $startTime = microtime(true);

        $eventType = $request->input('event_type');
        $customerId = $request->input('customer_id', 'cus_test_' . Str::random(8));
        $subscriptionId = $request->input('subscription_id', 'sub_test_' . Str::random(8));
        $customData = $request->input('custom_data');

        $payload = [
            'id' => 'evt_test_' . Str::random(24),
            'type' => $eventType,
            'created' => now()->timestamp,
            'data' => [
                'object' => [
                    'id' => $subscriptionId,
                    'customer' => $customerId,
                ]
            ]
        ];

        if ($customData) {
            try {
                $parsed = json_decode($customData, true);
                if ($parsed) {
                    $payload['data']['object'] = array_merge($payload['data']['object'], $parsed);
                }
            } catch (\Exception $e) {
            }
        }

        $event = WebhookEvent::create([
            'stripe_event_id' => $payload['id'],
            'event_type' => $eventType,
            'status' => 'received',
            'customer_id' => $customerId,
            'subscription_id' => $subscriptionId,
            'payload' => json_encode($payload),
            'source' => 'test',
        ]);

        $event->update(['status' => 'processed']);

        $processingTime = round((microtime(true) - $startTime) * 1000);

        return response()->json([
            'success' => true,
            'event_id' => $event->stripe_event_id,
            'status' => 'processed',
            'processing_time' => $processingTime,
            'response' => [
                'message' => 'Test webhook processed successfully',
                'event_type' => $eventType,
                'payload' => $payload
            ]
        ]);
    }

    public function failedEvents(): JsonResponse
    {
        $events = WebhookEvent::where('status', 'failed')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'stripe_event_id' => $event->stripe_event_id,
                    'event_type' => $event->event_type,
                    'error_message' => $event->error_message,
                    'created_at' => $event->created_at->format('M d, Y H:i'),
                    'replaying' => false
                ];
            });

        return response()->json(['events' => $events]);
    }
}

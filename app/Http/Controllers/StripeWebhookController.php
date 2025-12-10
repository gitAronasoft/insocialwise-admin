<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StripeWebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    protected StripeWebhookService $webhookService;

    public function __construct(StripeWebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        $startTime = microtime(true);
        $signature = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        if (!$webhookSecret) {
            Log::error('STRIPE_WEBHOOK_SECRET is not configured');
            return response()->json(['error' => 'Webhook secret not configured'], 500);
        }

        if (!$signature) {
            Log::error('Missing Stripe-Signature header');
            return response()->json(['error' => 'Missing signature'], 400);
        }

        $payload = $request->getContent();

        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            $event = \Stripe\Webhook::constructEvent($payload, $signature, $webhookSecret);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook signature verification failed'], 400);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook error: ' . $e->getMessage()], 400);
        }

        $result = $this->webhookService->processEvent($event, $request->ip(), $startTime);

        $processingTimeMs = (int) ((microtime(true) - $startTime) * 1000);

        if ($result['success']) {
            return response()->json([
                'received' => true,
                'status' => $result['status'],
                'event_id' => $event->id,
                'event_type' => $event->type,
                'processing_time_ms' => $processingTimeMs,
            ]);
        }

        return response()->json([
            'received' => true,
            'status' => 'error',
            'error' => $result['error'] ?? 'Unknown error',
            'event_id' => $event->id,
        ], 200);
    }
}

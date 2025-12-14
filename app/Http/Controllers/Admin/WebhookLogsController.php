<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebhookEvent;
use App\Models\WebhookLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WebhookLogsController extends Controller
{
    public function index(Request $request)
    {
        $query = WebhookEvent::query()
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('stripe_event_id', 'like', "%{$search}%")
                    ->orWhere('event_type', 'like', "%{$search}%")
                    ->orWhere('customer_id', 'like', "%{$search}%")
                    ->orWhere('subscription_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('event_type')) {
            $query->where('event_type', 'like', "%{$request->event_type}%");
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $perPage = $request->get('per_page', 25);
        $webhookEvents = $query->paginate($perPage);

        $stats = [
            'total' => WebhookEvent::count(),
            'processed' => WebhookEvent::where('status', 'processed')->count(),
            'failed' => WebhookEvent::where('status', 'failed')->count(),
            'pending' => WebhookEvent::whereIn('status', ['received', 'processing'])->count(),
        ];

        $eventTypes = WebhookEvent::select('event_type')
            ->distinct()
            ->orderBy('event_type')
            ->pluck('event_type');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data' => $webhookEvents->items(),
                'current_page' => $webhookEvents->currentPage(),
                'last_page' => $webhookEvents->lastPage(),
                'per_page' => $webhookEvents->perPage(),
                'total' => $webhookEvents->total(),
                'stats' => $stats,
            ]);
        }

        return view('admin.webhook-logs.index', compact('webhookEvents', 'stats', 'eventTypes'));
    }

    public function show(WebhookEvent $webhookEvent)
    {
        $webhookEvent->load('logs');
        
        // Load related customer and subscription if IDs exist
        $customer = null;
        $subscription = null;
        
        if ($webhookEvent->customer_id) {
            $customer = \App\Models\Customer::where('stripe_customer_id', $webhookEvent->customer_id)->first();
        }
        
        if ($webhookEvent->subscription_id) {
            $subscription = \App\Models\Subscription::where('stripe_subscription_id', $webhookEvent->subscription_id)->first();
        }
        
        return view('admin.webhook-logs.show', compact('webhookEvent', 'customer', 'subscription'));
    }

    public function showJson(WebhookEvent $webhookEvent): JsonResponse
    {
        return response()->json($webhookEvent->toJsonLog());
    }

    public function logs(WebhookEvent $webhookEvent): JsonResponse
    {
        $logs = $webhookEvent->logs()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($log) => $log->toJsonLog());

        return response()->json([
            'event' => $webhookEvent->toJsonLog(),
            'logs' => $logs,
        ]);
    }

    public function recentEvents(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 50);
        
        $events = WebhookEvent::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(fn($event) => $event->toJsonLog());

        return response()->json([
            'count' => count($events),
            'events' => $events,
        ]);
    }

    public function stats(): JsonResponse
    {
        $stats = [
            'total_events' => WebhookEvent::count(),
            'processed' => WebhookEvent::where('status', 'processed')->count(),
            'failed' => WebhookEvent::where('status', 'failed')->count(),
            'pending' => WebhookEvent::whereIn('status', ['received', 'processing'])->count(),
            'avg_processing_time_ms' => (int) WebhookEvent::whereNotNull('processing_time_ms')->avg('processing_time_ms'),
            'events_last_24h' => WebhookEvent::where('created_at', '>=', now()->subDay())->count(),
            'events_last_7d' => WebhookEvent::where('created_at', '>=', now()->subDays(7))->count(),
            'by_type' => WebhookEvent::selectRaw('event_type, count(*) as count')
                ->groupBy('event_type')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
                ->pluck('count', 'event_type'),
            'by_status' => WebhookEvent::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status'),
        ];

        return response()->json($stats);
    }

    public function retry(WebhookEvent $webhookEvent): JsonResponse
    {
        if ($webhookEvent->status !== 'failed') {
            return response()->json(['error' => 'Only failed events can be retried'], 400);
        }

        $webhookEvent->update([
            'status' => 'received',
            'retry_count' => ($webhookEvent->retry_count ?? 0) + 1,
            'error_message' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event queued for retry',
        ]);
    }
}

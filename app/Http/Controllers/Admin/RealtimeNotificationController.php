<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebhookEvent;
use App\Models\BillingNotification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RealtimeNotificationController extends Controller
{
    public function index()
    {
        return view('admin.realtime-notifications.index');
    }

    public function feed(): JsonResponse
    {
        $notifications = collect();

        $webhookEvents = WebhookEvent::where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        foreach ($webhookEvents as $event) {
            $type = match($event->status) {
                'failed' => 'critical',
                'processing', 'received' => 'warning',
                'processed' => 'success',
                default => 'info'
            };

            $notifications->push([
                'id' => 'webhook_' . $event->id,
                'type' => $type,
                'title' => 'Webhook: ' . $event->event_type,
                'message' => $event->status === 'failed' 
                    ? ($event->error_message ?? 'Processing failed')
                    : 'Event ' . $event->status,
                'time' => $event->created_at->diffForHumans(),
                'timestamp' => $event->created_at->timestamp,
                'source' => 'Stripe Webhooks',
                'read' => $event->status === 'processed'
            ]);
        }

        $billingNotifs = BillingNotification::where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        foreach ($billingNotifs as $notif) {
            $type = match($notif->status) {
                'failed' => 'critical',
                'sent' => 'success',
                default => 'info'
            };

            $notifications->push([
                'id' => 'billing_' . $notif->id,
                'type' => $type,
                'title' => 'Billing: ' . ucfirst(str_replace('_', ' ', $notif->notification_type)),
                'message' => 'Notification ' . $notif->status,
                'time' => $notif->created_at->diffForHumans(),
                'timestamp' => $notif->created_at->timestamp,
                'source' => 'Billing System',
                'read' => $notif->status === 'sent'
            ]);
        }

        $sorted = $notifications->sortByDesc('timestamp')->values();

        $stats = [
            'critical' => $sorted->where('type', 'critical')->count(),
            'warnings' => $sorted->where('type', 'warning')->count(),
            'info' => $sorted->where('type', 'info')->count(),
            'success' => $sorted->where('type', 'success')->count(),
        ];

        return response()->json([
            'notifications' => $sorted->take(50)->values(),
            'stats' => $stats
        ]);
    }

    public function markAllRead(): JsonResponse
    {
        return response()->json(['success' => true]);
    }
}

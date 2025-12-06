<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingNotification;
use App\Services\AdminSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    protected AdminSettingsService $settingsService;

    public function __construct(AdminSettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index(Request $request)
    {
        $query = BillingNotification::with(['customer', 'subscription']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('notification_type', $request->type);
        }

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('recipient_email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('scheduled_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('scheduled_at', '<=', $request->date_to);
        }

        $notifications = $query->orderBy('scheduled_at', 'desc')->paginate(20);

        $stats = $this->getStats();
        $types = $this->getNotificationTypes();
        $channels = ['email', 'in_app', 'sms', 'push'];
        $priorities = ['low', 'normal', 'high', 'urgent'];
        $statuses = ['pending', 'queued', 'sent', 'delivered', 'failed', 'canceled', 'skipped'];

        return view('admin.notifications.index', compact(
            'notifications', 'stats', 'types', 'channels', 'priorities', 'statuses'
        ));
    }

    public function show(BillingNotification $notification)
    {
        $notification->load(['customer', 'subscription', 'transaction']);
        return view('admin.notifications.show', compact('notification'));
    }

    public function retry(BillingNotification $notification)
    {
        if (!in_array($notification->status, ['failed', 'canceled'])) {
            return back()->with('error', 'Only failed or canceled notifications can be retried.');
        }

        $notification->update([
            'status' => 'pending',
            'retry_count' => 0,
            'last_error' => null,
            'scheduled_at' => now(),
        ]);

        return back()->with('success', 'Notification queued for retry.');
    }

    public function cancel(BillingNotification $notification)
    {
        if ($notification->status !== 'pending') {
            return back()->with('error', 'Only pending notifications can be canceled.');
        }

        $notification->update([
            'status' => 'canceled',
        ]);

        return back()->with('success', 'Notification canceled successfully.');
    }

    public function bulkRetry(Request $request)
    {
        $ids = $request->input('ids', []);
        
        $count = BillingNotification::whereIn('id', $ids)
            ->whereIn('status', ['failed', 'canceled'])
            ->update([
                'status' => 'pending',
                'retry_count' => 0,
                'last_error' => null,
                'scheduled_at' => now(),
            ]);

        return back()->with('success', "{$count} notifications queued for retry.");
    }

    public function bulkCancel(Request $request)
    {
        $ids = $request->input('ids', []);
        
        $count = BillingNotification::whereIn('id', $ids)
            ->where('status', 'pending')
            ->update(['status' => 'canceled']);

        return back()->with('success', "{$count} notifications canceled.");
    }

    public function stats()
    {
        return response()->json($this->getStats());
    }

    public function schedulerStatus()
    {
        $config = $this->settingsService->getNotificationConfig();
        
        $pendingCount = BillingNotification::where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->count();
        
        $nextDue = BillingNotification::where('status', 'pending')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->first();

        return response()->json([
            'config' => $config,
            'pending_count' => $pendingCount,
            'next_due_at' => $nextDue?->scheduled_at,
            'queue_health' => $pendingCount < 100 ? 'healthy' : ($pendingCount < 500 ? 'warning' : 'critical'),
        ]);
    }

    public function runNow(Request $request)
    {
        $limit = $request->input('limit', 10);
        
        $notifications = BillingNotification::where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->where('retry_count', '<', 3)
            ->orderBy('priority', 'desc')
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();

        $processed = 0;
        $failed = 0;

        foreach ($notifications as $notification) {
            try {
                $notification->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
                $processed++;
            } catch (\Exception $e) {
                $notification->increment('retry_count');
                $notification->update([
                    'status' => $notification->retry_count >= 3 ? 'failed' : 'pending',
                    'last_error' => $e->getMessage(),
                ]);
                $failed++;
            }
        }

        return back()->with('success', "Processed {$processed} notifications. Failed: {$failed}.");
    }

    protected function getStats(): array
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total' => BillingNotification::count(),
            'pending' => BillingNotification::where('status', 'pending')->count(),
            'sent' => BillingNotification::where('status', 'sent')->count(),
            'delivered' => BillingNotification::where('status', 'delivered')->count(),
            'failed' => BillingNotification::where('status', 'failed')->count(),
            'sent_today' => BillingNotification::where('status', 'sent')
                ->whereDate('sent_at', $today)->count(),
            'sent_this_week' => BillingNotification::where('status', 'sent')
                ->where('sent_at', '>=', $thisWeek)->count(),
            'sent_this_month' => BillingNotification::where('status', 'sent')
                ->where('sent_at', '>=', $thisMonth)->count(),
            'due_now' => BillingNotification::where('status', 'pending')
                ->where('scheduled_at', '<=', now())->count(),
            'by_type' => BillingNotification::selectRaw('notification_type, count(*) as count')
                ->groupBy('notification_type')
                ->pluck('count', 'notification_type')
                ->toArray(),
            'by_channel' => BillingNotification::selectRaw('channel, count(*) as count')
                ->groupBy('channel')
                ->pluck('count', 'channel')
                ->toArray(),
        ];
    }

    protected function getNotificationTypes(): array
    {
        return [
            'trial_ending_24h' => 'Trial Ending (24h)',
            'trial_ending_1h' => 'Trial Ending (1h)',
            'trial_ended' => 'Trial Ended',
            'subscription_created' => 'Subscription Created',
            'subscription_renewed' => 'Subscription Renewed',
            'subscription_canceled' => 'Subscription Canceled',
            'subscription_paused' => 'Subscription Paused',
            'subscription_resumed' => 'Subscription Resumed',
            'renewal_reminder_7d' => 'Renewal Reminder (7d)',
            'renewal_reminder_3d' => 'Renewal Reminder (3d)',
            'renewal_reminder_1d' => 'Renewal Reminder (1d)',
            'payment_succeeded' => 'Payment Succeeded',
            'payment_failed' => 'Payment Failed',
            'payment_failed_final' => 'Payment Failed (Final)',
            'payment_method_expiring' => 'Payment Method Expiring',
            'payment_method_expired' => 'Payment Method Expired',
            'invoice_created' => 'Invoice Created',
            'invoice_paid' => 'Invoice Paid',
            'invoice_past_due' => 'Invoice Past Due',
            'refund_processed' => 'Refund Processed',
            'plan_upgraded' => 'Plan Upgraded',
            'plan_downgraded' => 'Plan Downgraded',
            'dunning_reminder' => 'Dunning Reminder',
        ];
    }
}

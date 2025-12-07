<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingActivityLog;
use App\Models\PaymentMethod;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BillingController extends Controller
{
    public function activityLogs(Request $request)
    {
        $query = BillingActivityLog::with(['customer', 'subscription', 'transaction']);

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->action_type);
        }

        if ($request->filled('action_status')) {
            $query->where('action_status', $request->action_status);
        }

        if ($request->filled('actor_type')) {
            $query->where('actor_type', $request->actor_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('actor_email', 'like', "%{$search}%")
                    ->orWhere('stripe_event_id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(25);

        $stats = $this->getActivityStats();
        $actionTypes = $this->getActionTypes();
        $actorTypes = ['user', 'admin', 'system', 'stripe', 'cron'];
        $statuses = ['success', 'failed', 'pending', 'skipped'];

        return view('admin.billing.activity-logs', compact(
            'logs', 'stats', 'actionTypes', 'actorTypes', 'statuses'
        ));
    }

    public function showLog(BillingActivityLog $log)
    {
        $log->load(['customer', 'subscription', 'transaction']);
        return view('admin.billing.log-detail', compact('log'));
    }

    public function paymentMethods(Request $request)
    {
        $query = PaymentMethod::with('customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('card_brand')) {
            $query->where('card_brand', $request->card_brand);
        }

        if ($request->filled('is_default')) {
            $query->where('is_default', $request->is_default === 'true');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('card_last4', 'like', "%{$search}%")
                    ->orWhere('billing_email', 'like', "%{$search}%")
                    ->orWhere('billing_name', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        $paymentMethods = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => PaymentMethod::count(),
            'active' => PaymentMethod::where('status', 'active')->count(),
            'expiring_soon' => PaymentMethod::where('status', 'active')
                ->whereRaw("STR_TO_DATE(CONCAT(card_exp_year, '-', card_exp_month, '-01'), '%Y-%m-%d') <= ?", 
                    [now()->addMonths(2)->format('Y-m-d')])
                ->count(),
            'expired' => PaymentMethod::where('status', 'expired')->count(),
        ];

        $cardBrands = PaymentMethod::distinct()->pluck('card_brand')->filter()->toArray();

        return view('admin.billing.payment-methods', compact('paymentMethods', 'stats', 'cardBrands'));
    }

    public function overview()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        $stats = [
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'trialing' => Subscription::where('status', 'trialing')->count(),
            'past_due' => Subscription::where('status', 'past_due')->count(),
            'canceled_this_month' => Subscription::where('status', 'canceled')
                ->where('canceled_at', '>=', $thisMonth)->count(),
            'mrr' => $this->calculateMRR(),
            'arr' => $this->calculateMRR() * 12,
            'revenue_this_month' => Transaction::where('status', 'succeeded')
                ->where('created_at', '>=', $thisMonth)->sum('amount') / 100,
            'revenue_last_month' => Transaction::where('status', 'succeeded')
                ->whereBetween('created_at', [$lastMonth, $thisMonth])->sum('amount') / 100,
            'transactions_today' => Transaction::whereDate('created_at', $today)->count(),
            'failed_payments' => Transaction::where('status', 'failed')
                ->where('created_at', '>=', $thisMonth)->count(),
        ];

        $recentLogs = BillingActivityLog::with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $upcomingRenewals = Subscription::where('status', 'active')
            ->where('current_period_end', '<=', now()->addDays(7))
            ->with('customer', 'plan')
            ->orderBy('current_period_end')
            ->limit(10)
            ->get();

        return view('admin.billing.overview', compact('stats', 'recentLogs', 'upcomingRenewals'));
    }

    protected function getActivityStats(): array
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();

        return [
            'total' => BillingActivityLog::count(),
            'today' => BillingActivityLog::whereDate('created_at', $today)->count(),
            'this_week' => BillingActivityLog::where('created_at', '>=', $thisWeek)->count(),
            'success' => BillingActivityLog::where('action_status', 'success')->count(),
            'failed' => BillingActivityLog::where('action_status', 'failed')->count(),
            'by_type' => BillingActivityLog::selectRaw('action_type, count(*) as count')
                ->groupBy('action_type')
                ->orderByDesc('count')
                ->limit(5)
                ->pluck('count', 'action_type')
                ->toArray(),
        ];
    }

    protected function getActionTypes(): array
    {
        return [
            'subscription_created' => 'Subscription Created',
            'subscription_updated' => 'Subscription Updated',
            'subscription_canceled' => 'Subscription Canceled',
            'subscription_reactivated' => 'Subscription Reactivated',
            'subscription_paused' => 'Subscription Paused',
            'subscription_resumed' => 'Subscription Resumed',
            'plan_upgraded' => 'Plan Upgraded',
            'plan_downgraded' => 'Plan Downgraded',
            'trial_started' => 'Trial Started',
            'trial_extended' => 'Trial Extended',
            'trial_ended' => 'Trial Ended',
            'payment_attempted' => 'Payment Attempted',
            'payment_succeeded' => 'Payment Succeeded',
            'payment_failed' => 'Payment Failed',
            'payment_refunded' => 'Payment Refunded',
            'invoice_created' => 'Invoice Created',
            'invoice_sent' => 'Invoice Sent',
            'invoice_paid' => 'Invoice Paid',
            'invoice_voided' => 'Invoice Voided',
            'card_added' => 'Card Added',
            'card_updated' => 'Card Updated',
            'card_removed' => 'Card Removed',
            'card_set_default' => 'Card Set as Default',
            'webhook_received' => 'Webhook Received',
            'webhook_processed' => 'Webhook Processed',
            'notification_sent' => 'Notification Sent',
            'admin_action' => 'Admin Action',
            'system_action' => 'System Action',
        ];
    }

    protected function calculateMRR(): float
    {
        return Subscription::where('status', 'active')
            ->whereNotNull('amount')
            ->where('billing_interval', 'month')
            ->sum('amount') / 100;
    }

    public function dunning(Request $request)
    {
        $query = Subscription::with(['customer', 'plan', 'defaultPaymentMethod'])
            ->where(function ($q) {
                $q->where(function ($inner) {
                    $inner->whereNotNull('dunning_status')
                          ->where('dunning_status', '!=', 'none');
                })->orWhere('status', 'past_due');
            });

        if ($request->filled('dunning_status')) {
            $query->where('dunning_status', $request->dunning_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($inner) use ($search) {
                    $inner->where('firstName', 'like', "%{$search}%")
                        ->orWhere('lastName', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        $sortColumn = $request->get('sort', 'payment_retry_count');
        $sortDirection = $request->get('direction', 'desc');
        
        $allowedSorts = ['payment_retry_count', 'next_payment_retry_at', 'past_due_since', 'createdAt'];
        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('payment_retry_count', 'desc');
        }

        $subscriptions = $query->paginate(20);

        $stats = [
            'total_dunning' => Subscription::where('dunning_status', '!=', 'none')
                ->whereNotNull('dunning_status')->count(),
            'past_due' => Subscription::where('status', 'past_due')->count(),
            'retry_pending' => Subscription::whereNotNull('next_payment_retry_at')
                ->where('next_payment_retry_at', '>', now())->count(),
            'high_risk' => Subscription::where('payment_retry_count', '>=', 3)->count(),
            'total_at_risk_revenue' => Subscription::where(function ($q) {
                $q->where('dunning_status', '!=', 'none')
                  ->orWhere('status', 'past_due');
            })->sum('amount') / 100,
        ];

        $dunningStatuses = ['active', 'escalated', 'final_notice', 'exhausted', 'resolved'];

        return view('admin.billing.dunning', compact('subscriptions', 'stats', 'dunningStatuses'));
    }

    public function notifications(Request $request)
    {
        $query = \Illuminate\Support\Facades\DB::table('billing_notifications')
            ->leftJoin('subscriptions', 'billing_notifications.subscription_id', '=', 'subscriptions.id')
            ->leftJoin('users', 'billing_notifications.user_uuid', '=', 'users.uuid')
            ->select(
                'billing_notifications.*',
                'users.firstName as customer_first_name',
                'users.lastName as customer_last_name',
                'users.email as customer_email',
                'subscriptions.stripe_subscription_id'
            );

        if ($request->filled('type')) {
            $query->where('billing_notifications.type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('billing_notifications.status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('billing_notifications.recipient_email', 'like', "%{$search}%")
                  ->orWhere('users.firstName', 'like', "%{$search}%")
                  ->orWhere('users.lastName', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('billing_notifications.sent_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('billing_notifications.sent_at', '<=', $request->date_to);
        }

        $notifications = $query->orderBy('billing_notifications.sent_at', 'desc')
            ->paginate(25);

        $stats = [
            'total' => \Illuminate\Support\Facades\DB::table('billing_notifications')->count(),
            'sent' => \Illuminate\Support\Facades\DB::table('billing_notifications')->where('status', 'sent')->count(),
            'delivered' => \Illuminate\Support\Facades\DB::table('billing_notifications')->where('status', 'delivered')->count(),
            'failed' => \Illuminate\Support\Facades\DB::table('billing_notifications')->where('status', 'failed')->count(),
            'today' => \Illuminate\Support\Facades\DB::table('billing_notifications')
                ->whereDate('sent_at', Carbon::today())->count(),
        ];

        $notificationTypes = [
            'payment_reminder' => 'Payment Reminder',
            'payment_failed' => 'Payment Failed',
            'payment_succeeded' => 'Payment Succeeded',
            'subscription_created' => 'Subscription Created',
            'subscription_canceled' => 'Subscription Canceled',
            'subscription_renewed' => 'Subscription Renewed',
            'trial_ending' => 'Trial Ending',
            'trial_ended' => 'Trial Ended',
            'invoice_created' => 'Invoice Created',
            'invoice_paid' => 'Invoice Paid',
            'card_expiring' => 'Card Expiring',
            'dunning_notice' => 'Dunning Notice',
        ];

        $statuses = ['pending', 'sent', 'delivered', 'failed', 'bounced'];

        return view('admin.billing.notifications', compact('notifications', 'stats', 'notificationTypes', 'statuses'));
    }
}

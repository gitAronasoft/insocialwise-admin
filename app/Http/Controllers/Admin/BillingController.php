<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingActivityLog;
use App\Models\PaymentMethod;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
                $q->where('description', 'ilike', "%{$search}%")
                    ->orWhere('actor_email', 'ilike', "%{$search}%")
                    ->orWhere('stripe_event_id', 'ilike', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('email', 'ilike', "%{$search}%")
                            ->orWhereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"]);
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
            $query->where('brand', $request->card_brand);
        }

        if ($request->filled('is_default')) {
            $isDefault = $request->is_default === 'true' ? 'true' : 'false';
            $query->whereRaw("is_default = {$isDefault}");
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('last4', 'ilike', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('email', 'ilike', "%{$search}%")
                            ->orWhereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"]);
                    });
            });
        }

        $paymentMethods = $query->orderBy('created_at', 'desc')->paginate(20);

        $twoMonthsFromNow = now()->addMonths(2)->format('Y-m-d');
        $stats = PaymentMethod::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN status = 'active' AND (exp_year || '-' || LPAD(exp_month::text, 2, '0') || '-01')::date <= ?::date THEN 1 ELSE 0 END) as expiring_soon,
            SUM(CASE WHEN status = 'expired' THEN 1 ELSE 0 END) as expired
        ", [$twoMonthsFromNow])->first();

        $cardBrands = PaymentMethod::select('brand')->distinct()->whereNotNull('brand')->pluck('brand')->toArray();

        return view('admin.billing.payment-methods', compact('paymentMethods', 'stats', 'cardBrands'));
    }

    public function overview()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        $subscriptionStats = Subscription::selectRaw("
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_subscriptions,
            SUM(CASE WHEN status = 'trialing' THEN 1 ELSE 0 END) as trialing,
            SUM(CASE WHEN status = 'past_due' THEN 1 ELSE 0 END) as past_due,
            SUM(CASE WHEN status = 'canceled' AND canceled_at >= ? THEN 1 ELSE 0 END) as canceled_this_month
        ", [$thisMonth])->first();

        $transactionStats = Transaction::selectRaw("
            SUM(CASE WHEN status = 'succeeded' AND paid_at >= ? THEN amount ELSE 0 END) as revenue_this_month,
            SUM(CASE WHEN status = 'succeeded' AND paid_at >= ? AND paid_at < ? THEN amount ELSE 0 END) as revenue_last_month,
            SUM(CASE WHEN DATE(paid_at) = ? THEN 1 ELSE 0 END) as transactions_today,
            SUM(CASE WHEN status = 'failed' AND paid_at >= ? THEN 1 ELSE 0 END) as failed_payments
        ", [$thisMonth, $lastMonth, $thisMonth, $today, $thisMonth])->first();

        $mrr = $this->calculateMRR();

        $stats = [
            'active_subscriptions' => (int) $subscriptionStats->active_subscriptions,
            'trialing' => (int) $subscriptionStats->trialing,
            'past_due' => (int) $subscriptionStats->past_due,
            'canceled_this_month' => (int) $subscriptionStats->canceled_this_month,
            'mrr' => $mrr,
            'arr' => $mrr * 12,
            'revenue_this_month' => ($transactionStats->revenue_this_month ?? 0) / 100,
            'revenue_last_month' => ($transactionStats->revenue_last_month ?? 0) / 100,
            'transactions_today' => (int) $transactionStats->transactions_today,
            'failed_payments' => (int) $transactionStats->failed_payments,
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

        $stats = BillingActivityLog::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as today,
            SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as this_week,
            SUM(CASE WHEN action_status = 'success' THEN 1 ELSE 0 END) as success,
            SUM(CASE WHEN action_status = 'failed' THEN 1 ELSE 0 END) as failed
        ", [$today, $thisWeek])->first();

        $byType = BillingActivityLog::selectRaw('action_type, COUNT(*) as count')
            ->groupBy('action_type')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'action_type')
            ->toArray();

        return [
            'total' => (int) $stats->total,
            'today' => (int) $stats->today,
            'this_week' => (int) $stats->this_week,
            'success' => (int) $stats->success,
            'failed' => (int) $stats->failed,
            'by_type' => $byType,
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
                    $inner->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"])
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            });
        }

        $sortColumn = $request->get('sort', 'payment_retry_count');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSorts = ['payment_retry_count', 'next_payment_retry_at', 'past_due_since', 'created_at'];
        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('payment_retry_count', 'desc');
        }

        $subscriptions = $query->paginate(20);

        $stats = Subscription::selectRaw("
            SUM(CASE WHEN dunning_status IS NOT NULL AND dunning_status != 'none' THEN 1 ELSE 0 END) as total_dunning,
            SUM(CASE WHEN status = 'past_due' THEN 1 ELSE 0 END) as past_due,
            SUM(CASE WHEN next_payment_retry_at IS NOT NULL AND next_payment_retry_at > NOW() THEN 1 ELSE 0 END) as retry_pending,
            SUM(CASE WHEN payment_retry_count >= 3 THEN 1 ELSE 0 END) as high_risk,
            SUM(CASE WHEN (dunning_status IS NOT NULL AND dunning_status != 'none') OR status = 'past_due' THEN amount ELSE 0 END) as total_at_risk_revenue
        ")->first();

        $statsArray = [
            'total_dunning' => (int) $stats->total_dunning,
            'past_due' => (int) $stats->past_due,
            'retry_pending' => (int) $stats->retry_pending,
            'high_risk' => (int) $stats->high_risk,
            'total_at_risk_revenue' => ($stats->total_at_risk_revenue ?? 0) / 100,
        ];

        $dunningStatuses = ['active', 'escalated', 'final_notice', 'exhausted', 'resolved'];

        return view('admin.billing.dunning', compact('subscriptions', 'statsArray', 'dunningStatuses'))->with('stats', $statsArray);
    }

    public function payments(Request $request)
    {
        $perPage = 20;
        $statusFilter = $request->get('status', '');
        $search = $request->get('search', '');

        $query = Transaction::query()
            ->with(['customer'])
            ->leftJoin('users', 'transactions.user_uuid', '=', 'users.uuid')
            ->leftJoin('payment_methods', function($join) {
                $join->on('transactions.user_uuid', '=', 'payment_methods.user_uuid')
                     ->on('transactions.stripe_customer_id', '=', 'payment_methods.stripe_customer_id');
            })
            ->leftJoin('subscriptions', 'transactions.subscription_id', '=', 'subscriptions.id')
            ->leftJoin('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
            ->select(
                'transactions.*',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) as customer_name"),
                'users.email as customer_email',
                'users.uuid as customer_uuid',
                'payment_methods.brand as pm_brand',
                'payment_methods.last4 as pm_last4',
                'payment_methods.exp_month as pm_exp_month',
                'payment_methods.exp_year as pm_exp_year',
                'payment_methods.is_default as pm_is_default',
                'payment_methods.status as pm_status',
                'payment_methods.funding as pm_funding',
                'payment_methods.country as pm_country',
                'subscriptions.stripe_subscription_id',
                'subscriptions.plan_id',
                'subscription_plans.name as plan_name',
                'subscription_plans.billing_interval'
            );

        if ($statusFilter) {
            $query->where('transactions.status', $statusFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transactions.stripe_invoice_id', 'ilike', "%{$search}%")
                  ->orWhere('transactions.invoice_number', 'ilike', "%{$search}%")
                  ->orWhereRaw("CONCAT(users.firstname, ' ', users.lastname) ILIKE ?", ["%{$search}%"])
                  ->orWhere('users.email', 'ilike', "%{$search}%")
                  ->orWhere('payment_methods.last4', 'ilike', "%{$search}%");
            });
        }

        $payments = $query->orderBy('transactions.paid_at', 'desc')
            ->orderBy('transactions.id', 'desc')
            ->paginate($perPage);

        $missingPaymentUserIds = $payments->getCollection()
            ->filter(fn($p) => !$p->pm_brand && $p->user_uuid)
            ->pluck('user_uuid')
            ->unique()
            ->values();

        if ($missingPaymentUserIds->isNotEmpty()) {
            $paymentMethodsMap = PaymentMethod::whereIn('user_uuid', $missingPaymentUserIds)
                ->where('status', 'active')
                ->get()
                ->keyBy('user_uuid');

            $payments->getCollection()->transform(function ($payment) use ($paymentMethodsMap) {
                if (!$payment->pm_brand && $payment->user_uuid) {
                    $paymentMethod = $paymentMethodsMap->get($payment->user_uuid);
                    if ($paymentMethod) {
                        $payment->pm_brand = $paymentMethod->brand;
                        $payment->pm_last4 = $paymentMethod->last4;
                        $payment->pm_exp_month = $paymentMethod->exp_month;
                        $payment->pm_exp_year = $paymentMethod->exp_year;
                        $payment->pm_is_default = $paymentMethod->is_default;
                        $payment->pm_status = $paymentMethod->status;
                    }
                }
                return $payment;
            });
        }

        $stats = DB::selectOne("
            SELECT
                (SELECT COUNT(*) FROM payment_methods) as total_payment_methods,
                (SELECT COUNT(*) FROM payment_methods WHERE status = 'active') as active_cards,
                (SELECT COUNT(*) FROM transactions) as total_transactions,
                (SELECT COUNT(*) FROM transactions WHERE status IN ('succeeded', 'paid')) as successful_transactions,
                (SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE status IN ('succeeded', 'paid')) as total_revenue
        ");

        $statsArray = [
            'total_payment_methods' => (int) $stats->total_payment_methods,
            'active_cards' => (int) $stats->active_cards,
            'total_transactions' => (int) $stats->total_transactions,
            'successful_transactions' => (int) $stats->successful_transactions,
            'total_revenue' => ($stats->total_revenue ?? 0) / 100,
        ];

        return view('admin.billing.payments', compact('payments', 'statusFilter', 'search'))->with('stats', $statsArray);
    }

    public function transactionDetail($id)
    {
        $transaction = Transaction::query()
            ->leftJoin('users', 'transactions.user_uuid', '=', 'users.uuid')
            ->leftJoin('payment_methods', function ($join) {
                $join->on('transactions.user_uuid', '=', 'payment_methods.user_uuid')
                     ->on('transactions.stripe_customer_id', '=', 'payment_methods.stripe_customer_id');
            })
            ->leftJoin('subscriptions', 'transactions.subscription_id', '=', 'subscriptions.id')
            ->leftJoin('subscription_plans', 'subscriptions.plan_id', '=', 'subscription_plans.id')
            ->where('transactions.id', $id)
            ->select(
                'transactions.*',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) as customer_name"),
                'users.email as customer_email',
                'users.uuid as customer_uuid',
                'users.country as customer_country',
                'users.phone as customer_phone',
                'payment_methods.brand as pm_brand',
                'payment_methods.last4 as pm_last4',
                'payment_methods.exp_month as pm_exp_month',
                'payment_methods.exp_year as pm_exp_year',
                'payment_methods.funding as pm_funding',
                'payment_methods.country as pm_country',
                'subscriptions.stripe_subscription_id',
                'subscriptions.billing_interval',
                'subscription_plans.name as plan_name',
                'subscription_plans.price as plan_price'
            )
            ->firstOrFail();

        if (!$transaction->pm_brand && $transaction->user_uuid) {
            $paymentMethod = PaymentMethod::where('user_uuid', $transaction->user_uuid)
                ->where('status', 'active')
                ->first();
            if ($paymentMethod) {
                $transaction->pm_brand = $paymentMethod->brand;
                $transaction->pm_last4 = $paymentMethod->last4;
                $transaction->pm_exp_month = $paymentMethod->exp_month;
                $transaction->pm_exp_year = $paymentMethod->exp_year;
                $transaction->pm_funding = $paymentMethod->funding;
                $transaction->pm_country = $paymentMethod->country;
            }
        }

        $relatedTransactions = Transaction::where('user_uuid', $transaction->user_uuid)
            ->where('id', '!=', $id)
            ->orderBy('paid_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.billing.transaction-detail', compact('transaction', 'relatedTransactions'));
    }

    public function notifications(Request $request)
    {
        $query = DB::table('billing_notifications')
            ->leftJoin('subscriptions', 'billing_notifications.subscription_id', '=', 'subscriptions.id')
            ->leftJoin('users', 'billing_notifications.user_uuid', '=', 'users.uuid')
            ->select(
                'billing_notifications.*',
                DB::raw("CONCAT(users.firstname, ' ', users.lastname) as customer_name"),
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
                $q->where('billing_notifications.recipient_email', 'ilike', "%{$search}%")
                  ->orWhereRaw("CONCAT(users.firstname, ' ', users.lastname) ILIKE ?", ["%{$search}%"])
                  ->orWhere('users.email', 'ilike', "%{$search}%");
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

        $stats = DB::selectOne("
            SELECT
                COUNT(*) as total,
                SUM(CASE WHEN status = 'sent' THEN 1 ELSE 0 END) as sent,
                SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed,
                SUM(CASE WHEN DATE(sent_at) = CURRENT_DATE THEN 1 ELSE 0 END) as today
            FROM billing_notifications
        ");

        $statsArray = [
            'total' => (int) ($stats->total ?? 0),
            'sent' => (int) ($stats->sent ?? 0),
            'delivered' => (int) ($stats->delivered ?? 0),
            'failed' => (int) ($stats->failed ?? 0),
            'today' => (int) ($stats->today ?? 0),
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

        return view('admin.billing.notifications', compact('notifications', 'notificationTypes', 'statuses'))->with('stats', $statsArray);
    }
}

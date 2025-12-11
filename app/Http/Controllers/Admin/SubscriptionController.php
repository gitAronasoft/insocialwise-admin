<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with('customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"])
                    ->orWhere('email', 'ilike', "%{$search}%");
            })->orWhere('stripe_subscription_id', 'ilike', "%{$search}%");
        }

        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        $allowedSorts = ['status', 'created_at', 'current_period_start', 'current_period_end'];
        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 15);
        $perPage = in_array((int)$perPage, [10, 15, 25, 50, 100]) ? (int)$perPage : 15;

        $subscriptions = $query->paginate($perPage);

        if ($request->ajax() || $request->wantsJson()) {
            $data = collect($subscriptions->items())->map(function ($sub) {
                return [
                    'id' => $sub->id,
                    'stripe_subscription_id' => $sub->stripe_subscription_id,
                    'status' => $sub->status,
                    'current_period_start' => $sub->current_period_start?->toIso8601String(),
                    'current_period_end' => $sub->current_period_end?->toIso8601String(),
                    'created_at' => $sub->created_at?->toIso8601String(),
                    'customer' => $sub->customer ? [
                        'id' => $sub->customer->uuid,
                        'name' => $sub->customer->name,
                        'email' => $sub->customer->email,
                    ] : null,
                ];
            });

            return response()->json([
                'data' => $data,
                'current_page' => $subscriptions->currentPage(),
                'last_page' => $subscriptions->lastPage(),
                'per_page' => $subscriptions->perPage(),
                'total' => $subscriptions->total(),
            ]);
        }

        $stats = [
            'total' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'trialing' => Subscription::where('status', 'trialing')->count(),
            'canceled' => Subscription::where('status', 'canceled')->count(),
        ];

        return view('admin.subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['customer', 'plan', 'defaultPaymentMethod', 'paymentMethods']);

        $transactions = Transaction::where('subscription_id', $subscription->id)
            ->orWhere('user_uuid', $subscription->user_uuid)
            ->orderBy('id', 'desc')
            ->get();

        // Get payment method with intelligent fallback strategy
        $paymentMethod = null;
        
        // First: check if subscription has a specific default payment method ID
        if ($subscription->defaultPaymentMethod) {
            $paymentMethod = $subscription->defaultPaymentMethod;
        }
        
        // Second: find from user's payment methods (from relationship)
        if (!$paymentMethod && $subscription->paymentMethods) {
            // Prefer default payment method
            $paymentMethod = $subscription->paymentMethods
                ->where('is_default', true)
                ->first();
            
            // If no default, prefer active status
            if (!$paymentMethod) {
                $paymentMethod = $subscription->paymentMethods
                    ->where('status', 'active')
                    ->sortByDesc('created_at')
                    ->first();
            }
            
            // If still nothing, just take the most recent
            if (!$paymentMethod) {
                $paymentMethod = $subscription->paymentMethods
                    ->sortByDesc('created_at')
                    ->first();
            }
        }
        
        // Third: database fallback queries if relationship didn't find anything
        if (!$paymentMethod && $subscription->user_uuid) {
            $paymentMethod = PaymentMethod::where('user_uuid', $subscription->user_uuid)
                ->whereRaw('is_default IS TRUE')
                ->orderBy('created_at', 'desc')
                ->first();
        }
        
        if (!$paymentMethod && $subscription->user_uuid) {
            $paymentMethod = PaymentMethod::where('user_uuid', $subscription->user_uuid)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->first();
        }
        
        if (!$paymentMethod && $subscription->user_uuid) {
            $paymentMethod = PaymentMethod::where('user_uuid', $subscription->user_uuid)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        $subscriptionEvents = DB::table('subscription_events')
            ->where('subscription_id', $subscription->id)
            ->orWhere('user_uuid', $subscription->user_uuid)
            ->orderBy('occurred_at', 'desc')
            ->limit(20)
            ->get();

        return view('admin.subscriptions.show', compact('subscription', 'transactions', 'paymentMethod', 'subscriptionEvents'));
    }

    public function transactions(Request $request)
    {
        $query = Transaction::with('customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"])
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $transactions = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.subscriptions.transactions', compact('transactions'));
    }

    public function revenue()
    {
        $totalRevenueRaw = Transaction::where('status', 'succeeded')->sum('amount');
        $totalRevenue = $totalRevenueRaw / 100;
        $transactionCount = Transaction::where('status', 'succeeded')->count();
        
        $mrrRaw = Subscription::where('status', 'active')
            ->whereNotNull('amount')
            ->where('billing_interval', 'month')
            ->sum('amount');
        $mrr = $mrrRaw / 100;
        
        $recentTransactions = Transaction::with('customer')
            ->where('status', 'succeeded')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $dailyRevenue = Transaction::where('status', 'succeeded')
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(paid_at) as date'),
                DB::raw('SUM(amount) / 100 as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $weeklyRevenue = Transaction::where('status', 'succeeded')
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', Carbon::now()->subWeeks(12))
            ->select(
                DB::raw('EXTRACT(YEAR FROM paid_at)::int as year'),
                DB::raw('EXTRACT(WEEK FROM paid_at)::int as week'),
                DB::raw('SUM(amount) / 100 as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM paid_at)'), DB::raw('EXTRACT(WEEK FROM paid_at)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM paid_at)'), 'asc')
            ->orderBy(DB::raw('EXTRACT(WEEK FROM paid_at)'), 'asc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::now()->setISODate($item->year, $item->week)->startOfWeek();
                return [
                    'label' => $date->format('M d'),
                    'total' => (float) $item->total,
                    'count' => $item->count,
                ];
            });

        $monthlyRevenue = Transaction::where('status', 'succeeded')
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', Carbon::now()->subMonths(12))
            ->select(
                DB::raw('EXTRACT(YEAR FROM paid_at)::int as year'),
                DB::raw('EXTRACT(MONTH FROM paid_at)::int as month'),
                DB::raw('SUM(amount) / 100 as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM paid_at)'), DB::raw('EXTRACT(MONTH FROM paid_at)'))
            ->orderBy(DB::raw('EXTRACT(YEAR FROM paid_at)'), 'asc')
            ->orderBy(DB::raw('EXTRACT(MONTH FROM paid_at)'), 'asc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::createFromDate($item->year, $item->month, 1);
                return [
                    'label' => $date->format('M Y'),
                    'total' => (float) $item->total,
                    'count' => $item->count,
                ];
            });

        $avgTransactionValue = $transactionCount > 0 ? $totalRevenue / $transactionCount : 0;

        return view('admin.subscriptions.revenue', compact(
            'totalRevenue',
            'transactionCount',
            'mrr',
            'recentTransactions',
            'dailyRevenue',
            'weeklyRevenue',
            'monthlyRevenue',
            'avgTransactionValue'
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $ids = $request->input('ids');
        
        $subscriptions = Subscription::with('customer')
            ->whereIn('id', $ids)
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscriptions-export-' . now()->format('Y-m-d-His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($subscriptions) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'ID',
                'Subscription ID',
                'Customer Name',
                'Customer Email',
                'Status',
                'Period Start',
                'Period End',
                'Created At',
            ]);

            foreach ($subscriptions as $subscription) {
                fputcsv($file, [
                    $subscription->id,
                    $subscription->stripe_subscription_id,
                    $subscription->customer->name ?? 'Unknown',
                    $subscription->customer->email ?? '',
                    $subscription->status,
                    $subscription->current_period_start?->format('Y-m-d H:i:s'),
                    $subscription->current_period_end?->format('Y-m-d H:i:s'),
                    $subscription->created_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Transaction;
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
                $q->where('firstName', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('stripe_subscription_id', 'like', "%{$search}%");
        }

        $sortColumn = $request->get('sort', 'createdAt');
        $sortDirection = $request->get('direction', 'desc');
        
        $allowedSorts = ['status', 'createdAt', 'current_period_start', 'current_period_end'];
        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('createdAt', 'desc');
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
                    'current_period_start' => $sub->current_period_start?->format('Y-m-d H:i:s'),
                    'current_period_end' => $sub->current_period_end?->format('Y-m-d H:i:s'),
                    'createdAt' => $sub->createdAt?->format('Y-m-d H:i:s'),
                    'customer' => $sub->customer ? [
                        'id' => $sub->customer->id,
                        'firstName' => $sub->customer->firstName,
                        'lastName' => $sub->customer->lastName,
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
        $subscription->load('customer');

        $transactions = Transaction::where('subscription_id', $subscription->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.subscriptions.show', compact('subscription', 'transactions'));
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
                $q->where('firstName', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $transactions = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.subscriptions.transactions', compact('transactions'));
    }

    public function revenue()
    {
        $totalRevenue = Transaction::where('status', 'succeeded')->sum('amount');
        $transactionCount = Transaction::where('status', 'succeeded')->count();
        $mrr = Subscription::where('status', 'active')->count() * 29;
        
        $recentTransactions = Transaction::where('status', 'succeeded')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $monthlyRevenue = [];

        return view('admin.subscriptions.revenue', compact(
            'totalRevenue',
            'transactionCount',
            'mrr',
            'recentTransactions',
            'monthlyRevenue'
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
                    ($subscription->customer->firstName ?? '') . ' ' . ($subscription->customer->lastName ?? ''),
                    $subscription->customer->email ?? '',
                    $subscription->status,
                    $subscription->current_period_start?->format('Y-m-d H:i:s'),
                    $subscription->current_period_end?->format('Y-m-d H:i:s'),
                    $subscription->createdAt?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

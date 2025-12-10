<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SocialUser;
use App\Models\SocialUserPage;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::select('users.*')
            ->selectSub(function ($q) {
                $q->selectRaw('COUNT(*)')
                    ->from('social_users')
                    ->whereColumn('social_users.user_id', '=', 'users.uuid');
            }, 'social_users_count')
            ->selectSub(function ($q) {
                $q->selectRaw('COUNT(*)')
                    ->from('social_page')
                    ->whereColumn('social_page.user_uuid', '=', 'users.uuid');
            }, 'social_pages_count')
            ->selectSub(function ($q) {
                $q->selectRaw('COUNT(*)')
                    ->from('posts')
                    ->whereColumn('posts.user_uuid', '=', 'users.uuid');
            }, 'posts_count');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"])
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        $allowedSorts = ['firstname', 'lastname', 'email', 'status', 'created_at'];
        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 15);
        $perPage = in_array((int)$perPage, [10, 15, 25, 50, 100]) ? (int)$perPage : 15;
        
        $customers = $query->paginate($perPage);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data' => $customers->items(),
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
                'per_page' => $customers->perPage(),
                'total' => $customers->total(),
            ]);
        }

        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'socialUsers.pages',
            'socialPages',
            'posts' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            },
            'subscriptions',
            'activities' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(20);
            }
        ]);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'status' => 'required',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function toggleStatus(Customer $customer)
    {
        $customer->update(['status' => !$customer->status]);

        return redirect()->back()
            ->with('success', 'Customer status updated successfully.');
    }

    public function socialAccounts(Customer $customer)
    {
        $socialUsers = $customer->socialUsers()->with('pages')->get();

        return view('admin.customers.social-accounts', compact('customer', 'socialUsers'));
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $ids = $request->input('ids');
        
        $count = Customer::whereIn('uuid', $ids)
            ->count();
        
        if ($count === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No customers found to delete.',
            ], 404);
        }

        Customer::whereIn('uuid', $ids)
            ->update(['status' => 'inactive']);

        return response()->json([
            'success' => true,
            'message' => "{$count} customer(s) have been deactivated successfully.",
        ]);
    }

    public function bulkStatusChange(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'string',
            'action' => 'required|in:activate,deactivate',
        ]);

        $ids = $request->input('ids');
        $action = $request->input('action');
        $status = $action === 'activate' ? 'active' : 'inactive';
        
        $count = Customer::whereIn('uuid', $ids)
            ->update(['status' => $status]);

        $actionText = $action === 'activate' ? 'activated' : 'deactivated';

        return response()->json([
            'success' => true,
            'message' => "{$count} customer(s) have been {$actionText} successfully.",
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $ids = $request->input('ids');
        
        $customers = Customer::where('role', 'User')
            ->whereIn('id', $ids)
            ->select('users.*')
            ->selectSub(function ($q) {
                $q->selectRaw('COUNT(*)')
                    ->from('social_users')
                    ->whereColumn('social_users.user_id', '=', 'users.uuid');
            }, 'social_users_count')
            ->selectSub(function ($q) {
                $q->selectRaw('COUNT(*)')
                    ->from('social_page')
                    ->whereColumn('social_page.user_uuid', '=', 'users.uuid');
            }, 'social_pages_count')
            ->selectSub(function ($q) {
                $q->selectRaw('COUNT(*)')
                    ->from('posts')
                    ->whereColumn('posts.user_uuid', '=', 'users.uuid');
            }, 'posts_count')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers-export-' . now()->format('Y-m-d-His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'ID',
                'UUID',
                'First Name',
                'Last Name',
                'Email',
                'Status',
                'Social Accounts',
                'Social Pages',
                'Posts',
                'Created At',
            ]);

            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->id,
                    $customer->uuid,
                    $customer->firstname,
                    $customer->lastname,
                    $customer->email,
                    $customer->status == '1' ? 'Active' : 'Inactive',
                    $customer->social_users_count ?? 0,
                    $customer->social_pages_count ?? 0,
                    $customer->posts_count ?? 0,
                    $customer->created_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

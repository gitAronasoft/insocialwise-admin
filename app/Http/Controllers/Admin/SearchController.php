<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\UserPost;
use App\Models\Transaction;
use App\Models\Campaign;
use App\Models\KnowledgeBase;
use App\Models\Subscription;
use App\Models\SocialUser;
use App\Models\SocialUserPage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];

        if (strlen($query) >= 2) {
            $results = $this->search($query);
        }

        if ($request->ajax()) {
            return response()->json($results);
        }

        return view('admin.search.index', compact('query', 'results'));
    }

    public function search(string $query): array
    {
        $results = [
            'customers' => [],
            'posts' => [],
            'transactions' => [],
            'campaigns' => [],
            'knowledge_base' => [],
            'subscriptions' => [],
            'social_accounts' => [],
            'pages' => [],
        ];

        $results['customers'] = Customer::where('role', 'User')
            ->where(function ($q) use ($query) {
                $q->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$query}%"])
                    ->orWhere('email', 'ilike', "%{$query}%")
                    ->orWhere('uuid', 'ilike', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'uuid' => $customer->uuid,
                    'name' => ($customer->firstname ?? '') . ' ' . ($customer->lastname ?? ''),
                    'email' => $customer->email,
                    'type' => 'customer',
                    'url' => route('admin.customers.show', $customer->uuid),
                ];
            })
            ->toArray();

        $results['posts'] = UserPost::where('content', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => substr($post->content ?? 'No content', 0, 50) . '...',
                    'type' => 'post',
                    'url' => route('admin.posts.show', $post->id),
                ];
            })
            ->toArray();

        $results['transactions'] = Transaction::where('stripe_transaction_id', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'title' => 'Transaction #' . $transaction->id . ' - $' . number_format($transaction->amount ?? 0, 2),
                    'type' => 'transaction',
                    'url' => route('admin.subscriptions.transactions'),
                ];
            })
            ->toArray();

        $results['campaigns'] = Campaign::where('campaign_name', 'like', "%{$query}%")
            ->orWhere('campaign_id', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($campaign) {
                return [
                    'id' => $campaign->id,
                    'title' => $campaign->campaign_name ?? 'Unnamed Campaign',
                    'type' => 'campaign',
                    'url' => route('admin.campaigns.show', $campaign->id),
                ];
            })
            ->toArray();

        $results['knowledge_base'] = KnowledgeBase::where('knowledgeBase_title', 'like', "%{$query}%")
            ->orWhere('knowledgeBase_content', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->knowledgeBase_title ?? 'Untitled',
                    'type' => 'knowledge_base',
                    'url' => route('admin.knowledge-base.show', $article->id),
                ];
            })
            ->toArray();

        $results['subscriptions'] = Subscription::where('stripe_subscription_id', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($subscription) {
                return [
                    'id' => $subscription->id,
                    'title' => 'Subscription #' . $subscription->id . ' - ' . ucfirst($subscription->status ?? 'unknown'),
                    'type' => 'subscription',
                    'url' => route('admin.subscriptions.show', $subscription->id),
                ];
            })
            ->toArray();

        $results['social_accounts'] = SocialUser::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($account) {
                return [
                    'id' => $account->id,
                    'title' => ($account->name ?? $account->email ?? 'Unknown') . ' (' . ucfirst($account->platform ?? 'unknown') . ')',
                    'type' => 'social_account',
                    'url' => route('admin.social-accounts.show', $account->id),
                ];
            })
            ->toArray();

        $results['pages'] = SocialUserPage::where('page_name', 'like', "%{$query}%")
            ->orWhere('page_id', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($page) {
                return [
                    'id' => $page->id,
                    'title' => $page->page_name ?? 'Unknown Page',
                    'type' => 'page',
                    'url' => route('admin.pages.show', $page->id),
                ];
            })
            ->toArray();

        return $results;
    }

    public function quickSearch(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = $this->search($query);
        
        $flattened = [];
        foreach ($results as $type => $items) {
            foreach ($items as $item) {
                $flattened[] = $item;
            }
        }

        return response()->json(array_slice($flattened, 0, 15));
    }

    public function globalSearch(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];

        $customers = Customer::where('role', 'User')
            ->where(function ($q) use ($query) {
                $q->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$query}%"])
                    ->orWhere('email', 'ilike', "%{$query}%")
                    ->orWhere('uuid', 'ilike', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->uuid,
                    'name' => trim(($customer->firstname ?? '') . ' ' . ($customer->lastname ?? '')),
                    'subtitle' => $customer->email,
                    'type' => 'customer',
                    'url' => route('admin.customers.show', $customer->uuid),
                ];
            });

        $pages = SocialUserPage::where('page_name', 'ilike', "%{$query}%")
            ->orWhere('page_id', 'ilike', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($page) {
                return [
                    'id' => $page->id,
                    'name' => $page->page_name ?? 'Unknown Page',
                    'subtitle' => 'Page ID: ' . ($page->page_id ?? 'N/A'),
                    'type' => 'page',
                    'url' => route('admin.pages.show', $page->id),
                ];
            });

        $accounts = SocialUser::where('name', 'ilike', "%{$query}%")
            ->orWhere('email', 'ilike', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($account) {
                return [
                    'id' => $account->id,
                    'name' => $account->name ?? $account->email ?? 'Unknown',
                    'subtitle' => ucfirst($account->platform ?? 'unknown') . ' Account',
                    'type' => 'account',
                    'url' => route('admin.social-accounts.show', $account->id),
                ];
            });

        $results = $customers->merge($pages)->merge($accounts)->take(15)->values()->toArray();

        return response()->json(['results' => $results]);
    }
}

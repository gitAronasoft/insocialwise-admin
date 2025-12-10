<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdsAccount;
use App\Models\Campaign;
use App\Models\Adset;
use App\Models\AdsetAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::with(['customer', 'adsAccount']);

        if ($request->filled('status')) {
            $query->where('campaign_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('campaign_name', 'ilike', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"]);
                    });
            });
        }

        $campaigns = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => Campaign::count(),
            'active' => Campaign::where('campaign_status', 'ACTIVE')->count(),
            'paused' => Campaign::where('campaign_status', 'PAUSED')->count(),
            'total_spend' => Campaign::sum('campaign_insights_spend'),
        ];

        return view('admin.campaigns.index', compact('campaigns', 'stats'));
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['customer', 'adsAccount', 'adsets.ads']);

        return view('admin.campaigns.show', compact('campaign'));
    }

    public function adsAccounts(Request $request)
    {
        $query = AdsAccount::with('customer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('account_name', 'ilike', "%{$search}%")
                    ->orWhere('account_id', 'ilike', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->whereRaw("CONCAT(firstname, ' ', lastname) ILIKE ?", ["%{$search}%"]);
                    });
            });
        }

        $adsAccounts = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => AdsAccount::count(),
            'active' => AdsAccount::where('account_status', 1)->count(),
            'total_campaigns' => Campaign::count(),
        ];

        return view('admin.campaigns.ads-accounts', compact('adsAccounts', 'stats'));
    }

    public function adsets(Request $request)
    {
        $query = Adset::with('campaign.customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $adsets = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.campaigns.adsets', compact('adsets'));
    }

    public function ads(Request $request)
    {
        $query = AdsetAd::with(['adset.campaign.customer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ads = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.campaigns.ads', compact('ads'));
    }
}

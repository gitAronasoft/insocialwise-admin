@extends('admin.layouts.app')

@section('title', 'Campaign - ' . $campaign->campaign_name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">{{ $campaign->campaign_name }}</h3>
        <a href="{{ route('admin.campaigns.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Campaigns</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Status</p>
            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                @if($campaign->campaign_status === 'ACTIVE') bg-green-100 text-green-800
                @elseif($campaign->campaign_status === 'PAUSED') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800
                @endif
            ">{{ ucfirst($campaign->campaign_status) }}</span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Objective</p>
            <p class="text-lg font-bold text-gray-900">{{ $campaign->objective ?? 'N/A' }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Total Spend</p>
            <p class="text-lg font-bold text-gray-900">${{ number_format($campaign->campaign_insights_spend ?? 0, 2) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Created</p>
            <p class="text-sm text-gray-900">{{ $campaign->createdAt ? $campaign->createdAt->format('M d, Y') : 'N/A' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Details</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm font-medium text-gray-500">Customer</p>
                <p class="text-gray-900">{{ $campaign->customer->firstName ?? 'N/A' }} {{ $campaign->customer->lastName ?? '' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Ads Account</p>
                <p class="text-gray-900">{{ $campaign->adsAccount->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Budget (Daily)</p>
                <p class="text-gray-900">${{ number_format($campaign->daily_budget ?? 0, 2) }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Budget (Lifetime)</p>
                <p class="text-gray-900">${{ number_format($campaign->lifetime_budget ?? 0, 2) }}</p>
            </div>
        </div>
    </div>

    @if($campaign->adsets && count($campaign->adsets) > 0)
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Ad Sets ({{ count($campaign->adsets) }})</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Daily Budget</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Ads</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaign->adsets as $adset)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-900">{{ $adset->adsets_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($adset->adsets_status === 'ACTIVE') bg-green-100 text-green-800
                                    @elseif($adset->adsets_status === 'PAUSED') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ $adset->adsets_status ?? 'Unknown' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-900">${{ number_format($adset->adsets_daily_budget ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-gray-900">{{ $adset->ads ? count($adset->ads) : 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

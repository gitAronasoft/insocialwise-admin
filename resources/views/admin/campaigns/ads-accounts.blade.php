@extends('admin.layouts.app')

@section('title', 'Ads Accounts')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Campaigns', 'url' => null], ['label' => 'Ads Accounts', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Ads Accounts</h3>
        <a href="{{ route('admin.campaigns.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Campaigns</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Accounts</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Active Accounts</p>
            <p class="text-3xl font-bold text-green-600">{{ number_format($stats['active']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Campaigns</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_campaigns']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.ads-accounts.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search accounts..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Search</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Currency</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaigns</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($adsAccounts as $account)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-mono text-gray-900">{{ $account->account_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $account->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $account->customer->firstName ?? 'N/A' }} {{ $account->customer->lastName ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($account->account_status == 1) bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ $account->account_status == 1 ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $account->currency ?? 'USD' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $account->campaigns_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $account->createdAt ? $account->createdAt->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No ads accounts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $adsAccounts->links() }}
        </div>
    </div>
</div>
@endsection

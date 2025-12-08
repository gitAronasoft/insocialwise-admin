@extends('admin.layouts.app')

@section('title', 'Dunning Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dunning Dashboard</h1>
            <p class="text-gray-500 mt-1">Monitor and manage payment recovery for past-due subscriptions</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">In Dunning</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_dunning'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Past Due</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['past_due'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Retry Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['retry_pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">High Risk (3+ retries)</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['high_risk'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">At-Risk Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_at_risk_revenue'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.billing.dunning') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer name or email..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <select name="dunning_status" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    @foreach($dunningStatuses as $status)
                        <option value="{{ $status }}" {{ request('dunning_status') === $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="sort" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="payment_retry_count" {{ request('sort') === 'payment_retry_count' ? 'selected' : '' }}>Sort by Retry Count</option>
                    <option value="next_payment_retry_at" {{ request('sort') === 'next_payment_retry_at' ? 'selected' : '' }}>Sort by Next Retry</option>
                    <option value="past_due_since" {{ request('sort') === 'past_due_since' ? 'selected' : '' }}>Sort by Past Due Since</option>
                    <option value="createdAt" {{ request('sort') === 'createdAt' ? 'selected' : '' }}>Sort by Created Date</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Retry Count</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Next Retry</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Error</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subscriptions as $subscription)
                        <tr class="hover:bg-gray-50 transition-colors
                            @if($subscription->payment_retry_count >= 3) bg-red-50 @endif
                        ">
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">
                                            {{ $subscription->customer ? strtoupper(substr($subscription->customer->firstName ?? '', 0, 1) . substr($subscription->customer->lastName ?? '', 0, 1)) : '?' }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            @if($subscription->customer)
                                                {{ $subscription->customer->firstName }} {{ $subscription->customer->lastName }}
                                            @else
                                                Unknown Customer
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $subscription->customer->email ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $subscription->plan->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">
                                    ${{ number_format(($subscription->amount ?? 0), 2) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    /{{ $subscription->billing_interval ?? 'month' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($subscription->status === 'past_due') bg-yellow-100 text-yellow-800
                                        @elseif($subscription->status === 'active') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif
                                    ">{{ ucfirst($subscription->status) }}</span>
                                    @if($subscription->dunning_status && $subscription->dunning_status !== 'none')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($subscription->dunning_status === 'exhausted') bg-red-100 text-red-800
                                            @elseif($subscription->dunning_status === 'final_notice') bg-orange-100 text-orange-800
                                            @elseif($subscription->dunning_status === 'escalated') bg-yellow-100 text-yellow-800
                                            @else bg-blue-100 text-blue-800
                                            @endif
                                        ">{{ ucfirst(str_replace('_', ' ', $subscription->dunning_status)) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-lg font-bold 
                                        @if($subscription->payment_retry_count >= 3) text-red-600
                                        @elseif($subscription->payment_retry_count >= 2) text-orange-600
                                        @else text-gray-900
                                        @endif
                                    ">{{ $subscription->payment_retry_count ?? 0 }}</span>
                                    <span class="text-sm text-gray-500 ml-1">retries</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($subscription->next_payment_retry_at)
                                    <div>{{ $subscription->next_payment_retry_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $subscription->next_payment_retry_at->diffForHumans() }}</div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-red-600 max-w-[200px] truncate">
                                {{ $subscription->last_payment_error ?? '-' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.subscriptions.show', $subscription) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="mt-4 text-gray-500">No subscriptions require payment recovery</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
@endsection

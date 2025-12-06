@extends('admin.layouts.app')

@section('title', 'Billing Overview')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Billing Overview</h1>
            <p class="text-sm text-gray-500 mt-1">Monitor subscriptions, revenue, and billing health</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.billing.activity-logs') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50">
                Activity Logs
            </a>
            <a href="{{ route('admin.billing.payment-methods') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50">
                Payment Methods
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Monthly Recurring Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">${{ number_format($stats['mrr'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">ARR: ${{ number_format($stats['arr'], 2) }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Subscriptions</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['active_subscriptions'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">{{ $stats['trialing'] }} in trial</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Revenue This Month</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">${{ number_format($stats['revenue_this_month'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Last month: ${{ number_format($stats['revenue_last_month'], 2) }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">At Risk</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['past_due'] + $stats['canceled_this_month'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">{{ $stats['past_due'] }} past due, {{ $stats['canceled_this_month'] }} canceled</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                <a href="{{ route('admin.billing.activity-logs') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentLogs as $log)
                    <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                            @if($log->action_status === 'success') bg-green-100
                            @elseif($log->action_status === 'failed') bg-red-100
                            @else bg-gray-100
                            @endif
                        ">
                            @if($log->action_status === 'success')
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @elseif($log->action_status === 'failed')
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm text-gray-900">{{ Str::limit($log->description, 60) }}</p>
                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                <span>{{ $log->created_at?->diffForHumans() }}</span>
                                @if($log->customer)
                                    <span class="mx-1">&bull;</span>
                                    <span>{{ $log->customer->email }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No recent activity</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Upcoming Renewals</h3>
                <span class="text-sm text-gray-500">Next 7 days</span>
            </div>
            <div class="space-y-3">
                @forelse($upcomingRenewals as $subscription)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-xs text-indigo-600 font-medium">{{ strtoupper(substr($subscription->customer->name ?? 'U', 0, 1)) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $subscription->customer->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500">{{ $subscription->plan->name ?? 'Unknown Plan' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">${{ number_format(($subscription->amount ?? 0) / 100, 2) }}</p>
                            <p class="text-xs text-gray-500">{{ $subscription->current_period_end?->format('M d') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">No upcoming renewals</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Transactions Today</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['transactions_today'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Failed Payments (This Month)</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['failed_payments'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Trial Conversions</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['trialing'] }} active</p>
        </div>
    </div>
</div>
@endsection

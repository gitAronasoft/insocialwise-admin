@extends('admin.layouts.app')

@section('title', 'Billing Overview')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Billing', 'url' => null],
        ['label' => 'Overview', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Billing Overview</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitor subscriptions, revenue, and billing health</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.billing.activity-logs') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Activity Logs
            </a>
            <a href="{{ route('admin.billing.payment-methods') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Payment Methods
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-enhanced-stat-card
            title="Monthly Recurring Revenue"
            value="${{ number_format($stats['mrr'], 2) }}"
            subtitle="ARR: ${{ number_format($stats['arr'], 2) }}"
            color="green"
            :link="route('admin.transactions.index')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />

        <x-enhanced-stat-card
            title="Active Subscriptions"
            value="{{ number_format($stats['active_subscriptions']) }}"
            subtitle="{{ $stats['trialing'] }} in trial"
            color="blue"
            :link="route('admin.subscriptions.index')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>'
        />

        <x-enhanced-stat-card
            title="Revenue This Month"
            value="${{ number_format($stats['revenue_this_month'], 2) }}"
            subtitle="Last month: ${{ number_format($stats['revenue_last_month'], 2) }}"
            color="indigo"
            :link="route('admin.revenue')"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>'
        />

        <x-enhanced-stat-card
            title="At Risk"
            value="{{ $stats['past_due'] + $stats['canceled_this_month'] }}"
            subtitle="{{ $stats['past_due'] }} past due, {{ $stats['canceled_this_month'] }} canceled"
            color="red"
            :link="route('admin.subscriptions.index', ['status' => 'past_due'])"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card-section title="Recent Activity" :action-url="route('admin.billing.activity-logs')" action-label="View All">
            <div class="space-y-3">
                @forelse($recentLogs as $log)
                    <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                            @if($log->action_status === 'success') bg-green-100 dark:bg-green-900/30
                            @elseif($log->action_status === 'failed') bg-red-100 dark:bg-red-900/30
                            @else bg-gray-100 dark:bg-gray-700
                            @endif
                        ">
                            @if($log->action_status === 'success')
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @elseif($log->action_status === 'failed')
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ Str::limit($log->description, 60) }}</p>
                            <div class="flex items-center mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <span>{{ $log->created_at?->diffForHumans() }}</span>
                                @if($log->customer)
                                    <span class="mx-1">&bull;</span>
                                    <span class="truncate">{{ $log->customer->email }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <x-empty-state 
                        title="No recent activity"
                        description="Billing activity will appear here once transactions occur."
                        icon="chart"
                    />
                @endforelse
            </div>
        </x-card-section>

        <x-card-section title="Upcoming Renewals">
            <x-slot:header>
                <span class="text-sm text-gray-500 dark:text-gray-400">Next 7 days</span>
            </x-slot:header>
            
            <div class="space-y-3">
                @forelse($upcomingRenewals as $subscription)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center min-w-0">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">{{ strtoupper(substr($subscription->customer->name ?? 'U', 0, 1)) }}</span>
                            </div>
                            <div class="ml-3 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $subscription->customer->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $subscription->plan->name ?? 'Unknown Plan' }}</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0 ml-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${{ number_format(($subscription->amount ?? 0) / 100, 2) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->current_period_end?->format('M d') }}</p>
                        </div>
                    </div>
                @empty
                    <x-empty-state 
                        title="No upcoming renewals"
                        description="Subscriptions renewing in the next 7 days will appear here."
                        icon="credit-card"
                    />
                @endforelse
            </div>
        </x-card-section>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-enhanced-stat-card
            title="Transactions Today"
            value="{{ $stats['transactions_today'] }}"
            color="cyan"
            :border="false"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>'
        />

        <x-enhanced-stat-card
            title="Failed Payments (This Month)"
            value="{{ $stats['failed_payments'] }}"
            color="red"
            :border="false"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />

        <x-enhanced-stat-card
            title="Trial Conversions"
            value="{{ $stats['trialing'] }} active"
            color="purple"
            :border="false"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>'
        />
    </div>
</div>
@endsection

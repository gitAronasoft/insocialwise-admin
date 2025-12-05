@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Analytics Dashboard</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Comprehensive subscription and revenue analytics</p>
        </div>
        <div class="flex items-center gap-3">
            @include('components.period-filter', ['currentPeriod' => $period])
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $dashboardStats['revenue']['formatted'] ?? '$0' }}</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            @php $revenueGrowth = $dashboardStats['revenue'] ?? []; @endphp
            <div class="mt-2 flex items-center text-sm">
                <span class="inline-flex items-center {{ ($revenueGrowth['is_positive'] ?? true) ? 'text-green-600' : 'text-red-600' }} font-medium">
                    @if(($revenueGrowth['trend'] ?? 'up') === 'up')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    @else
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                    @endif
                    {{ abs($revenueGrowth['percentage'] ?? 0) }}%
                </span>
                <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $revenueGrowth['comparison_label'] ?? 'vs last period' }}</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">MRR</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $dashboardStats['mrr']['formatted'] ?? '$0' }}</p>
                </div>
                <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Monthly Recurring Revenue</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer LTV</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $ltv['formatted'] ?? '$0' }}</p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Avg {{ $ltv['avg_subscription_days'] ?? 0 }} days subscription</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-cyan-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Net Revenue Retention</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $nrr['formatted'] ?? '100%' }}</p>
                </div>
                <div class="p-3 bg-cyan-100 dark:bg-cyan-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
            @php $nrrStatus = $nrr['status'] ?? 'healthy'; @endphp
            <p class="mt-2 text-sm">
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $nrrStatus === 'expanding' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($nrrStatus === 'contracting' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400') }}">
                    {{ ucfirst($nrrStatus) }}
                </span>
            </p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Plan Performance</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subscribers</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Conversion Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Churn Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">LTV</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($planPerformance['plans'] ?? [] as $plan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $plan['name'] }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $plan['price'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm font-medium rounded-lg bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                    {{ number_format($plan['subscribers']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600 dark:text-green-400">{{ $plan['revenue_formatted'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ min($plan['conversion_rate'], 100) }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">{{ $plan['conversion_rate_formatted'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm font-medium rounded-lg {{ $plan['churn_rate'] > 5 ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' }}">
                                    {{ $plan['churn_rate_formatted'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600 dark:text-purple-400">{{ $plan['ltv_formatted'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No plan data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Trial Analytics</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-xl">
                    <p class="text-sm text-cyan-600 dark:text-cyan-400">Conversion Rate</p>
                    <p class="text-3xl font-bold text-cyan-700 dark:text-cyan-300">{{ $trialMetrics['conversion_rate_formatted'] ?? '0%' }}</p>
                    <p class="text-xs text-cyan-600 dark:text-cyan-400 mt-1">{{ $trialMetrics['converted_trials'] ?? 0 }} of {{ $trialMetrics['total_trials'] ?? 0 }} trials</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-xl">
                    <p class="text-sm text-indigo-600 dark:text-indigo-400">Active Trials</p>
                    <p class="text-3xl font-bold text-indigo-700 dark:text-indigo-300">{{ $trialMetrics['active_trials'] ?? 0 }}</p>
                    <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1">Currently trialing</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl">
                    <p class="text-sm text-purple-600 dark:text-purple-400">Avg Trial Days</p>
                    <p class="text-3xl font-bold text-purple-700 dark:text-purple-300">{{ $trialMetrics['avg_trial_days'] ?? 0 }}</p>
                    <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">Days to convert</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl">
                    <p class="text-sm text-red-600 dark:text-red-400">Abandonment Rate</p>
                    <p class="text-3xl font-bold text-red-700 dark:text-red-300">{{ $trialMetrics['abandonment_rate_formatted'] ?? '0%' }}</p>
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $trialMetrics['abandoned_trials'] ?? 0 }} abandoned</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Subscription Health</h3>
            <div class="space-y-4">
                @php $health = $subscriptionHealth['health_score'] ?? ['score' => 100, 'status' => 'excellent', 'color' => '#10B981']; @endphp
                <div class="flex items-center justify-between p-4 rounded-xl" style="background-color: {{ $health['color'] }}20">
                    <div>
                        <p class="text-sm font-medium" style="color: {{ $health['color'] }}">Health Score</p>
                        <p class="text-3xl font-bold" style="color: {{ $health['color'] }}">{{ $health['score'] }}%</p>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full" style="background-color: {{ $health['color'] }}30; color: {{ $health['color'] }}">
                        {{ ucfirst(str_replace('_', ' ', $health['status'])) }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <p class="text-xs text-red-600 dark:text-red-400">Failed Payments (30d)</p>
                        <p class="text-xl font-bold text-red-700 dark:text-red-300">{{ $subscriptionHealth['failed_payments_30d'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                        <p class="text-xs text-amber-600 dark:text-amber-400">At Risk</p>
                        <p class="text-xl font-bold text-amber-700 dark:text-amber-300">{{ $subscriptionHealth['at_risk_subscriptions'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <p class="text-xs text-blue-600 dark:text-blue-400">Renewals (7d)</p>
                        <p class="text-xl font-bold text-blue-700 dark:text-blue-300">{{ $subscriptionHealth['upcoming_renewals_7d'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-cyan-50 dark:bg-cyan-900/20 rounded-lg">
                        <p class="text-xs text-cyan-600 dark:text-cyan-400">Expiring Trials</p>
                        <p class="text-xl font-bold text-cyan-700 dark:text-cyan-300">{{ $subscriptionHealth['expiring_trials_7d'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Churn by Plan</h3>
            <div class="space-y-3">
                @forelse($churnAnalytics['churn_by_plan'] ?? [] as $planChurn)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <span class="font-medium text-gray-900 dark:text-white">{{ $planChurn['name'] }}</span>
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $planChurn['churned'] }} churned</span>
                            <span class="px-2 py-1 text-sm font-medium rounded-lg {{ $planChurn['churn_rate'] > 5 ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' }}">
                                {{ $planChurn['churn_rate_formatted'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">No churn data available</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recently Churned</h3>
            <div class="space-y-3">
                @forelse($churnAnalytics['recently_churned'] ?? [] as $churned)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $churned['customer_name'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Active for {{ $churned['was_active_for'] }}</p>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $churned['canceled_at'] }}</span>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">No recent churn</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Posts</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_posts']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Impressions</p>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['total_impressions']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Reach</p>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ number_format($stats['total_reach']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Engagement</p>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($stats['total_engagement']) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Posts by Platform</h3>
            <div class="space-y-4">
                @foreach($platformBreakdown as $platform)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="w-3 h-3 rounded-full 
                                @if($platform->post_platform === 'facebook') bg-blue-500
                                @elseif($platform->post_platform === 'instagram') bg-pink-500
                                @elseif($platform->post_platform === 'twitter') bg-sky-500
                                @elseif($platform->post_platform === 'linkedin') bg-blue-700
                                @else bg-indigo-500
                                @endif
                            "></span>
                            <span class="font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $platform->post_platform ?? 'Unknown' }}</span>
                        </div>
                        <span class="text-gray-900 dark:text-white font-semibold">{{ number_format($platform->count) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.analytics.scores') }}" class="block p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <span class="font-medium text-gray-900 dark:text-white">Social Media Scores</span>
                    <p class="text-sm text-gray-500 dark:text-gray-400">View user social media scores</p>
                </a>
                <a href="{{ route('admin.analytics.page-scores') }}" class="block p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <span class="font-medium text-gray-900 dark:text-white">Page Scores</span>
                    <p class="text-sm text-gray-500 dark:text-gray-400">View individual page scores</p>
                </a>
                <a href="{{ route('admin.analytics.demographics') }}" class="block p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <span class="font-medium text-gray-900 dark:text-white">Demographics</span>
                    <p class="text-sm text-gray-500 dark:text-gray-400">View audience demographics</p>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="block p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                    <span class="font-medium text-indigo-700 dark:text-indigo-300">Back to Dashboard</span>
                    <p class="text-sm text-indigo-600 dark:text-indigo-400">Return to main dashboard</p>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Performing Posts</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Likes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Comments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Shares</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Reach</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($topPosts as $post)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white max-w-xs truncate">{{ Str::limit($post->message, 40) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $post->customer->firstName ?? 'N/A' }} {{ $post->customer->lastName ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($post->post_platform === 'facebook') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                    @elseif($post->post_platform === 'instagram') bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400
                                    @else bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400
                                    @endif
                                ">{{ ucfirst($post->post_platform ?? 'Unknown') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ number_format($post->likes ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ number_format($post->comments ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ number_format($post->shares ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ number_format($post->unique_impressions ?? 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No posts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

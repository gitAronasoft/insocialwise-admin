@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div x-data="dashboardData()" x-init="init()" class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitor your business metrics and performance</p>
        </div>
        <div class="flex items-center gap-3">
            @include('components.period-filter', ['currentPeriod' => $period])
            <a href="{{ route('admin.analytics.index', ['period' => $period]) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Full Analytics
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card hover-lift bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 cursor-pointer border-l-4 border-green-500" onclick="window.location='{{ route('admin.transactions.index') }}'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $analyticsStats['revenue']['formatted'] ?? '$0' }}</p>
                </div>
                <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                @php $revenueGrowth = $analyticsStats['revenue'] ?? []; @endphp
                <span class="inline-flex items-center {{ ($revenueGrowth['is_positive'] ?? true) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
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

        <div class="stat-card hover-lift bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 cursor-pointer border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">MRR</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $analyticsStats['mrr']['formatted'] ?? '$0' }}</p>
                </div>
                <div class="p-3 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/50 dark:to-indigo-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                @php $mrrGrowth = $analyticsStats['mrr'] ?? []; @endphp
                <span class="inline-flex items-center {{ ($mrrGrowth['is_positive'] ?? true) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                    @if(($mrrGrowth['trend'] ?? 'up') === 'up')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    @else
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                    @endif
                    {{ abs($mrrGrowth['percentage'] ?? 0) }}%
                </span>
                <span class="text-gray-500 dark:text-gray-400 ml-2">Monthly Recurring</span>
            </div>
        </div>

        <div class="stat-card hover-lift bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 cursor-pointer border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ARPU</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $analyticsStats['arpu']['formatted'] ?? '$0' }}</p>
                </div>
                <div class="p-3 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                @php $arpuGrowth = $analyticsStats['arpu'] ?? []; @endphp
                <span class="inline-flex items-center {{ ($arpuGrowth['is_positive'] ?? true) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                    @if(($arpuGrowth['trend'] ?? 'up') === 'up')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    @else
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                    @endif
                    {{ abs($arpuGrowth['percentage'] ?? 0) }}%
                </span>
                <span class="text-gray-500 dark:text-gray-400 ml-2">Avg Per User</span>
            </div>
        </div>

        <div class="stat-card hover-lift bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 cursor-pointer border-l-4 border-purple-500" onclick="window.location='{{ route('admin.plans.index') }}'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Top Plan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $analyticsStats['popular_plan']['plan']['name'] ?? 'N/A' }}</p>
                </div>
                <div class="p-3 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/50 dark:to-purple-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                <span class="text-purple-600 dark:text-purple-400 font-medium">
                    {{ $analyticsStats['popular_plan']['plan']['subscribers'] ?? 0 }} subscribers
                </span>
                <span class="text-gray-500 dark:text-gray-400 ml-2">Top revenue generator</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card hover-lift bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 cursor-pointer" onclick="window.location='{{ route('admin.subscriptions.index') }}'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Subscriptions</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($analyticsStats['active_subscriptions']['current'] ?? 0) }}</p>
                </div>
                <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                @php $subsGrowth = $analyticsStats['active_subscriptions'] ?? []; @endphp
                <span class="inline-flex items-center {{ ($subsGrowth['is_positive'] ?? true) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                    @if(($subsGrowth['trend'] ?? 'up') === 'up')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    @else
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                    @endif
                    {{ abs($subsGrowth['percentage'] ?? 0) }}%
                </span>
                <span class="text-gray-500 dark:text-gray-400 ml-2">+{{ $subsGrowth['new_this_period'] ?? 0 }} new</span>
            </div>
        </div>

        <div class="stat-card hover-lift bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 cursor-pointer" onclick="window.location='{{ route('admin.subscriptions.index', ['status' => 'past_due']) }}'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Failed Subscriptions</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($analyticsStats['failed_subscriptions']['current'] ?? 0) }}</p>
                </div>
                <div class="p-3 bg-gradient-to-br from-red-100 to-red-200 dark:from-red-900/50 dark:to-red-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                @php $failedGrowth = $analyticsStats['failed_subscriptions'] ?? []; @endphp
                <span class="inline-flex items-center {{ ($failedGrowth['is_positive'] ?? true) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                    @if(($failedGrowth['trend'] ?? 'up') === 'down')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                    @else
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    @endif
                    {{ abs($failedGrowth['percentage'] ?? 0) }}%
                </span>
                <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $failedGrowth['failed_payments'] ?? 0 }} failed payments</span>
            </div>
        </div>

        <div class="stat-card hover-lift bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Churn Rate</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $analyticsStats['churn_rate']['formatted'] ?? '0%' }}</p>
                </div>
                <div class="p-3 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/50 dark:to-amber-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                @php $churnGrowth = $analyticsStats['churn_rate'] ?? []; @endphp
                <span class="inline-flex items-center {{ ($churnGrowth['is_positive'] ?? true) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                    @if(($churnGrowth['trend'] ?? 'up') === 'down')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                    @else
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    @endif
                    {{ abs($churnGrowth['percentage'] ?? 0) }}%
                </span>
                <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $churnGrowth['churned_count'] ?? 0 }} churned</span>
            </div>
        </div>

        <div class="stat-card hover-lift bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 cursor-pointer" onclick="window.location='{{ route('admin.subscriptions.index', ['status' => 'trialing']) }}'">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Trial Conversion</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $analyticsStats['trial_metrics']['conversion_rate_formatted'] ?? '0%' }}</p>
                </div>
                <div class="p-3 bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/50 dark:to-cyan-800/50 rounded-xl">
                    <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                <span class="text-cyan-600 dark:text-cyan-400 font-medium">
                    {{ $analyticsStats['trial_metrics']['active_trials'] ?? 0 }} active trials
                </span>
                <span class="text-gray-500 dark:text-gray-400 ml-2">{{ $analyticsStats['trial_metrics']['converted_trials'] ?? 0 }} converted</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Subscription Health</h3>
                @php $health = $analyticsStats['subscription_health']['health_score'] ?? []; @endphp
                <span class="px-3 py-1 text-sm font-medium rounded-full" style="background-color: {{ $health['color'] ?? '#10B981' }}20; color: {{ $health['color'] ?? '#10B981' }}">
                    {{ $health['score'] ?? 100 }}% Healthy
                </span>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Failed Payments (30d)</span>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $analyticsStats['subscription_health']['failed_payments_30d'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Upcoming Renewals (7d)</span>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $analyticsStats['subscription_health']['upcoming_renewals_7d'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">At Risk Subscriptions</span>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $analyticsStats['subscription_health']['at_risk_subscriptions'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Expiring Trials (7d)</span>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $analyticsStats['subscription_health']['expiring_trials_7d'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Key Metrics</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Customer LTV</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $analyticsStats['ltv']['formatted'] ?? '$0' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Avg subscription</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $analyticsStats['ltv']['avg_subscription_days'] ?? 0 }} days</p>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Net Revenue Retention</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $analyticsStats['nrr']['formatted'] ?? '100%' }}</p>
                    </div>
                    <div class="text-right">
                        @php $nrrStatus = $analyticsStats['nrr']['status'] ?? 'healthy'; @endphp
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $nrrStatus === 'expanding' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($nrrStatus === 'contracting' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400') }}">
                            {{ ucfirst($nrrStatus) }}
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total Customers</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_customers']) }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total Revenue</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($stats['total_revenue'], 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Stats</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/30 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">New Today</p>
                            <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-200">{{ $stats['new_customers_today'] }}</p>
                        </div>
                        <div class="p-2 bg-indigo-200 dark:bg-indigo-800 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600 dark:text-green-400">This Week</p>
                            <p class="text-2xl font-bold text-green-900 dark:text-green-200">{{ $stats['new_customers_week'] }}</p>
                        </div>
                        <div class="p-2 bg-green-200 dark:bg-green-800 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Posts</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-200">{{ number_format($stats['total_posts']) }}</p>
                        </div>
                        <div class="p-2 bg-blue-200 dark:bg-blue-800 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Pages</p>
                            <p class="text-2xl font-bold text-purple-900 dark:text-purple-200">{{ number_format($stats['total_pages']) }}</p>
                        </div>
                        <div class="p-2 bg-purple-200 dark:bg-purple-800 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Revenue Overview</h3>
                <span x-show="revenueData" x-text="'$' + (revenueData?.data?.total || 0).toLocaleString()" class="text-sm font-medium text-green-600 dark:text-green-400"></span>
            </div>
            <div class="relative" style="height: 300px;">
                <template x-if="loadingRevenue">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-pulse w-full h-full bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                </template>
                <template x-if="revenueError">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Failed to load revenue data</p>
                            <button @click="loadRevenueChart()" class="mt-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm">Retry</button>
                        </div>
                    </div>
                </template>
                <template x-if="!loadingRevenue && !revenueError">
                    <canvas id="revenueChart"></canvas>
                </template>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Revenue by Plan</h3>
            </div>
            <div class="relative" style="height: 300px;">
                <template x-if="loadingPlanRevenue">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-pulse w-full h-full bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <svg class="animate-spin h-8 w-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                </template>
                <template x-if="planRevenueError">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Failed to load plan revenue</p>
                            <button @click="loadPlanRevenueChart()" class="mt-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm">Retry</button>
                        </div>
                    </div>
                </template>
                <template x-if="!loadingPlanRevenue && !planRevenueError">
                    <canvas id="planRevenueChart"></canvas>
                </template>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Subscription Trends</h3>
            </div>
            <div class="relative" style="height: 300px;">
                <template x-if="loadingTrends">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-pulse w-full h-full bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                </template>
                <template x-if="trendsError">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Failed to load trends</p>
                            <button @click="loadTrendsChart()" class="mt-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm">Retry</button>
                        </div>
                    </div>
                </template>
                <template x-if="!loadingTrends && !trendsError">
                    <canvas id="trendsChart"></canvas>
                </template>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Subscription Breakdown</h3>
                <span x-show="subscriptionData" x-text="(subscriptionData?.data?.total || 0).toLocaleString() + ' total'" class="text-sm font-medium text-purple-600 dark:text-purple-400"></span>
            </div>
            <div class="relative" style="height: 300px;">
                <template x-if="loadingSubscription">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-pulse w-full h-full bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <svg class="animate-spin h-8 w-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                </template>
                <template x-if="subscriptionError">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Failed to load subscription data</p>
                            <button @click="loadSubscriptionChart()" class="mt-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm">Retry</button>
                        </div>
                    </div>
                </template>
                <template x-if="!loadingSubscription && !subscriptionError">
                    <canvas id="subscriptionChart"></canvas>
                </template>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function dashboardData() {
    return {
        period: '{{ $period }}',
        revenueData: null,
        customerData: null,
        subscriptionData: null,
        planRevenueData: null,
        trendsData: null,
        loadingRevenue: true,
        loadingCustomer: true,
        loadingSubscription: true,
        loadingPlanRevenue: true,
        loadingTrends: true,
        revenueError: false,
        customerError: false,
        subscriptionError: false,
        planRevenueError: false,
        trendsError: false,
        revenueChart: null,
        customerChart: null,
        subscriptionChart: null,
        planRevenueChart: null,
        trendsChart: null,

        init() {
            this.loadRevenueChart();
            this.loadSubscriptionChart();
            this.loadPlanRevenueChart();
            this.loadTrendsChart();
        },

        async loadRevenueChart() {
            this.loadingRevenue = true;
            this.revenueError = false;
            try {
                const response = await fetch(`/admin/dashboard/revenue-chart?period=${this.period}`);
                this.revenueData = await response.json();
                if (this.revenueData.success) {
                    this.$nextTick(() => this.renderRevenueChart());
                } else {
                    this.revenueError = true;
                }
            } catch (error) {
                this.revenueError = true;
            } finally {
                this.loadingRevenue = false;
            }
        },

        renderRevenueChart() {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;
            
            if (this.revenueChart) this.revenueChart.destroy();
            
            const isDark = document.documentElement.classList.contains('dark');
            
            this.revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.revenueData.data.labels,
                    datasets: [{
                        label: 'Revenue',
                        data: this.revenueData.data.data,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => '$' + value.toLocaleString(),
                                color: isDark ? '#9CA3AF' : '#6B7280'
                            },
                            grid: { color: isDark ? '#374151' : '#E5E7EB' }
                        },
                        x: {
                            ticks: { color: isDark ? '#9CA3AF' : '#6B7280' },
                            grid: { display: false }
                        }
                    }
                }
            });
        },

        async loadSubscriptionChart() {
            this.loadingSubscription = true;
            this.subscriptionError = false;
            try {
                const response = await fetch('/admin/dashboard/subscription-pie');
                this.subscriptionData = await response.json();
                if (this.subscriptionData.success) {
                    this.$nextTick(() => this.renderSubscriptionChart());
                } else {
                    this.subscriptionError = true;
                }
            } catch (error) {
                this.subscriptionError = true;
            } finally {
                this.loadingSubscription = false;
            }
        },

        renderSubscriptionChart() {
            const ctx = document.getElementById('subscriptionChart');
            if (!ctx) return;
            
            if (this.subscriptionChart) this.subscriptionChart.destroy();
            
            this.subscriptionChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: this.subscriptionData.data.labels,
                    datasets: [{
                        data: this.subscriptionData.data.data,
                        backgroundColor: this.subscriptionData.data.colors,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        },

        async loadPlanRevenueChart() {
            this.loadingPlanRevenue = true;
            this.planRevenueError = false;
            try {
                const response = await fetch(`/admin/dashboard/revenue-by-plan?period=${this.period}`);
                this.planRevenueData = await response.json();
                if (this.planRevenueData.success) {
                    this.$nextTick(() => this.renderPlanRevenueChart());
                } else {
                    this.planRevenueError = true;
                }
            } catch (error) {
                this.planRevenueError = true;
            } finally {
                this.loadingPlanRevenue = false;
            }
        },

        renderPlanRevenueChart() {
            const ctx = document.getElementById('planRevenueChart');
            if (!ctx) return;
            
            if (this.planRevenueChart) this.planRevenueChart.destroy();
            
            const isDark = document.documentElement.classList.contains('dark');
            const plans = this.planRevenueData.data.plans || [];
            
            this.planRevenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: plans.map(p => p.name),
                    datasets: [{
                        label: 'Revenue',
                        data: plans.map(p => p.revenue),
                        backgroundColor: plans.map(p => p.color),
                        borderRadius: 8,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => '$' + value.toLocaleString(),
                                color: isDark ? '#9CA3AF' : '#6B7280'
                            },
                            grid: { color: isDark ? '#374151' : '#E5E7EB' }
                        },
                        y: {
                            ticks: { color: isDark ? '#9CA3AF' : '#6B7280' },
                            grid: { display: false }
                        }
                    }
                }
            });
        },

        async loadTrendsChart() {
            this.loadingTrends = true;
            this.trendsError = false;
            try {
                const response = await fetch(`/admin/dashboard/subscription-trends?period=${this.period}`);
                this.trendsData = await response.json();
                if (this.trendsData.success) {
                    this.$nextTick(() => this.renderTrendsChart());
                } else {
                    this.trendsError = true;
                }
            } catch (error) {
                this.trendsError = true;
            } finally {
                this.loadingTrends = false;
            }
        },

        renderTrendsChart() {
            const ctx = document.getElementById('trendsChart');
            if (!ctx) return;
            
            if (this.trendsChart) this.trendsChart.destroy();
            
            const isDark = document.documentElement.classList.contains('dark');
            
            this.trendsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.trendsData.data.labels,
                    datasets: this.trendsData.data.datasets.map(ds => ({
                        ...ds,
                        fill: true,
                        tension: 0.4,
                    }))
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: isDark ? '#9CA3AF' : '#6B7280' },
                            grid: { color: isDark ? '#374151' : '#E5E7EB' }
                        },
                        x: {
                            ticks: { color: isDark ? '#9CA3AF' : '#6B7280' },
                            grid: { display: false }
                        }
                    }
                }
            });
        },

    };
}
</script>
@endsection

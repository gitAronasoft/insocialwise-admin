@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div x-data="dashboardData()" x-init="init()" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Customers</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_customers']) }}</p>
                </div>
                <div class="p-3 bg-indigo-100 dark:bg-indigo-900/50 rounded-full">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                <span class="text-green-600 dark:text-green-400 font-medium">+{{ $stats['new_customers_week'] }}</span> this week
            </p>
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Subscriptions</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['active_subscriptions']) }}</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Active paid users
            </p>
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Posts</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_posts']) }}</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Posts created by users
            </p>
        </div>

        <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Connected Pages</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_pages']) }}</p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900/50 rounded-full">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Social media pages
            </p>
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
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Customer Growth</h3>
                <span x-show="customerData" x-text="(customerData?.data?.total || 0).toLocaleString() + ' signups'" class="text-sm font-medium text-blue-600 dark:text-blue-400"></span>
            </div>
            <div class="relative" style="height: 300px;">
                <template x-if="loadingCustomer">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-pulse w-full h-full bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                </template>
                <template x-if="customerError">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Failed to load customer data</p>
                            <button @click="loadCustomerChart()" class="mt-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm">Retry</button>
                        </div>
                    </div>
                </template>
                <template x-if="!loadingCustomer && !customerError">
                    <canvas id="customerChart"></canvas>
                </template>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
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
                    <p class="mt-2 text-xs text-indigo-600 dark:text-indigo-400">Customers signed up today</p>
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
                    <p class="mt-2 text-xs text-green-600 dark:text-green-400">New customers this week</p>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-800/30 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-amber-600 dark:text-amber-400">Pending</p>
                            <p class="text-2xl font-bold text-amber-900 dark:text-amber-200">{{ $stats['pending_subscriptions'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-amber-200 dark:bg-amber-800 rounded-lg">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">Trialing subscriptions</p>
                </div>

                <div class="bg-gradient-to-br from-rose-50 to-rose-100 dark:from-rose-900/30 dark:to-rose-800/30 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-rose-600 dark:text-rose-400">Revenue</p>
                            <p class="text-2xl font-bold text-rose-900 dark:text-rose-200">${{ number_format($stats['total_revenue'] ?? 0, 0) }}</p>
                        </div>
                        <div class="p-2 bg-rose-200 dark:bg-rose-800 rounded-lg">
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-rose-600 dark:text-rose-400">Total revenue</p>
                </div>
            </div>

            <div class="mt-6">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Recent Customers</h4>
                <div class="space-y-3">
                    @forelse($recentCustomers->take(3) as $customer)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-600 dark:text-indigo-400 font-medium text-sm">{{ strtoupper(substr($customer->firstName, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $customer->firstName }} {{ $customer->lastName }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->createdAt->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-xs">View</a>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-2 text-sm">No customers yet</p>
                    @endforelse
                </div>
                <a href="{{ route('admin.customers.index') }}" class="mt-3 block text-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm">View All Customers</a>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-colors">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>
            <button 
                @click="refreshActivity()" 
                :disabled="loadingActivity"
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
                <svg :class="{ 'animate-spin': loadingActivity }" class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <template x-if="loadingActivity && !activityData.length">
                <div class="space-y-3">
                    <div class="animate-pulse flex space-x-4 p-4">
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/4"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/6"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/3"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/6"></div>
                    </div>
                    <div class="animate-pulse flex space-x-4 p-4">
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/4"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/6"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/3"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/6"></div>
                    </div>
                    <div class="animate-pulse flex space-x-4 p-4">
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/4"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/6"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/3"></div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/6"></div>
                    </div>
                </div>
            </template>
            
            <template x-if="activityError">
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p>Failed to load activity data</p>
                    <button @click="refreshActivity()" class="mt-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm">Retry</button>
                </div>
            </template>

            <template x-if="!loadingActivity || activityData.length">
                <table x-show="activityData.length" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="activity in activityData" :key="activity.id">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900 dark:text-gray-200" x-text="activity.user_name"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200" x-text="activity.activity_type"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="activity.action"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="activity.time"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </template>
            
            <template x-if="!loadingActivity && !activityError && !activityData.length">
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>No recent activity</p>
                </div>
            </template>
        </div>
        <a href="{{ route('admin.activities.index') }}" class="mt-4 block text-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 text-sm">View All Activity</a>
    </div>
</div>

<script>
function dashboardData() {
    return {
        loadingRevenue: true,
        loadingCustomer: true,
        loadingSubscription: true,
        loadingActivity: true,
        revenueData: null,
        customerData: null,
        subscriptionData: null,
        activityData: [],
        revenueError: false,
        customerError: false,
        subscriptionError: false,
        activityError: false,
        revenueChart: null,
        customerChart: null,
        subscriptionChart: null,
        chartRevenueInitialized: false,
        chartCustomerInitialized: false,
        chartSubscriptionInitialized: false,
        
        isDarkMode() {
            return document.documentElement.classList.contains('dark');
        },
        
        getChartColors() {
            const isDark = this.isDarkMode();
            return {
                text: isDark ? '#e5e7eb' : '#374151',
                grid: isDark ? '#374151' : '#e5e7eb',
                background: isDark ? '#1f2937' : '#ffffff',
            };
        },
        
        async init() {
            await Promise.all([
                this.loadRevenueChart(),
                this.loadCustomerChart(),
                this.loadSubscriptionChart(),
                this.loadActivityData()
            ]);
            
            const observer = new MutationObserver(() => {
                this.updateChartThemes();
            });
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        },
        
        updateChartThemes() {
            const colors = this.getChartColors();
            
            [this.revenueChart, this.customerChart, this.subscriptionChart].forEach(chart => {
                if (chart) {
                    if (chart.options.scales?.x) {
                        chart.options.scales.x.ticks.color = colors.text;
                        chart.options.scales.x.grid.color = colors.grid;
                    }
                    if (chart.options.scales?.y) {
                        chart.options.scales.y.ticks.color = colors.text;
                        chart.options.scales.y.grid.color = colors.grid;
                    }
                    if (chart.options.plugins?.legend) {
                        chart.options.plugins.legend.labels.color = colors.text;
                    }
                    chart.update();
                }
            });
        },
        
        async loadRevenueChart() {
            this.loadingRevenue = true;
            this.revenueError = false;
            this.chartRevenueInitialized = false;
            
            try {
                const response = await fetch('/admin/dashboard/revenue-chart');
                const result = await response.json();
                
                if (!result.success) throw new Error(result.error);
                
                this.revenueData = result;
                this.loadingRevenue = false;
                
                await this.$nextTick();
                this.initRevenueChart();
            } catch (error) {
                console.error('Revenue chart error:', error);
                this.revenueError = true;
                this.loadingRevenue = false;
            }
        },
        
        initRevenueChart() {
            if (this.chartRevenueInitialized) return;
            
            const ctx = document.getElementById('revenueChart');
            if (!ctx || !this.revenueData?.data) return;
            
            const colors = this.getChartColors();
            
            if (this.revenueChart) {
                this.revenueChart.destroy();
            }
            
            this.chartRevenueInitialized = true;
            this.revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.revenueData.data.labels,
                    datasets: [{
                        label: 'Revenue ($)',
                        data: this.revenueData.data.data,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: colors.background,
                            titleColor: colors.text,
                            bodyColor: colors.text,
                            borderColor: colors.grid,
                            borderWidth: 1,
                            callbacks: {
                                label: (context) => `$${context.parsed.y.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: colors.text },
                            grid: { color: colors.grid, display: false }
                        },
                        y: {
                            ticks: { 
                                color: colors.text,
                                callback: (value) => '$' + value.toLocaleString()
                            },
                            grid: { color: colors.grid }
                        }
                    }
                }
            });
        },
        
        async loadCustomerChart() {
            this.loadingCustomer = true;
            this.customerError = false;
            this.chartCustomerInitialized = false;
            
            try {
                const response = await fetch('/admin/dashboard/customer-growth');
                const result = await response.json();
                
                if (!result.success) throw new Error(result.error);
                
                this.customerData = result;
                this.loadingCustomer = false;
                
                await this.$nextTick();
                this.initCustomerChart();
            } catch (error) {
                console.error('Customer chart error:', error);
                this.customerError = true;
                this.loadingCustomer = false;
            }
        },
        
        initCustomerChart() {
            if (this.chartCustomerInitialized) return;
            
            const ctx = document.getElementById('customerChart');
            if (!ctx || !this.customerData?.data) return;
            
            const colors = this.getChartColors();
            
            if (this.customerChart) {
                this.customerChart.destroy();
            }
            
            this.chartCustomerInitialized = true;
            this.customerChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.customerData.data.labels,
                    datasets: [{
                        label: 'New Customers',
                        data: this.customerData.data.data,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        borderRadius: 6,
                        barThickness: 20,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: colors.background,
                            titleColor: colors.text,
                            bodyColor: colors.text,
                            borderColor: colors.grid,
                            borderWidth: 1,
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: colors.text },
                            grid: { display: false }
                        },
                        y: {
                            ticks: { color: colors.text },
                            grid: { color: colors.grid },
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        
        async loadSubscriptionChart() {
            this.loadingSubscription = true;
            this.subscriptionError = false;
            this.chartSubscriptionInitialized = false;
            
            try {
                const response = await fetch('/admin/dashboard/subscription-pie');
                const result = await response.json();
                
                if (!result.success) throw new Error(result.error);
                
                this.subscriptionData = result;
                this.loadingSubscription = false;
                
                await this.$nextTick();
                this.initSubscriptionChart();
            } catch (error) {
                console.error('Subscription chart error:', error);
                this.subscriptionError = true;
                this.loadingSubscription = false;
            }
        },
        
        initSubscriptionChart() {
            if (this.chartSubscriptionInitialized) return;
            
            const ctx = document.getElementById('subscriptionChart');
            if (!ctx || !this.subscriptionData?.data) return;
            
            const colors = this.getChartColors();
            
            if (this.subscriptionChart) {
                this.subscriptionChart.destroy();
            }
            
            this.chartSubscriptionInitialized = true;
            this.subscriptionChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: this.subscriptionData.data.labels,
                    datasets: [{
                        data: this.subscriptionData.data.data,
                        backgroundColor: this.subscriptionData.data.colors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: colors.text,
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: colors.background,
                            titleColor: colors.text,
                            bodyColor: colors.text,
                            borderColor: colors.grid,
                            borderWidth: 1,
                        }
                    },
                    cutout: '60%'
                }
            });
        },
        
        async loadActivityData() {
            this.loadingActivity = true;
            this.activityError = false;
            
            try {
                const response = await fetch('/admin/dashboard/recent-activity');
                const result = await response.json();
                
                if (!result.success) throw new Error(result.error);
                
                this.activityData = result.data;
            } catch (error) {
                console.error('Activity data error:', error);
                this.activityError = true;
            } finally {
                this.loadingActivity = false;
            }
        },
        
        async refreshActivity() {
            await this.loadActivityData();
        }
    }
}
</script>
@endsection

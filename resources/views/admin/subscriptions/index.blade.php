@extends('admin.layouts.app')

@section('title', 'Subscriptions')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Billing', 'url' => route('admin.billing.overview')],
        ['label' => 'Subscriptions', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Subscriptions</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage and monitor customer subscriptions</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-enhanced-stat-card
            title="Total Subscriptions"
            value="{{ number_format($stats['total']) }}"
            color="gray"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'
        />
        <x-enhanced-stat-card
            title="Active"
            value="{{ number_format($stats['active']) }}"
            color="green"
            :link="route('admin.subscriptions.index', ['status' => 'active'])"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />
        <x-enhanced-stat-card
            title="Trialing"
            value="{{ number_format($stats['trialing']) }}"
            color="blue"
            :link="route('admin.subscriptions.index', ['status' => 'trialing'])"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />
        <x-enhanced-stat-card
            title="Canceled"
            value="{{ number_format($stats['canceled']) }}"
            color="red"
            :link="route('admin.subscriptions.index', ['status' => 'canceled'])"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />
    </div>

    <x-data-table
        id="subscriptions-table"
        endpoint="{{ route('admin.subscriptions.index') }}"
        :columns="[
            ['key' => 'customer', 'label' => 'Customer', 'sortable' => false],
            ['key' => 'stripe_subscription_id', 'label' => 'Subscription ID', 'sortable' => false],
            ['key' => 'status', 'label' => 'Status', 'sortable' => true],
            ['key' => 'period', 'label' => 'Current Period', 'sortable' => false],
            ['key' => 'createdAt', 'label' => 'Created', 'sortable' => true],
            ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
        ]"
        :bulk-actions="[
            ['action' => 'export', 'label' => 'Export Selected', 'url' => route('admin.subscriptions.export'), 'type' => 'export'],
        ]"
        search-placeholder="Search by customer name or subscription ID..."
        default-sort="createdAt"
        default-sort-direction="desc"
        :per-page="15"
        :filters="['status' => '']"
    >
        <x-slot:toolbar>
            <select
                x-model="filters.status"
                @change="updateFilter('status', $event.target.value)"
                class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-2 pl-3 pr-8 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="trialing">Trialing</option>
                <option value="canceled">Canceled</option>
                <option value="past_due">Past Due</option>
            </select>
        </x-slot:toolbar>

        <x-slot:row>
            <td class="px-4 py-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium" x-text="item.customer && item.customer.firstName ? item.customer.firstName.charAt(0).toUpperCase() : '?'"></span>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="item.customer ? ((item.customer.firstName || '') + ' ' + (item.customer.lastName || '')) : 'N/A'"></div>
                        <div class="text-xs text-gray-500 dark:text-gray-400" x-text="item.customer ? item.customer.email : ''"></div>
                    </div>
                </div>
            </td>
            <td class="px-4 py-4">
                <span class="text-sm text-gray-700 dark:text-gray-300 font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded" x-text="item.stripe_subscription_id ? item.stripe_subscription_id.substring(0, 20) + (item.stripe_subscription_id.length > 20 ? '...' : '') : 'N/A'"></span>
            </td>
            <td class="px-4 py-4">
                <template x-if="item.status === 'active'">
                    <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                        Active
                    </span>
                </template>
                <template x-if="item.status === 'trialing'">
                    <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                        Trialing
                    </span>
                </template>
                <template x-if="item.status === 'canceled'">
                    <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                        Canceled
                    </span>
                </template>
                <template x-if="item.status === 'past_due'">
                    <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400">
                        <span class="relative flex h-1.5 w-1.5 mr-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-orange-500"></span>
                        </span>
                        Past Due
                    </span>
                </template>
                <template x-if="item.status !== 'active' && item.status !== 'trialing' && item.status !== 'canceled' && item.status !== 'past_due'">
                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300" x-text="item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) : 'Unknown'"></span>
                </template>
            </td>
            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                <span x-text="(item.current_period_start ? new Date(item.current_period_start).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : 'N/A') + ' - ' + (item.current_period_end ? new Date(item.current_period_end).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A')"></span>
            </td>
            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                <span x-text="item.createdAt ? new Date(item.createdAt).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A'"></span>
            </td>
            <td class="px-4 py-4">
                <a :href="'/admin/subscriptions/' + item.id" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View
                </a>
            </td>
        </x-slot:row>
    </x-data-table>
</div>
@endsection

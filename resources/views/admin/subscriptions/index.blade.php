@extends('admin.layouts.app')

@section('title', 'Subscriptions')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Subscriptions</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Subscriptions</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active</p>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ number_format($stats['active']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Trialing</p>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['trialing']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Canceled</p>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ number_format($stats['canceled']) }}</p>
        </div>
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
                class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-2 pl-3 pr-8 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
            >
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="trialing">Trialing</option>
                <option value="canceled">Canceled</option>
                <option value="past_due">Past Due</option>
            </select>
        </x-slot:toolbar>

        <x-slot:row>
            <td class="px-4 py-3">
                <div class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="item.customer ? ((item.customer.firstName || '') + ' ' + (item.customer.lastName || '')) : 'N/A'"></div>
                <div class="text-sm text-gray-500 dark:text-gray-400" x-text="item.customer ? item.customer.email : ''"></div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 font-mono">
                <span x-text="item.stripe_subscription_id ? item.stripe_subscription_id.substring(0, 20) + (item.stripe_subscription_id.length > 20 ? '...' : '') : 'N/A'"></span>
            </td>
            <td class="px-4 py-3">
                <template x-if="item.status === 'active'">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">Active</span>
                </template>
                <template x-if="item.status === 'trialing'">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">Trialing</span>
                </template>
                <template x-if="item.status === 'canceled'">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">Canceled</span>
                </template>
                <template x-if="item.status !== 'active' && item.status !== 'trialing' && item.status !== 'canceled'">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300" x-text="item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) : 'Unknown'"></span>
                </template>
            </td>
            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                <span x-text="(item.current_period_start ? new Date(item.current_period_start).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : 'N/A') + ' - ' + (item.current_period_end ? new Date(item.current_period_end).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A')"></span>
            </td>
            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                <span x-text="item.createdAt ? new Date(item.createdAt).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A'"></span>
            </td>
            <td class="px-4 py-3 text-sm font-medium">
                <a :href="'/admin/subscriptions/' + item.id" class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300">View</a>
            </td>
        </x-slot:row>
    </x-data-table>
</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Customers</h2>
    </div>

    <x-data-table
        id="customers-table"
        endpoint="{{ route('admin.customers.index') }}"
        :columns="[
            ['key' => 'customer', 'label' => 'Customer', 'sortable' => false],
            ['key' => 'email', 'label' => 'Email', 'sortable' => true],
            ['key' => 'social_accounts', 'label' => 'Social Accounts', 'sortable' => false],
            ['key' => 'pages', 'label' => 'Pages', 'sortable' => false],
            ['key' => 'posts', 'label' => 'Posts', 'sortable' => false],
            ['key' => 'status', 'label' => 'Status', 'sortable' => true],
            ['key' => 'createdAt', 'label' => 'Joined', 'sortable' => true],
            ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
        ]"
        :bulk-actions="[
            ['action' => 'activate', 'label' => 'Activate Selected', 'url' => route('admin.customers.bulk-status'), 'type' => 'default'],
            ['action' => 'deactivate', 'label' => 'Deactivate Selected', 'url' => route('admin.customers.bulk-status'), 'type' => 'default'],
            ['action' => 'delete', 'label' => 'Deactivate (Soft Delete)', 'url' => route('admin.customers.bulk-delete'), 'type' => 'delete', 'confirm' => 'Are you sure you want to deactivate the selected customers?'],
            ['action' => 'export', 'label' => 'Export Selected', 'url' => route('admin.customers.export'), 'type' => 'export'],
        ]"
        search-placeholder="Search by name or email..."
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
                <option value="inactive">Inactive</option>
            </select>
        </x-slot:toolbar>

        <x-slot:row>
            <td class="px-4 py-3">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-primary-600 dark:text-primary-400 font-medium text-sm" x-text="item.firstName ? item.firstName.charAt(0).toUpperCase() : '?'"></span>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="(item.firstName || '') + ' ' + (item.lastName || '')"></div>
                        <div class="text-xs text-gray-500 dark:text-gray-400" x-text="item.uuid"></div>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300" x-text="item.email"></td>
            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400" x-text="item.social_users_count || 0"></td>
            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400" x-text="item.social_pages_count || 0"></td>
            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400" x-text="item.posts_count || 0"></td>
            <td class="px-4 py-3">
                <template x-if="item.status">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">Active</span>
                </template>
                <template x-if="!item.status">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">Inactive</span>
                </template>
            </td>
            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                <span x-text="item.createdAt ? new Date(item.createdAt).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A'"></span>
            </td>
            <td class="px-4 py-3 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <a :href="'/admin/customers/' + item.uuid" class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300">View</a>
                    <a :href="'/admin/customers/' + item.uuid + '/edit'" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">Edit</a>
                </div>
            </td>
        </x-slot:row>
    </x-data-table>
</div>
@endsection

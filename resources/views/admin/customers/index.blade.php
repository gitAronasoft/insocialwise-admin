@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'User Management', 'url' => null],
        ['label' => 'Customers', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Customers</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage and view all registered customers</p>
        </div>
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
            ['key' => 'created_at', 'label' => 'Joined', 'sortable' => true],
            ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
        ]"
        :bulk-actions="[
            ['action' => 'activate', 'label' => 'Activate Selected', 'url' => route('admin.customers.bulk-status'), 'type' => 'default'],
            ['action' => 'deactivate', 'label' => 'Deactivate Selected', 'url' => route('admin.customers.bulk-status'), 'type' => 'default'],
            ['action' => 'delete', 'label' => 'Deactivate (Soft Delete)', 'url' => route('admin.customers.bulk-delete'), 'type' => 'delete', 'confirm' => 'Are you sure you want to deactivate the selected customers?'],
            ['action' => 'export', 'label' => 'Export Selected', 'url' => route('admin.customers.export'), 'type' => 'export'],
        ]"
        search-placeholder="Search by name or email..."
        default-sort="created_at"
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
                <option value="inactive">Inactive</option>
            </select>
        </x-slot:toolbar>

        <x-slot:row>
            <td class="px-4 py-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-indigo-600 dark:text-indigo-400 font-medium text-sm" x-text="item.firstName ? item.firstName.charAt(0).toUpperCase() : '?'"></span>
                    </div>
                    <div class="ml-3 min-w-0">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate" x-text="(item.firstName || '') + ' ' + (item.lastName || '')"></div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 font-mono truncate" x-text="item.uuid"></div>
                    </div>
                </div>
            </td>
            <td class="px-4 py-4">
                <span class="text-sm text-gray-700 dark:text-gray-300" x-text="item.email"></span>
            </td>
            <td class="px-4 py-4">
                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium" x-text="item.social_users_count || 0"></span>
                </div>
            </td>
            <td class="px-4 py-4">
                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-sm font-medium" x-text="item.social_pages_count || 0"></span>
                </div>
            </td>
            <td class="px-4 py-4">
                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-sm font-medium" x-text="item.posts_count || 0"></span>
                </div>
            </td>
            <td class="px-4 py-4">
                <template x-if="item.status">
                    <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                        Active
                    </span>
                </template>
                <template x-if="!item.status">
                    <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                        Inactive
                    </span>
                </template>
            </td>
            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                <span x-text="item.created_at ? new Date(item.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A'"></span>
            </td>
            <td class="px-4 py-4">
                <div class="flex items-center gap-2">
                    <a :href="'/admin/customers/' + item.uuid" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-md hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View
                    </a>
                    <a :href="'/admin/customers/' + item.uuid + '/edit'" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                </div>
            </td>
        </x-slot:row>
    </x-data-table>
</div>
@endsection

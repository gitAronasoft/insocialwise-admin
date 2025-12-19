@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Audit Logs')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'System', 'url' => null],
        ['label' => 'Audit Logs', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Audit Logs</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Track all admin actions and changes</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.audit-logs.security') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Security Overview
            </a>
            <a href="{{ route('admin.audit-logs.sessions') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Admin Sessions
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Today's Actions</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_today']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-indigo-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">This Week</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_week']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-green-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Active Admins Today</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['unique_admins_today']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Warnings (7d)</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ number_format($stats['warnings']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-red-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Critical (7d)</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">{{ number_format($stats['critical']) }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="form-input w-full">
            </div>
            <div>
                <select name="admin_id" class="form-select w-full">
                    <option value="">All Admins</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                            {{ $admin->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="action_type" class="form-select w-full">
                    <option value="">All Actions</option>
                    @foreach($actionTypes as $type)
                        <option value="{{ $type }}" {{ request('action_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="severity" class="form-select w-full">
                    <option value="">All Severity</option>
                    <option value="info" {{ request('severity') == 'info' ? 'selected' : '' }}>Info</option>
                    <option value="warning" {{ request('severity') == 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                </select>
            </div>
            <div>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                    class="form-input w-full" placeholder="From Date">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">Filter</button>
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Timestamp</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Admin</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP Address</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Severity</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                <div>{{ DateHelper::formatDateTime($log->created_at) }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                        <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">
                                            {{ $log->admin_name ? strtoupper(substr($log->admin_name, 0, 1)) : '?' }}
                                        </span>
                                    </div>
                                    <div class="ml-2">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $log->admin_name ?? 'System' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $log->admin_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    {{ $log->action_label }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300 max-w-md">
                                <div class="truncate" title="{{ $log->description }}">{{ Str::limit($log->description, 60) }}</div>
                                @if($log->entity_type)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $log->entity_type }}{{ $log->entity_id ? ': ' . $log->entity_id : '' }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-gray-600 dark:text-gray-400">{{ $log->ip_address ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @php
                                    $severityColors = [
                                        'info' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'critical' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $severityColors[$log->severity] ?? $severityColors['info'] }}">
                                    {{ ucfirst($log->severity) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.audit-logs.show', $log) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                No audit logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

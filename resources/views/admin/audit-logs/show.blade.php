@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Audit Log Details')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'System', 'url' => null],
        ['label' => 'Audit Logs', 'url' => route('admin.audit-logs.index')],
        ['label' => 'Log #' . $auditLog->id, 'url' => null]
    ]" />

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Audit Log Details</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Detailed view of action #{{ $auditLog->id }}</p>
        </div>
        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Logs
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Action Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Action Type</dt>
                        <dd class="mt-1">
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-400">
                                {{ $auditLog->action_label }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Severity</dt>
                        <dd class="mt-1">
                            @php
                                $severityColors = [
                                    'info' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'critical' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                ];
                            @endphp
                            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $severityColors[$auditLog->severity] ?? $severityColors['info'] }}">
                                {{ ucfirst($auditLog->severity) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                        <dd class="mt-1 text-gray-900 dark:text-white">{{ $auditLog->description }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Timestamp</dt>
                        <dd class="mt-1 text-gray-900 dark:text-white">{{ DateHelper::formatDateTimeSeconds($auditLog->created_at) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Time Ago</dt>
                        <dd class="mt-1 text-gray-900 dark:text-white">{{ DateHelper::diffForHumans($auditLog->created_at) }}</dd>
                    </div>
                    @if($auditLog->entity_type)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Entity Type</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white">{{ $auditLog->entity_type }}</dd>
                        </div>
                    @endif
                    @if($auditLog->entity_id)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Entity ID</dt>
                            <dd class="mt-1 font-mono text-gray-900 dark:text-white">{{ $auditLog->entity_id }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            @if($auditLog->old_values || $auditLog->new_values)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Changes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($auditLog->old_values)
                            <div>
                                <h4 class="text-sm font-medium text-red-600 dark:text-red-400 mb-2">Previous Values</h4>
                                <pre class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 text-sm text-red-800 dark:text-red-300 overflow-auto max-h-64">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif
                        @if($auditLog->new_values)
                            <div>
                                <h4 class="text-sm font-medium text-green-600 dark:text-green-400 mb-2">New Values</h4>
                                <pre class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 text-sm text-green-800 dark:text-green-300 overflow-auto max-h-64">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($auditLog->metadata)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Additional Metadata</h3>
                    <pre class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 text-sm text-gray-800 dark:text-gray-300 overflow-auto max-h-64">{{ json_encode($auditLog->metadata, JSON_PRETTY_PRINT) }}</pre>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Admin Information</h3>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                        <span class="text-lg text-indigo-600 dark:text-indigo-400 font-medium">
                            {{ $auditLog->admin_name ? strtoupper(substr($auditLog->admin_name, 0, 1)) : '?' }}
                        </span>
                    </div>
                    <div class="ml-3">
                        <div class="font-medium text-gray-900 dark:text-white">{{ $auditLog->admin_name ?? 'System' }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $auditLog->admin_email }}</div>
                    </div>
                </div>
                @if($auditLog->admin)
                    <a href="{{ route('admin.admin-users.edit', $auditLog->admin) }}" class="btn btn-secondary w-full">
                        View Admin Profile
                    </a>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Request Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">IP Address</dt>
                        <dd class="mt-1 font-mono text-gray-900 dark:text-white">{{ $auditLog->ip_address ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Method</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 text-xs font-medium rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                {{ $auditLog->request_method ?? 'N/A' }}
                            </span>
                        </dd>
                    </div>
                    @if($auditLog->request_url)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">URL</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white break-all">{{ $auditLog->request_url }}</dd>
                        </div>
                    @endif
                    @if($auditLog->user_agent)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">User Agent</dt>
                            <dd class="mt-1 text-xs text-gray-600 dark:text-gray-400 break-all">{{ $auditLog->user_agent }}</dd>
                        </div>
                    @endif
                    @if($auditLog->session_id)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Session ID</dt>
                            <dd class="mt-1 font-mono text-xs text-gray-600 dark:text-gray-400 break-all">{{ $auditLog->session_id }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            @if($relatedLogs->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Related Logs</h3>
                    <div class="space-y-3">
                        @foreach($relatedLogs as $related)
                            <a href="{{ route('admin.audit-logs.show', $related) }}" class="block p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $related->action_label }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ DateHelper::diffForHumans($related->created_at) }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Webhook Logs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Webhook Logs', 'url' => null]
    ]" />

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Webhook Logs</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">View and manage Stripe webhook events with JSON logs</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Events</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Processed</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format($stats['processed']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Failed</p>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ number_format($stats['failed']) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ number_format($stats['pending']) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search event ID, type, customer..." 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <select name="status" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">All Statuses</option>
                    <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Processed</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
                <select name="event_type" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">All Event Types</option>
                    @foreach($eventTypes as $type)
                        <option value="{{ $type }}" {{ request('event_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Processing</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Received</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($webhookEvents as $event)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer" onclick="showEventDetails({{ $event->id }})">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center
                                        @if(str_contains($event->event_type, 'subscription')) bg-purple-100 dark:bg-purple-900/30
                                        @elseif(str_contains($event->event_type, 'invoice')) bg-blue-100 dark:bg-blue-900/30
                                        @elseif(str_contains($event->event_type, 'payment') || str_contains($event->event_type, 'charge')) bg-green-100 dark:bg-green-900/30
                                        @else bg-gray-100 dark:bg-gray-700 @endif">
                                        <svg class="w-5 h-5 
                                            @if(str_contains($event->event_type, 'subscription')) text-purple-600 dark:text-purple-400
                                            @elseif(str_contains($event->event_type, 'invoice')) text-blue-600 dark:text-blue-400
                                            @elseif(str_contains($event->event_type, 'payment') || str_contains($event->event_type, 'charge')) text-green-600 dark:text-green-400
                                            @else text-gray-600 dark:text-gray-400 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white font-mono">{{ Str::limit($event->stripe_event_id, 30) }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $event->object_type ?? 'N/A' }}: {{ Str::limit($event->object_id, 20) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if(str_contains($event->event_type, 'created')) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @elseif(str_contains($event->event_type, 'updated')) bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                    @elseif(str_contains($event->event_type, 'deleted')) bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @elseif(str_contains($event->event_type, 'succeeded')) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @elseif(str_contains($event->event_type, 'failed')) bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ $event->event_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($event->status === 'processed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($event->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @elseif(in_array($event->status, ['pending', 'processing'])) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                @if($event->processing_time_ms)
                                    <span class="font-mono">{{ $event->processing_time_ms }}ms</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <div>{{ $event->created_at ? DateHelper::formatDateTime($event->created_at) : 'N/A' }}</div>
                                <div class="text-xs">{{ $event->created_at ? DateHelper::formatTime($event->created_at, 'g:i:s A') : '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <button onclick="event.stopPropagation(); showJsonModal({{ $event->id }})" 
                                        class="p-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                        title="View JSON">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                        </svg>
                                    </button>
                                    <a href="{{ route('admin.webhook-logs.show', $event) }}" 
                                        onclick="event.stopPropagation()"
                                        class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                                        title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No webhook events</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Webhook events will appear here when Stripe sends them.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($webhookEvents->hasPages())
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $webhookEvents->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<div id="jsonModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" onclick="closeJsonModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white" id="modal-title">Event JSON</h3>
                    <button onclick="closeJsonModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <pre id="jsonContent" class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm font-mono max-h-[60vh] overflow-y-auto"></pre>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="copyJson()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Copy JSON
                </button>
                <button onclick="closeJsonModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentJsonData = null;

function showJsonModal(eventId) {
    fetch(`/admin/webhook-logs/${eventId}/json`)
        .then(response => response.json())
        .then(data => {
            currentJsonData = data;
            document.getElementById('jsonContent').textContent = JSON.stringify(data, null, 2);
            document.getElementById('jsonModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching event:', error);
        });
}

function closeJsonModal() {
    document.getElementById('jsonModal').classList.add('hidden');
}

function copyJson() {
    if (currentJsonData) {
        navigator.clipboard.writeText(JSON.stringify(currentJsonData, null, 2))
            .then(() => {
                alert('JSON copied to clipboard!');
            });
    }
}

function showEventDetails(eventId) {
    window.location.href = `/admin/webhook-logs/${eventId}`;
}
</script>
@endpush
@endsection

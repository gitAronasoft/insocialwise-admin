@extends('admin.layouts.app')

@section('title', 'Webhook Event Details')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('admin.webhook-logs.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Webhook Logs
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Webhook Event</h1>
                <p class="mt-2 text-sm font-mono text-gray-600 dark:text-gray-400">{{ $webhookEvent->stripe_event_id }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                @if($webhookEvent->status === 'processed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                @elseif($webhookEvent->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 @endif">
                {{ ucfirst($webhookEvent->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Event Information</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Event Type</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ $webhookEvent->event_type }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">API Version</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $webhookEvent->api_version ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mode</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $webhookEvent->livemode ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $webhookEvent->livemode ? 'Live' : 'Test' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Object</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            <span class="font-mono">{{ $webhookEvent->object_type }}: {{ $webhookEvent->object_id }}</span>
                        </dd>
                    </div>
                    @if($webhookEvent->customer_id)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $webhookEvent->customer_id }}</dd>
                    </div>
                    @endif
                    @if($webhookEvent->subscription_id)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Subscription</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $webhookEvent->subscription_id }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Processing Details</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Received At</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $webhookEvent->received_at?->format('M d, Y H:i:s') ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Processed At</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $webhookEvent->processed_at?->format('M d, Y H:i:s') ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Processing Time</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $webhookEvent->processing_time_ms ?? 0 }}ms</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Signature Verified</dt>
                        <dd class="mt-1">
                            @if($webhookEvent->signature_verified)
                                <span class="inline-flex items-center text-green-600 dark:text-green-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Verified
                                </span>
                            @else
                                <span class="inline-flex items-center text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Not Verified
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">IP Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $webhookEvent->ip_address ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            @if($webhookEvent->actions_taken && count($webhookEvent->actions_taken) > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions Taken</h3>
                <ul class="space-y-2">
                    @foreach($webhookEvent->actions_taken as $action)
                        <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ str_replace('_', ' ', ucfirst($action)) }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($webhookEvent->error_message)
            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-800 p-6">
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-400 mb-2">Error</h3>
                <p class="text-sm text-red-700 dark:text-red-300">{{ $webhookEvent->error_message }}</p>
            </div>
            @endif
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Event Payload (JSON)</h3>
                    <button onclick="copyPayload()" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Copy
                    </button>
                </div>
                <div class="p-4">
                    <pre id="payloadJson" class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm font-mono max-h-[600px] overflow-y-auto">{{ json_encode($webhookEvent->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Structured Log View</h3>
                </div>
                <div class="p-4">
                    <pre id="structuredLog" class="bg-gray-900 text-cyan-400 p-4 rounded-lg overflow-x-auto text-sm font-mono max-h-[400px] overflow-y-auto">{{ json_encode($webhookEvent->toJsonLog(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyPayload() {
    const payload = document.getElementById('payloadJson').textContent;
    navigator.clipboard.writeText(payload).then(() => {
        alert('Payload copied to clipboard!');
    });
}
</script>
@endpush
@endsection

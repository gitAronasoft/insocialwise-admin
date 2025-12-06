@extends('admin.layouts.app')

@section('title', 'Activity Log Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Activity Log Details</h1>
            <p class="text-sm text-gray-500 mt-1">Log ID: {{ $log->id }}</p>
        </div>
        <a href="{{ route('admin.billing.activity-logs') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Logs
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Log Information</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Action Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $log->action_type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($log->action_status === 'success') bg-green-100 text-green-800
                                @elseif($log->action_status === 'failed') bg-red-100 text-red-800
                                @elseif($log->action_status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">{{ ucfirst($log->action_status) }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Actor Type</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($log->actor_type === 'admin') bg-purple-100 text-purple-800
                                @elseif($log->actor_type === 'system') bg-blue-100 text-blue-800
                                @elseif($log->actor_type === 'stripe') bg-indigo-100 text-indigo-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">{{ ucfirst($log->actor_type) }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Actor Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $log->actor_email ?? '-' }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $log->description }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Timestamp</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $log->created_at?->format('M d, Y H:i:s') }}</dd>
                    </div>
                    @if($log->stripe_event_id)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Stripe Event ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $log->stripe_event_id }}</dd>
                    </div>
                    @endif
                    @if($log->ip_address)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $log->ip_address }}</dd>
                    </div>
                    @endif
                    @if($log->user_agent)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">User Agent</dt>
                        <dd class="mt-1 text-sm text-gray-900 break-all">{{ $log->user_agent }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            @if($log->old_values || $log->new_values)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Changes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($log->old_values)
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Previous Values</h4>
                        <pre class="text-xs bg-red-50 p-4 rounded-lg overflow-auto text-red-800">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif
                    @if($log->new_values)
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">New Values</h4>
                        <pre class="text-xs bg-green-50 p-4 rounded-lg overflow-auto text-green-800">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($log->metadata)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Metadata</h3>
                <pre class="text-xs bg-gray-50 p-4 rounded-lg overflow-auto">{{ json_encode($log->metadata, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($log->error_message)
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <h3 class="text-lg font-medium text-red-800 mb-2">Error Details</h3>
                <p class="text-sm text-red-700">{{ $log->error_message }}</p>
                @if($log->error_code)
                    <p class="text-xs text-red-600 mt-2">Error Code: {{ $log->error_code }}</p>
                @endif
            </div>
            @endif
        </div>

        <div class="space-y-6">
            @if($log->customer)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Customer</h3>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-medium">{{ strtoupper(substr($log->customer->name ?? 'U', 0, 1)) }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $log->customer->name }}</p>
                        <p class="text-xs text-gray-500">{{ $log->customer->email }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.customers.show', $log->customer) }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-800">
                    View Customer &rarr;
                </a>
            </div>
            @endif

            @if($log->subscription)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Related Subscription</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Plan</span>
                        <span class="text-gray-900">{{ $log->subscription->planName ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $log->subscription->status }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.subscriptions.show', $log->subscription) }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-800">
                    View Subscription &rarr;
                </a>
            </div>
            @endif

            @if($log->transaction)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Related Transaction</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Amount</span>
                        <span class="text-gray-900 font-medium">${{ number_format($log->transaction->amount / 100, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($log->transaction->status === 'succeeded') bg-green-100 text-green-800
                            @elseif($log->transaction->status === 'failed') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif
                        ">{{ ucfirst($log->transaction->status) }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

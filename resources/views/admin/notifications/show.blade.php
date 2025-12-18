@extends('admin.layouts.app')

@section('title', 'Notification Details')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Notifications', 'url' => route('admin.notifications.index')], ['label' => 'View Details', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notification Details</h1>
            <p class="text-sm text-gray-500 mt-1">ID: {{ $notification->id }}</p>
        </div>
        <div class="flex space-x-2">
            @if(in_array($notification->status, ['failed', 'canceled']))
                <form action="{{ route('admin.notifications.retry', $notification) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        Retry
                    </button>
                </form>
            @endif
            @if($notification->status === 'pending')
                <form action="{{ route('admin.notifications.cancel', $notification) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this notification?')">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Cancel
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.notifications.index') }}" class="text-indigo-600 hover:text-indigo-800 px-4 py-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Information</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $notification->notification_type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Channel</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($notification->channel === 'email') bg-blue-100 text-blue-800
                                @elseif($notification->channel === 'sms') bg-green-100 text-green-800
                                @elseif($notification->channel === 'push') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">{{ ucfirst($notification->channel) }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Priority</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($notification->priority === 'urgent') bg-red-100 text-red-800
                                @elseif($notification->priority === 'high') bg-orange-100 text-orange-800
                                @elseif($notification->priority === 'normal') bg-gray-100 text-gray-800
                                @else bg-gray-50 text-gray-600
                                @endif
                            ">{{ ucfirst($notification->priority) }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($notification->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($notification->status === 'queued') bg-blue-100 text-blue-800
                                @elseif($notification->status === 'sent') bg-green-100 text-green-800
                                @elseif($notification->status === 'delivered') bg-green-100 text-green-800
                                @elseif($notification->status === 'failed') bg-red-100 text-red-800
                                @elseif($notification->status === 'canceled') bg-gray-100 text-gray-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">{{ ucfirst($notification->status) }}</span>
                        </dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Subject</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $notification->subject }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Recipient Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $notification->recipient_email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Recipient Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $notification->recipient_name ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            @if($notification->body_html || $notification->body_text)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Content</h3>
                @if($notification->body_html)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">HTML Body</h4>
                        <div class="prose prose-sm max-w-none">
                            {!! $notification->body_html !!}
                        </div>
                    </div>
                @endif
                @if($notification->body_text)
                    <div class="mt-4 border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Plain Text Body</h4>
                        <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $notification->body_text }}</pre>
                    </div>
                @endif
            </div>
            @endif

            @if($notification->last_error)
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <h3 class="text-lg font-medium text-red-800 mb-2">Error Details</h3>
                <p class="text-sm text-red-700">{{ $notification->last_error }}</p>
                <p class="text-xs text-red-600 mt-2">Retry attempts: {{ $notification->retry_count }}/3</p>
            </div>
            @endif

            @if($notification->metadata)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Metadata</h3>
                <pre class="text-xs bg-gray-50 p-4 rounded-lg overflow-auto">{{ json_encode($notification->metadata, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Timeline</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Created</p>
                            <p class="text-xs text-gray-500">{{ $notification->created_at?->format('M d, Y H:i:s') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Scheduled</p>
                            <p class="text-xs text-gray-500">{{ $notification->scheduled_at?->format('M d, Y H:i:s') ?? 'Not scheduled' }}</p>
                        </div>
                    </div>
                    @if($notification->sent_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Sent</p>
                            <p class="text-xs text-gray-500">{{ $notification->sent_at->format('M d, Y H:i:s') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($notification->delivered_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Delivered</p>
                            <p class="text-xs text-gray-500">{{ $notification->delivered_at->format('M d, Y H:i:s') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($notification->opened_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Opened</p>
                            <p class="text-xs text-gray-500">{{ $notification->opened_at->format('M d, Y H:i:s') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($notification->customer)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Customer</h3>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-medium">{{ strtoupper(substr($notification->customer->name ?? 'U', 0, 1)) }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $notification->customer->name }}</p>
                        <p class="text-xs text-gray-500">{{ $notification->customer->email }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.customers.show', $notification->customer) }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-800">
                    View Customer &rarr;
                </a>
            </div>
            @endif

            @if($notification->subscription)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Related Subscription</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Plan</span>
                        <span class="text-gray-900">{{ $notification->subscription->plan->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $notification->subscription->status }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.subscriptions.show', $notification->subscription) }}" class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-800">
                    View Subscription &rarr;
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

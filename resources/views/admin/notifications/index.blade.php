@extends('admin.layouts.app')

@section('title', 'Notification Queue')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Notifications', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notification Queue</h1>
            <p class="text-sm text-gray-500 mt-1">Manage billing and subscription notifications</p>
        </div>
        <div class="flex space-x-2">
            <form action="{{ route('admin.notifications.run-now') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Process Queue
                </button>
            </form>
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

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Total</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
            @if($stats['due_now'] > 0)
                <p class="text-xs text-yellow-600">{{ $stats['due_now'] }} due now</p>
            @endif
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Sent Today</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['sent_today'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Delivered</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['delivered'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Failed</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['failed'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.notifications.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by email or subject..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="type" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Types</option>
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="channel" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Channels</option>
                    @foreach($channels as $channel)
                        <option value="{{ $channel }}" {{ request('channel') === $channel ? 'selected' : '' }}>{{ ucfirst($channel) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Filter</button>
            <a href="{{ route('admin.notifications.index') }}" class="text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100">Reset</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recipient</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Channel</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scheduled</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <input type="checkbox" name="ids[]" value="{{ $notification->id }}" class="notification-checkbox rounded border-gray-300">
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-xs font-medium text-gray-700">
                                    {{ $types[$notification->notification_type] ?? $notification->notification_type }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div>
                                    <p class="text-gray-900">{{ $notification->recipient_email }}</p>
                                    @if($notification->customer)
                                        <p class="text-xs text-gray-500">{{ $notification->customer->name }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 text-gray-700 max-w-xs truncate">
                                {{ Str::limit($notification->subject, 40) }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($notification->channel === 'email') bg-blue-100 text-blue-800
                                    @elseif($notification->channel === 'sms') bg-green-100 text-green-800
                                    @elseif($notification->channel === 'push') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ ucfirst($notification->channel) }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($notification->priority === 'urgent') bg-red-100 text-red-800
                                    @elseif($notification->priority === 'high') bg-orange-100 text-orange-800
                                    @elseif($notification->priority === 'normal') bg-gray-100 text-gray-800
                                    @else bg-gray-50 text-gray-600
                                    @endif
                                ">{{ ucfirst($notification->priority) }}</span>
                            </td>
                            <td class="px-4 py-4">
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
                                @if($notification->retry_count > 0)
                                    <span class="text-xs text-gray-500 ml-1">({{ $notification->retry_count }} retries)</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-gray-600 text-xs">
                                {{ $notification->scheduled_at?->formatDateTime() ?? '-' }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.notifications.show', $notification) }}" class="text-indigo-600 hover:text-indigo-800 text-xs">View</a>
                                    @if(in_array($notification->status, ['failed', 'canceled']))
                                        <form action="{{ route('admin.notifications.retry', $notification) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-xs">Retry</button>
                                        </form>
                                    @endif
                                    @if($notification->status === 'pending')
                                        <form action="{{ route('admin.notifications.cancel', $notification) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this notification?')">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Cancel</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                No notifications found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($notifications->hasPages())
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">By Type</h3>
            <div class="space-y-2">
                @forelse($stats['by_type'] as $type => $count)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ $types[$type] ?? $type }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $count }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No data available</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">By Channel</h3>
            <div class="space-y-2">
                @forelse($stats['by_channel'] as $channel => $count)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ ucfirst($channel) }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $count }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No data available</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.notification-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>
@endsection

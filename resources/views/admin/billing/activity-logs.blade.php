@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Billing Activity Logs')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Billing', 'url' => null], ['label' => 'Activity Logs', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Billing Activity Logs</h1>
            <p class="text-sm text-gray-500 mt-1">Track all billing-related events and actions</p>
        </div>
        <a href="{{ route('admin.billing.overview') }}" class="text-indigo-600 hover:text-indigo-800">
            View Overview &rarr;
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Total Logs</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Today</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['today'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">This Week</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $stats['this_week'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Success</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['success'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Failed</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['failed'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.billing.activity-logs') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search logs..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <select name="action_type" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Types</option>
                    @foreach($actionTypes as $key => $label)
                        <option value="{{ $key }}" {{ request('action_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="action_status" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('action_status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="actor_type" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Actors</option>
                    @foreach($actorTypes as $actor)
                        <option value="{{ $actor }}" {{ request('actor_type') === $actor ? 'selected' : '' }}>{{ ucfirst($actor) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="From">
            </div>
            <div>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="To">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Filter</button>
            <a href="{{ route('admin.billing.activity-logs') }}" class="text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100">Reset</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-4 text-xs text-gray-500 whitespace-nowrap">
                                {{ DateHelper::formatDateTimeSeconds($log->created_at) }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-xs font-medium text-gray-700">
                                    {{ $actionTypes[$log->action_type] ?? $log->action_type }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-700 max-w-xs truncate">
                                {{ Str::limit($log->description, 50) }}
                            </td>
                            <td class="px-4 py-4">
                                @if($log->customer)
                                    <a href="{{ route('admin.customers.show', $log->customer) }}" class="text-indigo-600 hover:text-indigo-800">
                                        {{ $log->customer->name ?? $log->customer->email }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($log->actor_type === 'admin') bg-purple-100 text-purple-800
                                    @elseif($log->actor_type === 'system') bg-blue-100 text-blue-800
                                    @elseif($log->actor_type === 'stripe') bg-indigo-100 text-indigo-800
                                    @elseif($log->actor_type === 'user') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ ucfirst($log->actor_type) }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($log->action_status === 'success') bg-green-100 text-green-800
                                    @elseif($log->action_status === 'failed') bg-red-100 text-red-800
                                    @elseif($log->action_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ ucfirst($log->action_status) }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <a href="{{ route('admin.billing.show-log', $log) }}" class="text-indigo-600 hover:text-indigo-800 text-xs">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

    @if(!empty($stats['by_type']))
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Top Activity Types</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach($stats['by_type'] as $type => $count)
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-indigo-600">{{ $count }}</p>
                    <p class="text-xs text-gray-500">{{ $actionTypes[$type] ?? $type }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

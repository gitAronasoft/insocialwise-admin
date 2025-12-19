@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Activity Details')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Activities', 'url' => route('admin.activities.index')], ['label' => 'View Details', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Activity Details</h3>
        <a href="{{ route('admin.activities.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Back to Activities</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Customer</h4>
                <p class="text-gray-900 dark:text-white">{{ $activity->customer->firstName ?? 'N/A' }} {{ $activity->customer->lastName ?? '' }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $activity->customer->email ?? '' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Timestamp</h4>
                <p class="text-gray-900 dark: ? DateHelper::formatDateTimeSeconds(text-white">{{ $activity->created_at ? $activity->created_at) : 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Activity Type</h4>
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                    {{ $activity->activity_type }}
                </span>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Activity Subtype</h4>
                <p class="text-gray-900 dark:text-white">{{ $activity->activity_subType ?? 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Action</h4>
                <p class="text-gray-900 dark:text-white">{{ $activity->action }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Platform</h4>
                <p class="text-gray-900 dark:text-white">{{ $activity->account_platform ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    @if($activity->activity_data)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Activity Data</h4>
        <pre class="bg-gray-50 dark:bg-gray-700 dark:text-gray-200 p-4 rounded-lg overflow-x-auto text-sm">{{ json_encode(json_decode($activity->activity_data), JSON_PRETTY_PRINT) }}</pre>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Information</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Account ID</h4>
                <p class="text-gray-900 dark:text-white font-mono">{{ $activity->account_id ?? 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Page ID</h4>
                <p class="text-gray-900 dark:text-white font-mono">{{ $activity->page_id ?? 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">User UUID</h4>
                <p class="text-gray-900 dark:text-white font-mono text-xs">{{ $activity->user_uuid }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Activity ID</h4>
                <p class="text-gray-900 dark:text-white font-mono">{{ $activity->id }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

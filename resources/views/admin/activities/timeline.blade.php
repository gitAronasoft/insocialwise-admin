@extends('admin.layouts.app')

@section('title', 'Activity Timeline')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Activities', 'url' => route('admin.activities.index')],
        ['label' => 'Timeline', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Activity Timeline</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Visual changelog of all system activities</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.activities.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Table View
            </a>
            <a href="{{ route('admin.activities.stats') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                View Stats
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.activities.timeline') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user..." 
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <select name="activity_type" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Types</option>
                    @foreach($activityTypes as $type)
                        <option value="{{ $type }}" {{ request('activity_type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="action" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Filter</button>
            <a href="{{ route('admin.activities.timeline') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">Reset</a>
        </form>

        <div class="relative">
            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500"></div>

            <div class="space-y-6">
                @php $currentDate = null; @endphp
                @forelse($activities as $activity)
                    @php 
                        $activityDate = $activity->created_at->format('Y-m-d');
                        $showDateHeader = $activityDate !== $currentDate;
                        $currentDate = $activityDate;
                    @endphp

                    @if($showDateHeader)
                        <div class="relative flex items-center py-4">
                            <div class="absolute left-6 w-4 h-4 bg-white dark:bg-gray-800 border-4 border-indigo-500 rounded-full z-10"></div>
                            <div class="ml-16 px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-full text-sm font-semibold">
                                {{ $activity->created_at->format('F d, Y') }}
                                @if($activity->created_at->isToday())
                                    <span class="ml-2 text-xs text-indigo-500">(Today)</span>
                                @elseif($activity->created_at->isYesterday())
                                    <span class="ml-2 text-xs text-indigo-500">(Yesterday)</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="relative flex items-start group">
                        <div class="absolute left-6 w-4 h-4 mt-1.5 rounded-full z-10 transition-all group-hover:scale-125
                            @switch($activity->activity_type)
                                @case('post')
                                    bg-blue-500
                                    @break
                                @case('subscription')
                                    bg-green-500
                                    @break
                                @case('payment')
                                    bg-emerald-500
                                    @break
                                @case('social')
                                    bg-purple-500
                                    @break
                                @case('auth')
                                    bg-amber-500
                                    @break
                                @default
                                    bg-gray-500
                            @endswitch
                        "></div>

                        <div class="ml-16 flex-1 bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 hover:shadow-md transition-shadow group-hover:bg-white dark:group-hover:bg-gray-700">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @switch($activity->activity_type)
                                                @case('post')
                                                    bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                                    @break
                                                @case('subscription')
                                                    bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                                    @break
                                                @case('payment')
                                                    bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                                    @break
                                                @case('social')
                                                    bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400
                                                    @break
                                                @case('auth')
                                                    bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                                    @break
                                                @default
                                                    bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-300
                                            @endswitch
                                        ">{{ ucfirst($activity->activity_type) }}</span>
                                        @if($activity->activity_subType)
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->activity_subType }}</span>
                                        @endif
                                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $activity->created_at->format('H:i:s') }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($activity->customer->firstname ?? 'U', 0, 1)) }}{{ strtoupper(substr($activity->customer->lastname ?? 'N', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity->customer->firstname ?? 'Unknown' }} {{ $activity->customer->lastname ?? 'User' }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->customer->email ?? '' }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 text-xs font-medium rounded bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300">
                                                {{ $activity->action }}
                                            </span>
                                            @if($activity->account_platform)
                                                <span class="px-2 py-0.5 text-xs font-medium rounded bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400">
                                                    {{ $activity->account_platform }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($activity->source_type)
                                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                Source: {{ $activity->source_type }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="ml-4">
                                    <a href="{{ route('admin.activities.show', $activity) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ml-16 p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">No activities found matching your criteria</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection

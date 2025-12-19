@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')
@section('title', 'Connected Pages')
@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Pages', 'url' => null]
    ]" />
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Connected Pages</h1>
        <p class="mt-1 text-gray-600 dark:text-gray-400">Manage all social media pages connected through InSocialWise</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Total Pages</p>
            <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Facebook</p>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['facebook'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Instagram</p>
            <p class="text-3xl font-bold text-pink-600">{{ $stats['instagram'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">LinkedIn</p>
            <p class="text-3xl font-bold text-blue-700">{{ $stats['linkedin'] }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Page Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Platform</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Owner</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Connected</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($pages ?? [] as $page)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            @if($page->picture || $page->page_picture)
                                <img src="{{ $page->picture ?? $page->page_picture }}" alt="{{ $page->pagename }}" class="w-8 h-8 rounded-full">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($page->pagename ?? 'P', 0, 1)) }}
                                </div>
                            @endif
                            <span class="font-medium">{{ $page->pagename ?? $page->name ?? 'Unnamed Page' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-1 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">{{ ucfirst($page->platform ?? $page->page_platform ?? 'Unknown') }}</span></td>
                    <td class="px-6 py-4">
                        @if($page->socialUser && $page->socialUser->customer)
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($page->socialUser->customer->firstName ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $page->socialUser->customer->firstName ?? '' }} {{ $page->socialUser->customer->lastName ?? '' }}</span>
                            </div>
                        @elseif($page->socialUser)
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $page->socialUser->name ?? 'Unknown User' }}</span>
                        @else
                            <span class="text-gray-500 dark:text-gray-400">?</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($page->created_at)
                            <div>{{ DateHelper::formatDateTime($page->created_at) }}</div>
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.pages.show', $page) }}" class="text-primary-600 hover:underline text-sm font-medium">View</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No pages connected yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

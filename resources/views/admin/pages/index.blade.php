@extends('admin.layouts.app')
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
                    <td class="px-6 py-4">{{ $page->page_name }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 rounded text-xs bg-primary-100">{{ ucfirst($page->platform) }}</span></td>
                    <td class="px-6 py-4">{{ optional($page->socialUser)->customer ? optional($page->socialUser->customer)->firstName : 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $page->created_at ? $page->created_at->format('M d, Y') : 'N/A' }}</td>
                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.pages.show', $page) }}" class="text-primary-600 hover:underline text-sm">View</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No pages connected yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

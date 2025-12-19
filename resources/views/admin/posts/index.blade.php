@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Posts')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Posts', 'url' => null]
    ]" />
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Posts</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Published</p>
            <p class="text-3xl font-bold text-green-600">{{ number_format($stats['published']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Scheduled</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['scheduled']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Draft</p>
            <p class="text-3xl font-bold text-gray-600">{{ number_format($stats['draft']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Published</option>
                    <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Scheduled</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div>
                <select name="platform" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Platforms</option>
                    <option value="facebook" {{ request('platform') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="linkedin" {{ request('platform') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Search</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Engagement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($posts as $post)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($post->content, 50) }}</div>
                                @if($post->post_media)
                                    <span class="text-xs text-gray-500">Has Media</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $post->customer->firstName ?? 'N/A' }} {{ $post->customer->lastName ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($post->post_platform === 'facebook') bg-blue-100 text-blue-800
                                    @else bg-indigo-100 text-indigo-800
                                    @endif
                                ">{{ ucfirst($post->post_platform) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($post->status == 1) bg-green-100 text-green-800
                                    @elseif($post->status == 2) bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ $post->status_label }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-2">
                                    <span title="Likes">{{ $post->likes ?? 0 }}</span>
                                    <span title="Comments">{{ $post->comments ?? 0 }}</span>
                                    <span title="Shares">{{ $post->shares ?? 0 }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $post->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.posts.show', $post) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No posts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection

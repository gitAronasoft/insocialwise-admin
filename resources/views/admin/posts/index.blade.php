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
                                @if($post->post_media)
                                    @php
                                        // Parse media URL safely
                                        $mediaUrl = null;
                                        if (is_string($post->post_media)) {
                                            $decoded = json_decode($post->post_media, true);
                                            if (is_array($decoded) && isset($decoded[0]) && is_string($decoded[0])) {
                                                $mediaUrl = $decoded[0];
                                            } else {
                                                $mediaUrl = $post->post_media;
                                            }
                                        } else if (is_array($post->post_media) && isset($post->post_media[0])) {
                                            $mediaUrl = $post->post_media[0];
                                        }
                                    @endphp
                                    @if($mediaUrl && is_string($mediaUrl))
                                        <div class="flex items-center gap-3">
                                            @if(Str::contains($mediaUrl, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                                <img src="{{ $mediaUrl }}" alt="Post media" class="w-12 h-12 rounded object-cover">
                                            @elseif(Str::contains($mediaUrl, ['.mp4', '.mov', '.avi', '.webm']))
                                                <div class="w-12 h-12 rounded bg-gray-300 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-12 h-12 rounded bg-blue-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($post->content, 40) }}</div>
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($post->content, 50) }}</div>
                                    @endif
                                @else
                                    <div class="text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($post->content, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $post->customer->firstname ?? 'N/A' }} {{ $post->customer->lastname ?? '' }}
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

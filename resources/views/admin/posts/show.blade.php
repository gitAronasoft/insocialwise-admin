@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Post Details')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Posts', 'url' => route('admin.posts.index')], ['label' => 'View Details', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Post Details</h3>
        <a href="{{ route('admin.posts.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Posts</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Customer</h4>
                <p class="text-gray-900">{{ $post->customer->firstname ?? 'N/A' }} {{ $post->customer->lastname ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $post->customer->email ?? '' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Page</h4>
                <p class="text-gray-900">{{ $post->page->pagename ?? $post->page->name ?? 'N/A' }}</p>
                <p class="text-sm text-gray-500">{{ $post->page->platform ?? $post->page->page_platform ?? '' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Platform</h4>
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    @if($post->post_platform === 'facebook') bg-blue-100 text-blue-800
                    @else bg-indigo-100 text-indigo-800
                    @endif
                ">{{ ucfirst($post->post_platform) }}</span>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Status</h4>
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    @if($post->status == 1) bg-green-100 text-green-800
                    @elseif($post->status == 2) bg-blue-100 text-blue-800
                    @else bg-gray-100 text-gray-800
                    @endif
                ">{{ $post->status_label }}</span>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Created</h4>
                <p class="text-gray-900">{{ $post->created_at ? DateHelper::formatDateTime($post->created_at) : 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Scheduled Time</h4>
                <p class="text-gray-900">{{ $post->schedule_time ? date('M d, Y H:i', $post->schedule_time) : 'Not scheduled' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="text-sm font-medium text-gray-500 mb-4">Content</h4>
        <div class="prose max-w-none">
            @if($post->content)
                <p class="text-gray-900 whitespace-pre-wrap">{{ $post->content }}</p>
            @else
                <p class="text-gray-500">No content</p>
            @endif
        </div>
        @if($post->post_media)
            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-500 mb-4">Media</h4>
                @php
                    // Try to parse as JSON first
                    $mediaData = null;
                    if (is_string($post->post_media)) {
                        $decoded = json_decode($post->post_media, true);
                        // If json_decode returns an array, use it; otherwise treat as direct URL
                        $mediaData = is_array($decoded) ? $decoded : $post->post_media;
                    } else {
                        $mediaData = $post->post_media;
                    }
                    // Ensure we have an array
                    $mediaArray = is_array($mediaData) ? $mediaData : [$mediaData];
                    // Filter out empty values
                    $mediaArray = array_filter($mediaArray);
                @endphp
                @if(count($mediaArray) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($mediaArray as $mediaUrl)
                            @if($mediaUrl && is_string($mediaUrl))
                                @if(Str::contains($mediaUrl, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                    <img src="{{ $mediaUrl }}" alt="Post media" class="rounded-lg max-w-full h-auto shadow-md">
                                @elseif(Str::contains($mediaUrl, ['.mp4', '.mov', '.avi', '.webm']))
                                    <video src="{{ $mediaUrl }}" controls class="rounded-lg max-w-full h-auto shadow-md"></video>
                                @else
                                    <a href="{{ $mediaUrl }}" target="_blank" class="inline-block p-4 bg-blue-50 rounded-lg text-blue-600 hover:text-blue-800 hover:bg-blue-100 underline">View Media</a>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500">No valid media found</p>
                    </div>
                @endif
            </div>
        @else
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500">No media attached</p>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-medium text-gray-900 mb-4">Engagement</h4>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-gray-900">{{ number_format($post->impressions ?? 0) }}</p>
                <p class="text-sm text-gray-500">Impressions</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-gray-900">{{ number_format($post->unique_impressions ?? 0) }}</p>
                <p class="text-sm text-gray-500">Reach</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">{{ number_format($post->likes ?? 0) }}</p>
                <p class="text-sm text-gray-500">Likes</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-green-600">{{ number_format($post->comments ?? 0) }}</p>
                <p class="text-sm text-gray-500">Comments</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-purple-600">{{ number_format($post->shares ?? 0) }}</p>
                <p class="text-sm text-gray-500">Shares</p>
            </div>
        </div>
    </div>

    @if($post->comments && $post->comments->count() > 0)
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-medium text-gray-900 mb-4">Post Comments ({{ $post->comments->count() }})</h4>
        <div class="space-y-4">
            @foreach($post->comments as $comment)
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-900">{{ $comment->commenter_name ?? 'Anonymous' }}</p>
                            <p class="text-gray-600 mt-1">{{ $comment->comment }}</p>
                        </div>
                        <span class="text-xs text-gray-500">{{ $comment->created_at ? DateHelper::formatDateTime($comment->created_at) : '' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

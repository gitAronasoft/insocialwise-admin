@extends('admin.layouts.app')

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
                <p class="text-gray-900">{{ $post->customer->firstName ?? 'N/A' }} {{ $post->customer->lastName ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $post->customer->email ?? '' }}</p>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-500 mb-2">Page</h4>
                <p class="text-gray-900">{{ $post->page->page_name ?? 'N/A' }}</p>
                <p class="text-sm text-gray-500">{{ $post->page->page_platform ?? '' }}</p>
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
                <p class="text-gray-900">{{ $post->created_at ? $post->created_at->format('M d, Y H:i') : 'N/A' }}</p>
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
            <p class="text-gray-900 whitespace-pre-wrap">{{ $post->content ?? 'No content' }}</p>
        </div>
        @if($post->post_media)
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-500 mb-2">Media</h4>
                @php
                    $mediaData = is_string($post->post_media) ? json_decode($post->post_media, true) : $post->post_media;
                    $mediaUrl = is_array($mediaData) ? ($mediaData[0] ?? null) : $mediaData;
                @endphp
                @if($mediaUrl)
                    @if(Str::contains($mediaUrl, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                        <img src="{{ $mediaUrl }}" alt="Post media" class="max-w-md rounded-lg">
                    @elseif(Str::contains($mediaUrl, ['.mp4', '.mov', '.avi', '.webm']))
                        <video src="{{ $mediaUrl }}" controls class="max-w-md rounded-lg"></video>
                    @else
                        <a href="{{ $mediaUrl }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">View Media</a>
                    @endif
                @endif
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
                        <span class="text-xs text-gray-500">{{ $comment->created_at ? $comment->created_at->format('M d, Y H:i') : '' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Posts</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_posts']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Impressions</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_impressions']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Reach</p>
            <p class="text-3xl font-bold text-green-600">{{ number_format($stats['total_reach']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Engagement</p>
            <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['total_engagement']) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Posts by Platform</h3>
            <div class="space-y-4">
                @foreach($platformBreakdown as $platform)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="w-3 h-3 rounded-full 
                                @if($platform->platform === 'facebook') bg-blue-500
                                @else bg-indigo-500
                                @endif
                            "></span>
                            <span class="font-medium text-gray-700 capitalize">{{ $platform->platform }}</span>
                        </div>
                        <span class="text-gray-900 font-semibold">{{ number_format($platform->count) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.analytics.scores') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <span class="font-medium text-gray-900">Social Media Scores</span>
                    <p class="text-sm text-gray-500">View user social media scores</p>
                </a>
                <a href="{{ route('admin.analytics.page-scores') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <span class="font-medium text-gray-900">Page Scores</span>
                    <p class="text-sm text-gray-500">View individual page scores</p>
                </a>
                <a href="{{ route('admin.analytics.demographics') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <span class="font-medium text-gray-900">Demographics</span>
                    <p class="text-sm text-gray-500">View audience demographics</p>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Performing Posts</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Likes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Shares</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reach</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topPosts as $post)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">{{ Str::limit($post->message, 40) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $post->customer->firstName ?? 'N/A' }} {{ $post->customer->lastName ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($post->platform === 'facebook') bg-blue-100 text-blue-800
                                    @else bg-indigo-100 text-indigo-800
                                    @endif
                                ">{{ ucfirst($post->platform) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($post->likes_count ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($post->comments_count ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($post->shares_count ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($post->reach ?? 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No posts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

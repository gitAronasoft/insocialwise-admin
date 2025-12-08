@extends('admin.layouts.app')

@section('title', 'Post Comments')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Posts', 'url' => null], ['label' => 'Comments', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 flex-1 mr-4">
            <div class="bg-white rounded-xl shadow-sm p-4">
                <p class="text-sm font-medium text-gray-500">Total Comments</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <p class="text-sm font-medium text-gray-500">Facebook</p>
                <p class="text-2xl font-bold text-blue-600">{{ $stats['facebook'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <p class="text-sm font-medium text-gray-500">Instagram</p>
                <p class="text-2xl font-bold text-purple-600">{{ $stats['instagram'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <p class="text-sm font-medium text-gray-500">LinkedIn</p>
                <p class="text-2xl font-bold text-blue-700">{{ $stats['linkedin'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.comments.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search comments..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <select name="platform" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Platforms</option>
                    <option value="facebook" {{ request('platform') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="instagram" {{ request('platform') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="linkedin" {{ request('platform') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Search</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Post</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                {{ Str::limit($comment->post->content ?? 'N/A', 50) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-sm">
                                {{ Str::limit($comment->comment, 80) }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($comment->platform === 'facebook') bg-blue-100 text-blue-800
                                    @elseif($comment->platform === 'instagram') bg-purple-100 text-purple-800
                                    @else bg-indigo-100 text-indigo-800
                                    @endif
                                ">{{ ucfirst($comment->platform ?? 'Unknown') }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $comment->external_author_name ?? 'Anonymous' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $comment->createdAt ? $comment->createdAt->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No comments found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($comments->hasPages())
        <div class="mt-4">
            {{ $comments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Knowledge Base')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 flex-1 mr-4">
            <div class="bg-white rounded-xl shadow-sm p-4">
                <p class="text-sm font-medium text-gray-500">Total Articles</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <p class="text-sm font-medium text-gray-500">Published</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['published'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <p class="text-sm font-medium text-gray-500">Drafts</p>
                <p class="text-2xl font-bold text-gray-600">{{ $stats['draft'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4">
                <p class="text-sm font-medium text-gray-500">Total Views</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_views']) }}</p>
            </div>
        </div>
        <a href="{{ route('admin.knowledge-base.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 whitespace-nowrap">New Article</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.knowledge-base.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            @if($categories && count($categories) > 0)
            <div>
                <select name="category" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div>
                <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Search</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Helpful Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($articles as $article)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($article->title, 50) }}</div>
                                <div class="text-sm text-gray-500">{{ $article->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $article->category }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($article->status === 'published') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ ucfirst($article->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($article->views_count ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $article->helpful_rate }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $article->createdAt->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.knowledge-base.show', $article) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="{{ route('admin.knowledge-base.edit', $article) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('admin.knowledge-base.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No articles found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection

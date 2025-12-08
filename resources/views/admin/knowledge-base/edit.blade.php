@extends('admin.layouts.app')

@section('title', 'Edit Article')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Knowledge Base', 'url' => route('admin.knowledge-base.index')], ['label' => 'Edit', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Edit Article</h3>
        <a href="{{ route('admin.knowledge-base.index') }}" class="text-indigo-600 hover:text-indigo-900">Back</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.knowledge-base.update', $knowledgeBase) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Title</label>
                <input type="text" name="title" value="{{ $knowledgeBase->knowledgeBase_title }}" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('title')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900 mb-2">Content</label>
                <textarea name="content" rows="10" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $knowledgeBase->knowledgeBase_content }}</textarea>
                @error('content')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Category</label>
                    <input type="text" name="category" value="{{ old('category', '') }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('category')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Status</label>
                    <select name="status" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="draft" {{ $knowledgeBase->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $knowledgeBase->status === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Meta Description</label>
                    <input type="text" name="meta_description" value="{{ $knowledgeBase->meta->where('meta_key', 'description')->first()?->meta_value ?? '' }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ $knowledgeBase->meta->where('meta_key', 'keywords')->first()?->meta_value ?? '' }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex space-x-3 pt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Update Article</button>
                <a href="{{ route('admin.knowledge-base.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

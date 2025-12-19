@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Article - ' . $knowledgeBase->knowledgeBase_title)

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Knowledge Base', 'url' => route('admin.knowledge-base.index')], ['label' => 'View Details', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">{{ $knowledgeBase->knowledgeBase_title }}</h3>
        <div class="flex space-x-2">
            <a href="{{ route('admin.knowledge-base.edit', $knowledgeBase) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Edit</a>
            <a href="{{ route('admin.knowledge-base.index') }}" class="text-indigo-600 hover:text-indigo-900">Back</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div>
                <p class="text-sm font-medium text-gray-500">Status</p>
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    @if($knowledgeBase->status === 'published') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif
                ">{{ ucfirst($knowledgeBase->status) }}</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Slug</p>
                <p class="text-sm text-gray-900 font-mono">{{ $knowledgeBase->slug }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Created</p>
                <p class="text-sm text-gray-900">{{ DateHelper::formatDateTime($knowledgeBase->created_at) }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Updated</p>
                <p class="text-sm text-gray-900">{{ DateHelper::formatDateTime($knowledgeBase->updated_at) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Content</h4>
        <div class="prose max-w-none">
            {!! $knowledgeBase->knowledgeBase_content !!}
        </div>
    </div>

    @if($knowledgeBase->meta && count($knowledgeBase->meta) > 0)
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">SEO Metadata</h4>
        <div class="space-y-4">
            @foreach($knowledgeBase->meta as $metaData)
                <div class="border-b border-gray-200 pb-4 last:border-b-0">
                    <p class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $metaData->meta_key)) }}</p>
                    <p class="text-sm text-gray-600">{{ $metaData->meta_value }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

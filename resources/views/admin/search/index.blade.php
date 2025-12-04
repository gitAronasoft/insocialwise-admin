@extends('admin.layouts.app')
@section('title', 'Global Search')
@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Global Search</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Search across all customers, posts, transactions, and more</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach(['customers' => 'Customers', 'posts' => 'Posts', 'transactions' => 'Transactions', 'campaigns' => 'Campaigns'] as $key => $label)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $label }}</p>
            <p class="text-2xl font-bold">{{ count($results[$key] ?? []) }}</p>
        </div>
        @endforeach
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-4">Search Results for "{{ $query }}"</h2>
        @if(empty(array_filter($results)))
            <p class="text-gray-500">No results found</p>
        @else
            <div class="space-y-3">
                @foreach(['customers', 'posts', 'transactions'] as $category)
                    @if(!empty($results[$category]))
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ ucfirst($category) }}</h3>
                        <ul class="space-y-1">
                            @foreach($results[$category] as $item)
                            <li><a href="{{ $item['url'] }}" class="text-primary-600 hover:underline">{{ $item['title'] ?? $item['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

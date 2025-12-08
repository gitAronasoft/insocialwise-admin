@extends('admin.layouts.app')

@section('title', 'Inbox')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Inbox', 'url' => null]
    ]" />
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Conversations</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">With Unread</p>
            <p class="text-3xl font-bold text-red-600">{{ number_format($stats['with_unread']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Total Messages</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_messages']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500">Messages Today</p>
            <p class="text-3xl font-bold text-green-600">{{ number_format($stats['messages_today']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.inbox.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search conversations..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Search</button>
        </form>

        <div class="divide-y divide-gray-200">
            @forelse($conversations as $conversation)
                <div class="py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                            @if($conversation->participant_picture)
                                <img src="{{ $conversation->participant_picture }}" alt="" class="w-12 h-12 rounded-full">
                            @else
                                <span class="text-gray-500 font-medium">{{ strtoupper(substr($conversation->participant_name ?? 'U', 0, 1)) }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <p class="font-medium text-gray-900">{{ $conversation->participant_name ?? 'Unknown' }}</p>
                                @if($conversation->unread_count > 0)
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800">{{ $conversation->unread_count }} unread</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500">{{ Str::limit($conversation->snippet, 50) }}</p>
                            <p class="text-xs text-gray-400">
                                {{ $conversation->customer->firstName ?? 'N/A' }} {{ $conversation->customer->lastName ?? '' }} - {{ $conversation->page->name ?? 'Unknown Page' }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ $conversation->updatedAt->diffForHumans() }}</p>
                        <a href="{{ route('admin.inbox.show', $conversation) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View</a>
                    </div>
                </div>
            @empty
                <p class="py-8 text-center text-gray-500">No conversations found</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $conversations->links() }}
        </div>
    </div>
</div>
@endsection

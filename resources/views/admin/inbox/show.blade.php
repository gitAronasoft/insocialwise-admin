@extends('admin.layouts.app')

@section('title', 'Conversation')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Inbox', 'url' => route('admin.inbox.index')], ['label' => 'View Details', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">{{ $conversation->external_username ?? 'Unknown User' }}</h3>
            <p class="text-sm text-gray-500">{{ $conversation->customer->firstName ?? 'N/A' }} {{ $conversation->customer->lastName ?? '' }} - {{ $conversation->page->page_name ?? 'Unknown Page' }}</p>
        </div>
        <a href="{{ route('admin.inbox.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Inbox</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-500">Status</p>
                <p class="text-sm text-gray-900">{{ ucfirst($conversation->status ?? 'Unknown') }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Platform</p>
                <p class="text-sm text-gray-900">{{ ucfirst($conversation->platform ?? 'Unknown') }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Last Updated</p>
                <p class="text-sm text-gray-900">{{ $conversation->updatedAt->diffForHumans() }}</p>
            </div>
        </div>

        <h4 class="text-lg font-semibold text-gray-900 mb-4">Messages</h4>
        <div class="space-y-4 max-h-96 overflow-y-auto">
            @forelse($messages as $message)
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 {{ $message->sender_type === 'customer' ? 'border-blue-500' : 'border-green-500' }}">
                    <div class="flex justify-between items-start mb-2">
                        <p class="font-medium text-gray-900">
                            {{ $message->sender_type === 'customer' ? 'Customer' : 'Page' }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $message->createdAt ? $message->createdAt->format('M d, Y H:i') : '' }}</p>
                    </div>
                    <p class="text-gray-700">{{ $message->message_text }}</p>
                    @if($message->attachments)
                        <p class="text-xs text-gray-500 mt-2">📎 Has attachments</p>
                    @endif
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">No messages in this conversation</p>
            @endforelse
        </div>

        @if($messages->hasPages())
        <div class="mt-4">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

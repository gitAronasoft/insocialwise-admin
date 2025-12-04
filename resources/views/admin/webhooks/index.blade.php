@extends('admin.layouts.app')
@section('title', 'Webhooks')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Webhooks</h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Manage webhook integrations</p>
        </div>
        <a href="{{ route('admin.webhooks.create') }}" class="btn btn-primary">Add Webhook</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Total</p>
            <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Active</p>
            <p class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Success Rate</p>
            <p class="text-3xl font-bold">{{ $stats['success_rate'] }}%</p>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">Provider</th>
                    <th class="px-6 py-3 text-left">Event Type</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Success Rate</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($webhooks ?? [] as $webhook)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">{{ ucfirst($webhook->provider) }}</td>
                    <td class="px-6 py-4">{{ $webhook->event_type }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 rounded-full text-xs bg-{{ $webhook->active ? 'green' : 'gray' }}-100">{{ $webhook->active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="px-6 py-4">{{ $webhook->success_rate }}%</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.webhooks.show', $webhook) }}" class="text-primary-600 hover:underline text-sm">View</a>
                        <a href="{{ route('admin.webhooks.edit', $webhook) }}" class="text-primary-600 hover:underline text-sm">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No webhooks configured</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')
@section('title', 'Alerts & Notifications')
@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Alerts', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Alerts & Notifications</h1>
        <a href="{{ route('admin.alerts.index') }}" class="btn btn-primary">View All</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">Total</p>
            <p class="text-3xl font-bold">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">Unread</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['unread'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">Critical</p>
            <p class="text-3xl font-bold text-red-600">{{ $stats['critical'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">Warning</p>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['warning'] ?? 0 }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($alerts ?? [] as $alert)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">{{ ucfirst($alert->type) }}</td>
                        <td class="px-6 py-4">{{ $alert->title }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 rounded text-xs bg-{{ $alert->severity_color }}-100">{{ ucfirst($alert->severity) }}</span></td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ DateHelper::diffForHumans($alert->created_at) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No alerts found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('admin.layouts.app')
@section('title', 'Social Accounts')
@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Social Accounts</h1>
        <p class="mt-1 text-gray-600 dark:text-gray-400">View and manage all connected social media accounts</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Total</p>
            <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Active</p>
            <p class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Expiring Soon</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['expiring_soon'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Expired</p>
            <p class="text-3xl font-bold text-red-600">{{ $stats['expired'] }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">Account</th>
                    <th class="px-6 py-3 text-left">Platform</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Owner</th>
                    <th class="px-6 py-3 text-left">Token Expiry</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($accounts ?? [] as $account)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">{{ $account->name }}</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 rounded text-xs bg-primary-100">{{ ucfirst($account->platform) }}</span></td>
                    <td class="px-6 py-4"><span class="px-2 py-1 rounded text-xs bg-green-100">{{ ucfirst($account->status) }}</span></td>
                    <td class="px-6 py-4">{{ optional($account->customer)->firstName ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $account->access_token_expiry ? $account->access_token_expiry->format('M d, Y') : 'N/A' }}</td>
                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.social-accounts.show', $account) }}" class="text-primary-600 hover:underline text-sm">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No social accounts connected</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

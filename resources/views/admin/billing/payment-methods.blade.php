@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Payment Methods')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Billing', 'url' => route('admin.billing.overview')],
        ['label' => 'Payment Methods', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Payment Methods</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">View and manage customer payment methods</p>
        </div>
        <a href="{{ route('admin.billing.overview') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Overview
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-enhanced-stat-card
            title="Total"
            value="{{ $stats['total'] }}"
            color="gray"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'
        />
        <x-enhanced-stat-card
            title="Active"
            value="{{ $stats['active'] }}"
            color="green"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />
        <x-enhanced-stat-card
            title="Expiring Soon"
            value="{{ $stats['expiring_soon'] }}"
            color="yellow"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />
        <x-enhanced-stat-card
            title="Expired"
            value="{{ $stats['expired'] }}"
            color="red"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />
    </div>

    <x-card-section no-padding>
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.billing.payment-methods') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search by card number, email, or name..." 
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                </div>
                <div>
                    <select name="status" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-2 pl-3 pr-8 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <select name="card_brand" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-2 pl-3 pr-8 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Brands</option>
                        @foreach($cardBrands as $brand)
                            <option value="{{ $brand }}" {{ request('card_brand') === $brand ? 'selected' : '' }}>{{ ucfirst($brand) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="is_default" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-2 pl-3 pr-8 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All</option>
                        <option value="true" {{ request('is_default') === 'true' ? 'selected' : '' }}>Default Only</option>
                        <option value="false" {{ request('is_default') === 'false' ? 'selected' : '' }}>Non-Default</option>
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.billing.payment-methods') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Card</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Expiry</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Default</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Added</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($paymentMethods as $method)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4">
                                @if($method->customer)
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">{{ strtoupper(substr($method->customer->name ?? '?', 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <a href="{{ route('admin.customers.show', $method->customer) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                                {{ $method->customer->name }}
                                            </a>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $method->customer->email }}</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Unknown</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-8 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-md flex items-center justify-center mr-3 shadow-sm">
                                        @if($method->brand === 'visa')
                                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400">VISA</span>
                                        @elseif($method->brand === 'mastercard')
                                            <span class="text-xs font-bold text-red-600 dark:text-red-400">MC</span>
                                        @elseif($method->brand === 'amex')
                                            <span class="text-xs font-bold text-blue-800 dark:text-blue-300">AMEX</span>
                                        @else
                                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ strtoupper(substr($method->brand ?? 'CARD', 0, 4)) }}</span>
                                        @endif
                                    </div>
                                    <span class="font-mono text-sm text-gray-900 dark:text-gray-100">**** {{ $method->last4 }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ str_pad($method->exp_month ?? '00', 2, '0', STR_PAD_LEFT) }}/{{ str_pad($method->exp_year ?? '00', 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <x-status-badge :status="$method->status ?? 'inactive'" />
                            </td>
                            <td class="px-6 py-4">
                                @if($method->is_default)
                                    <x-status-badge status="default" />
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <div>{{ DateHelper::formatDateTime($method->created_at) }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state 
                                    title="No payment methods found"
                                    description="Try adjusting your search or filters to find what you're looking for."
                                    icon="credit-card"
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($paymentMethods->hasPages())
        <x-slot:footer>
            {{ $paymentMethods->links() }}
        </x-slot:footer>
        @endif
    </x-card-section>
</div>
@endsection

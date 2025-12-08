@extends('admin.layouts.app')

@section('title', 'Payments')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Billing', 'url' => route('admin.billing.overview')],
        ['label' => 'Payments', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Payments</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Combined view of payment methods and transactions</p>
        </div>
        <a href="{{ route('admin.billing.overview') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Overview
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <x-enhanced-stat-card
            title="Payment Methods"
            value="{{ $stats['total_payment_methods'] }}"
            color="blue"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'
        />
        <x-enhanced-stat-card
            title="Active Cards"
            value="{{ $stats['active_cards'] }}"
            color="green"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />
        <x-enhanced-stat-card
            title="Total Transactions"
            value="{{ $stats['total_transactions'] }}"
            color="indigo"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>'
        />
        <x-enhanced-stat-card
            title="Successful"
            value="{{ $stats['successful_transactions'] }}"
            color="emerald"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
        />
        <x-enhanced-stat-card
            title="Total Revenue"
            value="${{ number_format($stats['total_revenue'], 2) }}"
            color="green"
            icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        />
    </div>

    <x-card-section no-padding>
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.billing.payments') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}" 
                            placeholder="Search by card, invoice, or customer..." 
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                </div>
                <div>
                    <select name="type" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-2 pl-3 pr-8 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Types</option>
                        <option value="payment_method" {{ $typeFilter === 'payment_method' ? 'selected' : '' }}>Payment Methods</option>
                        <option value="transaction" {{ $typeFilter === 'transaction' ? 'selected' : '' }}>Transactions</option>
                    </select>
                </div>
                <div>
                    <select name="status" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-2 pl-3 pr-8 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Statuses</option>
                        <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="succeeded" {{ $statusFilter === 'succeeded' ? 'selected' : '' }}>Succeeded</option>
                        <option value="paid" {{ $statusFilter === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $statusFilter === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="expired" {{ $statusFilter === 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.billing.payments') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
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
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Card</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4">
                                @if($payment['record_type'] === 'payment_method')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        Card
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Transaction
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">{{ strtoupper(substr($payment['customer_name'] ?? '?', 0, 1)) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        @if($payment['customer'])
                                            <a href="{{ route('admin.customers.show', $payment['customer']) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                                {{ $payment['customer_name'] }}
                                            </a>
                                        @else
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $payment['customer_name'] }}</span>
                                        @endif
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $payment['customer_email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $payment['description'] }}</span>
                                @if($payment['is_default'])
                                    <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400">Default</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($payment['brand'] && $payment['last4'])
                                    <div class="flex items-center">
                                        <div class="w-10 h-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded flex items-center justify-center mr-2 shadow-sm">
                                            @if(strtolower($payment['brand']) === 'visa')
                                                <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400">VISA</span>
                                            @elseif(strtolower($payment['brand']) === 'mastercard')
                                                <span class="text-[10px] font-bold text-red-600 dark:text-red-400">MC</span>
                                            @elseif(strtolower($payment['brand']) === 'amex')
                                                <span class="text-[10px] font-bold text-blue-800 dark:text-blue-300">AMEX</span>
                                            @else
                                                <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">{{ strtoupper(substr($payment['brand'], 0, 4)) }}</span>
                                            @endif
                                        </div>
                                        <span class="font-mono text-sm text-gray-700 dark:text-gray-300">**** {{ $payment['last4'] }}</span>
                                        @if($payment['expiry'])
                                            <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">({{ $payment['expiry'] }})</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $payment['formatted_amount'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if(in_array($payment['status'], ['active', 'succeeded', 'paid'])) bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                    @elseif(in_array($payment['status'], ['pending', 'processing'])) bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400
                                    @elseif(in_array($payment['status'], ['failed', 'expired', 'canceled'])) bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                                    @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400
                                    @endif
                                ">{{ ucfirst($payment['status']) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $payment['date_formatted'] }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-empty-state 
                                    title="No payments found"
                                    description="Try adjusting your search or filters to find what you're looking for."
                                    icon="credit-card"
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
        <x-slot:footer>
            {{ $payments->links() }}
        </x-slot:footer>
        @endif
    </x-card-section>
</div>
@endsection

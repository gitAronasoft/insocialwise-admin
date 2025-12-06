@extends('admin.layouts.app')

@section('title', 'Payment Methods')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Payment Methods</h1>
            <p class="text-sm text-gray-500 mt-1">View and manage customer payment methods</p>
        </div>
        <a href="{{ route('admin.billing.overview') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Overview
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Total</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Active</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Expiring Soon</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['expiring_soon'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Expired</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['expired'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.billing.payment-methods') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by card number, email, or name..." 
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <select name="card_brand" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Brands</option>
                    @foreach($cardBrands as $brand)
                        <option value="{{ $brand }}" {{ request('card_brand') === $brand ? 'selected' : '' }}>{{ ucfirst($brand) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="is_default" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All</option>
                    <option value="true" {{ request('is_default') === 'true' ? 'selected' : '' }}>Default Only</option>
                    <option value="false" {{ request('is_default') === 'false' ? 'selected' : '' }}>Non-Default</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Filter</button>
            <a href="{{ route('admin.billing.payment-methods') }}" class="text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100">Reset</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Card</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Default</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Added</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paymentMethods as $method)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-4">
                                @if($method->customer)
                                    <div>
                                        <a href="{{ route('admin.customers.show', $method->customer) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                            {{ $method->customer->name }}
                                        </a>
                                        <p class="text-xs text-gray-500">{{ $method->customer->email }}</p>
                                    </div>
                                @else
                                    <span class="text-gray-400">Unknown</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-6 bg-gray-100 rounded flex items-center justify-center mr-2">
                                        @if($method->card_brand === 'visa')
                                            <span class="text-xs font-bold text-blue-600">VISA</span>
                                        @elseif($method->card_brand === 'mastercard')
                                            <span class="text-xs font-bold text-red-600">MC</span>
                                        @elseif($method->card_brand === 'amex')
                                            <span class="text-xs font-bold text-blue-800">AMEX</span>
                                        @else
                                            <span class="text-xs font-bold text-gray-600">{{ strtoupper(substr($method->card_brand ?? 'CARD', 0, 4)) }}</span>
                                        @endif
                                    </div>
                                    <span class="font-mono text-gray-900">**** {{ $method->card_last4 }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-gray-700">
                                {{ str_pad($method->card_exp_month, 2, '0', STR_PAD_LEFT) }}/{{ $method->card_exp_year }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($method->status === 'active') bg-green-100 text-green-800
                                    @elseif($method->status === 'expired') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ ucfirst($method->status) }}</span>
                            </td>
                            <td class="px-4 py-4">
                                @if($method->is_default)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Default</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-xs text-gray-500">
                                {{ $method->created_at?->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                No payment methods found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($paymentMethods->hasPages())
        <div class="mt-4">
            {{ $paymentMethods->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

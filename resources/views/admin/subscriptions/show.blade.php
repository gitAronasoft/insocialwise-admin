@extends('admin.layouts.app')

@section('title', 'Subscription Details')

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.subscriptions.index') }}" class="text-indigo-600 hover:text-indigo-800">&larr; Back to Subscriptions</a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Subscription Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Subscription ID</p>
                    <p class="text-base text-gray-900 font-mono">{{ $subscription->stripe_subscription_id ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Customer</p>
                    <p class="text-base text-gray-900">
                        @if($subscription->customer)
                            {{ $subscription->customer->firstName }} {{ $subscription->customer->lastName }}
                            <br><span class="text-sm text-gray-500">{{ $subscription->customer->email }}</span>
                        @else
                            Unknown
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Plan</p>
                    <p class="text-base text-gray-900">{{ $subscription->plan ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        @if($subscription->status === 'active') bg-green-100 text-green-800
                        @elseif($subscription->status === 'canceled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif
                    ">{{ ucfirst($subscription->status) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Amount</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($subscription->amount ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Billing Cycle</p>
                    <p class="text-base text-gray-900">{{ ucfirst($subscription->billing_cycle ?? 'monthly') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Next Billing Date</p>
                    <p class="text-base text-gray-900">{{ $subscription->next_billing_date ? $subscription->next_billing_date->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction History</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Receipt</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ strtoupper($transaction->currency) }} {{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($transaction->status === 'succeeded') bg-green-100 text-green-800
                                    @elseif($transaction->status === 'failed') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif
                                ">{{ ucfirst($transaction->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transaction->payment_method ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                {{ $transaction->description ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($transaction->receipt_url)
                                    <a href="{{ $transaction->receipt_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">View</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No transactions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

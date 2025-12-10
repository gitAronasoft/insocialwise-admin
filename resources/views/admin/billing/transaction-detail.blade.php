@extends('admin.layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Billing', 'url' => route('admin.billing.overview')],
        ['label' => 'Payments', 'url' => route('admin.billing.payments')],
        ['label' => 'Transaction #' . ($transaction->invoice_number ?? $transaction->id), 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Invoice {{ $transaction->invoice_number ? '#' . $transaction->invoice_number : 'TXN-' . $transaction->id }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Transaction details and payment information</p>
        </div>
        <div class="flex items-center space-x-3">
            @if($transaction->invoice_pdf_url)
                <a href="{{ $transaction->invoice_pdf_url }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
            @endif
            <a href="{{ route('admin.billing.payments') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Payments
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-card-section title="Transaction Summary">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ strtoupper($transaction->currency ?? 'USD') }} {{ number_format(($transaction->amount ?? 0) / 100, 2) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium
                                @if(in_array($transaction->status, ['succeeded', 'paid'])) bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                @elseif(in_array($transaction->status, ['pending', 'processing'])) bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400
                                @elseif(in_array($transaction->status, ['failed', 'canceled'])) bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                                @elseif($transaction->status === 'refunded') bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400
                                @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400
                                @endif
                            ">{{ ucfirst($transaction->status ?? 'Unknown') }}</span>
                            @if($transaction->paid_at)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Paid {{ \Carbon\Carbon::parse($transaction->paid_at)->format('M d, Y \a\t H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Invoice Details</h4>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Invoice Number</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->invoice_number ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Billing Reason</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $transaction->billing_reason ?? 'N/A')) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Plan</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->plan_name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Billing Interval</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($transaction->billing_interval ?? 'N/A') }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Amount Breakdown</h4>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ strtoupper($transaction->currency ?? 'USD') }} {{ number_format(($transaction->amount_subtotal ?? $transaction->amount ?? 0) / 100, 2) }}</dd>
                            </div>
                            @if($transaction->amount_tax > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Tax</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ strtoupper($transaction->currency ?? 'USD') }} {{ number_format(($transaction->amount_tax ?? 0) / 100, 2) }}</dd>
                            </div>
                            @endif
                            @if($transaction->discount_amount > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Discount</dt>
                                <dd class="text-sm font-medium text-green-600 dark:text-green-400">-{{ strtoupper($transaction->currency ?? 'USD') }} {{ number_format(($transaction->discount_amount ?? 0) / 100, 2) }}</dd>
                            </div>
                            @endif
                            <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                                <dt class="text-sm font-semibold text-gray-900 dark:text-white">Total</dt>
                                <dd class="text-sm font-bold text-gray-900 dark:text-white">{{ strtoupper($transaction->currency ?? 'USD') }} {{ number_format(($transaction->amount ?? 0) / 100, 2) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </x-card-section>

            <x-card-section title="Payment Method">
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    @if($transaction->pm_brand && $transaction->pm_last4)
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-8 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded flex items-center justify-center shadow-sm">
                                @if(strtolower($transaction->pm_brand) === 'visa')
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400">VISA</span>
                                @elseif(strtolower($transaction->pm_brand) === 'mastercard')
                                    <span class="text-xs font-bold text-red-600 dark:text-red-400">MC</span>
                                @elseif(strtolower($transaction->pm_brand) === 'amex')
                                    <span class="text-xs font-bold text-blue-800 dark:text-blue-300">AMEX</span>
                                @else
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ strtoupper(substr($transaction->pm_brand, 0, 4)) }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($transaction->pm_brand) }} •••• {{ $transaction->pm_last4 }}</p>
                                @if($transaction->pm_exp_month && $transaction->pm_exp_year)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Expires {{ sprintf('%02d/%02d', $transaction->pm_exp_month, $transaction->pm_exp_year % 100) }}</p>
                                @endif
                                @if($transaction->pm_funding)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ $transaction->pm_funding }} card</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Payment method information not available</p>
                                @if($transaction->stripe_payment_method_id)
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">PM ID: {{ Str::limit($transaction->stripe_payment_method_id, 25) }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </x-card-section>

            @if($transaction->failure_code || $transaction->failure_message)
            <x-card-section title="Failure Details">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            @if($transaction->failure_code)
                                <p class="text-sm font-medium text-red-800 dark:text-red-300">Error Code: {{ $transaction->failure_code }}</p>
                            @endif
                            @if($transaction->failure_message)
                                <p class="text-sm text-red-700 dark:text-red-400 mt-1">{{ $transaction->failure_message }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card-section>
            @endif

            <x-card-section title="Stripe References">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($transaction->stripe_invoice_id)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <dt class="text-xs text-gray-500 dark:text-gray-400">Invoice ID</dt>
                        <dd class="text-sm font-mono text-gray-900 dark:text-white mt-1">{{ $transaction->stripe_invoice_id }}</dd>
                    </div>
                    @endif
                    @if($transaction->stripe_payment_intent_id)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <dt class="text-xs text-gray-500 dark:text-gray-400">Payment Intent ID</dt>
                        <dd class="text-sm font-mono text-gray-900 dark:text-white mt-1">{{ $transaction->stripe_payment_intent_id }}</dd>
                    </div>
                    @endif
                    @if($transaction->stripe_charge_id)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <dt class="text-xs text-gray-500 dark:text-gray-400">Charge ID</dt>
                        <dd class="text-sm font-mono text-gray-900 dark:text-white mt-1">{{ $transaction->stripe_charge_id }}</dd>
                    </div>
                    @endif
                    @if($transaction->stripe_subscription_id)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <dt class="text-xs text-gray-500 dark:text-gray-400">Subscription ID</dt>
                        <dd class="text-sm font-mono text-gray-900 dark:text-white mt-1">{{ $transaction->stripe_subscription_id }}</dd>
                    </div>
                    @endif
                </dl>
            </x-card-section>
        </div>

        <div class="space-y-6">
            <x-card-section title="Customer Information">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mb-3">
                        <span class="text-xl text-white font-bold">{{ strtoupper(substr($transaction->customer_name ?? '?', 0, 1)) }}</span>
                    </div>
                    @if($transaction->customer_uuid)
                        <a href="{{ route('admin.customers.show', ['customer' => $transaction->customer_uuid]) }}" class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                            {{ $transaction->customer_name ?? 'Unknown' }}
                        </a>
                    @else
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">Unknown Customer</p>
                    @endif
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->customer_email ?? 'N/A' }}</p>
                </div>

                @if($transaction->billing_address_line1 || $transaction->billing_city)
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Billing Address</h4>
                    <p class="text-sm text-gray-900 dark:text-white">
                        @if($transaction->billing_address_line1){{ $transaction->billing_address_line1 }}<br>@endif
                        @if($transaction->billing_address_line2){{ $transaction->billing_address_line2 }}<br>@endif
                        @if($transaction->billing_city){{ $transaction->billing_city }}, @endif
                        @if($transaction->billing_state){{ $transaction->billing_state }} @endif
                        @if($transaction->billing_postal_code){{ $transaction->billing_postal_code }}<br>@endif
                        @if($transaction->billing_country){{ strtoupper($transaction->billing_country) }}@endif
                    </p>
                </div>
                @endif
            </x-card-section>

            @if($relatedTransactions->count() > 0)
            <x-card-section title="Recent Transactions">
                <div class="space-y-3">
                    @foreach($relatedTransactions as $related)
                    <a href="{{ route('admin.billing.transaction-detail', $related->id) }}" class="block p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $related->invoice_number ? '#' . $related->invoice_number : 'TXN-' . $related->id }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $related->paid_at ? \Carbon\Carbon::parse($related->paid_at)->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ strtoupper($related->currency ?? 'USD') }} {{ number_format(($related->amount ?? 0) / 100, 2) }}
                                </p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @if(in_array($related->status, ['succeeded', 'paid'])) bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                    @elseif(in_array($related->status, ['failed'])) bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                                    @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400
                                    @endif
                                ">{{ ucfirst($related->status ?? 'Unknown') }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </x-card-section>
            @endif

            <x-card-section title="Quick Actions">
                <div class="space-y-3">
                    @if($transaction->invoice_pdf_url)
                    <a href="{{ $transaction->invoice_pdf_url }}" target="_blank" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Download Invoice PDF</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    @endif
                    @if($transaction->invoice_hosted_url)
                    <a href="{{ $transaction->invoice_hosted_url }}" target="_blank" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">View Online Invoice</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    @endif
                    @if($transaction->receipt_url)
                    <a href="{{ $transaction->receipt_url }}" target="_blank" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">View Receipt</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    @endif
                    @if($transaction->customer_uuid)
                    <a href="{{ route('admin.customers.show', ['customer' => $transaction->customer_uuid]) }}" class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">View Customer Profile</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </x-card-section>
        </div>
    </div>
</div>
@endsection
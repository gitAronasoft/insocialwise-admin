@extends('admin.layouts.app')

@section('title', 'Subscription Details')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Subscriptions', 'url' => route('admin.subscriptions.index')], ['label' => 'View Details', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.subscriptions.index') }}" class="text-indigo-600 hover:text-indigo-800">&larr; Back to Subscriptions</a>
        @if($subscription->customer)
            <a href="{{ route('admin.customers.show', $subscription->customer) }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">
                View Customer
            </a>
        @endif
    </div>

    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold">Subscription Lifecycle</h2>
                <p class="text-indigo-100 mt-1">Visual journey of this subscription</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($subscription->status === 'active') bg-green-400 text-green-900
                @elseif($subscription->status === 'trialing') bg-blue-400 text-blue-900
                @elseif($subscription->status === 'canceled') bg-red-400 text-red-900
                @elseif($subscription->status === 'past_due') bg-yellow-400 text-yellow-900
                @else bg-gray-400 text-gray-900
                @endif
            ">{{ $subscription->status_label ?? ucfirst($subscription->status) }}</span>
        </div>
        
        <div class="mt-8">
            <div class="relative">
                <div class="absolute top-5 left-0 right-0 h-1 bg-white/20 rounded-full"></div>
                
                @php
                    $stages = [];
                    
                    if ($subscription->created_at) {
                        $stages[] = [
                            'label' => 'Created',
                            'date' => $subscription->created_at,
                            'active' => true,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>'
                        ];
                    }
                    
                    if ($subscription->trial_start) {
                        $stages[] = [
                            'label' => 'Trial Started',
                            'date' => $subscription->trial_start,
                            'active' => true,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                        ];
                    }
                    
                    if ($subscription->trial_end) {
                        $isTrialEnded = $subscription->trial_end->isPast();
                        $stages[] = [
                            'label' => $isTrialEnded ? 'Trial Ended' : 'Trial Ends',
                            'date' => $subscription->trial_end,
                            'active' => $isTrialEnded,
                            'future' => !$isTrialEnded,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                        ];
                    }
                    
                    // Add first successful payment as a milestone
                    if (isset($transactions) && $transactions->count() > 0) {
                        $firstPayment = $transactions->filter(fn($t) => $t->isSuccessful())->last();
                        if ($firstPayment && $firstPayment->paid_at) {
                            $stages[] = [
                                'label' => 'First Payment',
                                'date' => $firstPayment->paid_at,
                                'active' => true,
                                'payment' => true,
                                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>'
                            ];
                        }
                    }
                    
                    if ($subscription->status === 'active' && !$subscription->canceled_at) {
                        $stages[] = [
                            'label' => 'Active',
                            'date' => $subscription->current_period_start ?? $subscription->trial_end ?? $subscription->created_at,
                            'active' => true,
                            'current' => true,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
                        ];
                    }
                    
                    if ($subscription->current_period_end && $subscription->status === 'active') {
                        $stages[] = [
                            'label' => 'Next Renewal',
                            'date' => $subscription->current_period_end,
                            'active' => false,
                            'future' => true,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>'
                        ];
                    }
                    
                    if ($subscription->canceled_at) {
                        $stages[] = [
                            'label' => 'Canceled',
                            'date' => $subscription->canceled_at,
                            'active' => true,
                            'canceled' => true,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'
                        ];
                    }
                    
                    if ($subscription->ended_at) {
                        $stages[] = [
                            'label' => 'Ended',
                            'date' => $subscription->ended_at,
                            'active' => true,
                            'ended' => true,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>'
                        ];
                    }
                    
                    usort($stages, fn($a, $b) => $a['date'] <=> $b['date']);
                @endphp
                
                <div class="flex justify-between relative">
                    @foreach($stages as $index => $stage)
                        <div class="flex flex-col items-center" style="flex: 1;">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center z-10 transition-all duration-300
                                @if(isset($stage['canceled']) || isset($stage['ended'])) bg-red-500
                                @elseif(isset($stage['current'])) bg-green-400 ring-4 ring-green-300/50
                                @elseif(isset($stage['payment'])) bg-emerald-400 ring-2 ring-emerald-300/50
                                @elseif(isset($stage['future'])) bg-white/30 border-2 border-white/50
                                @elseif($stage['active']) bg-white text-indigo-600
                                @else bg-white/30
                                @endif
                            ">
                                <span class="@if(isset($stage['canceled']) || isset($stage['ended'])) text-white @elseif(isset($stage['payment'])) text-white @elseif($stage['active'] && !isset($stage['future'])) text-indigo-600 @else text-white/70 @endif">
                                    {!! $stage['icon'] !!}
                                </span>
                            </div>
                            <div class="mt-3 text-center">
                                <p class="text-sm font-semibold @if(isset($stage['future'])) text-white/70 @else text-white @endif">{{ $stage['label'] }}</p>
                                <p class="text-xs @if(isset($stage['future'])) text-white/50 @else text-indigo-200 @endif">{{ $stage['date']->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="absolute top-5 left-0 h-1 bg-white rounded-full transition-all duration-500" 
                     style="width: {{ count(array_filter($stages, fn($s) => $s['active'] ?? false)) / max(count($stages), 1) * 100 }}%"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Subscription Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Subscription ID</p>
                    <p class="text-base text-gray-900 dark:text-white font-mono text-xs">{{ $subscription->stripe_subscription_id ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer</p>
                    <p class="text-base text-gray-900 dark:text-white">
                        @if($subscription->customer)
                            <a href="{{ route('admin.customers.show', $subscription->customer) }}" class="text-indigo-600 hover:text-indigo-800">
                                {{ $subscription->customer->firstName }} {{ $subscription->customer->lastName }}
                            </a>
                            <br><span class="text-sm text-gray-500">{{ $subscription->customer->email }}</span>
                        @else
                            Unknown
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Plan</p>
                    <p class="text-base text-gray-900 dark:text-white">{{ $subscription->plan->name ?? $subscription->price_id ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        @if($subscription->status === 'active') bg-green-100 text-green-800
                        @elseif($subscription->status === 'trialing') bg-blue-100 text-blue-800
                        @elseif($subscription->status === 'past_due') bg-yellow-100 text-yellow-800
                        @elseif($subscription->status === 'canceled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif
                    ">{{ $subscription->status_label ?? ucfirst($subscription->status) }}</span>
                </div>
                @if($subscription->cancellation_reason)
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cancellation Reason</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $subscription->cancellation_reason }}</p>
                    </div>
                @endif
                @if($subscription->cancellation_feedback)
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cancellation Feedback</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-2 rounded">{{ $subscription->cancellation_feedback }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Billing Details</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $subscription->formatted_amount ?? '$' . number_format((($subscription->amount ?? 0) / 100), 2) }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Billing Interval</p>
                    <p class="text-base text-gray-900 dark:text-white">{{ ucfirst($subscription->billing_interval ?? 'monthly') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Period</p>
                    <p class="text-base text-gray-900 dark:text-white">
                        {{ $subscription->current_period_start?->format('M d, Y') ?? 'N/A' }} - 
                        {{ $subscription->current_period_end?->format('M d, Y') ?? 'N/A' }}
                    </p>
                </div>
                @if($subscription->days_until_renewal !== null && $subscription->status === 'active')
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Days Until Renewal</p>
                        <p class="text-base text-gray-900 dark:text-white">
                            @if($subscription->days_until_renewal > 0)
                                <span class="text-green-600 font-semibold">{{ $subscription->days_until_renewal }} days</span>
                            @elseif($subscription->days_until_renewal == 0)
                                <span class="text-yellow-600 font-semibold">Today</span>
                            @else
                                <span class="text-red-600 font-semibold">Overdue</span>
                            @endif
                        </p>
                    </div>
                @endif
                @if($subscription->trial_days)
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Trial Period</p>
                        <p class="text-base text-gray-900 dark:text-white">{{ $subscription->trial_days }} days</p>
                    </div>
                @endif
                @if($subscription->coupon_code || $subscription->discount_percent)
                    <div class="pt-2 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Discount Applied</p>
                        <div class="flex items-center mt-1">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                @if($subscription->discount_percent)
                                    {{ $subscription->discount_percent }}% OFF
                                @endif
                                @if($subscription->coupon_code)
                                    ({{ $subscription->coupon_code }})
                                @endif
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Method</h3>
            
            @if(isset($paymentMethod) && $paymentMethod)
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-5 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full -ml-12 -mb-12"></div>
                    
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            @if($paymentMethod->is_default)
                                <span class="px-2 py-0.5 text-xs font-medium bg-green-500 text-white rounded">Default</span>
                            @endif
                        </div>
                        <div class="text-right">
                            @if(strtolower($paymentMethod->brand ?? '') === 'visa')
                                <span class="text-2xl font-bold tracking-wider">VISA</span>
                            @elseif(strtolower($paymentMethod->brand ?? '') === 'mastercard')
                                <div class="flex">
                                    <div class="w-8 h-8 bg-red-500 rounded-full -mr-3"></div>
                                    <div class="w-8 h-8 bg-yellow-500 rounded-full opacity-80"></div>
                                </div>
                            @elseif(strtolower($paymentMethod->brand ?? '') === 'amex')
                                <span class="text-xl font-bold">AMEX</span>
                            @else
                                <span class="text-lg font-bold">{{ strtoupper($paymentMethod->brand ?? 'CARD') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-xl font-mono tracking-widest">•••• •••• •••• {{ $paymentMethod->last4 }}</p>
                    </div>
                    
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-xs text-gray-400 uppercase">Card Holder</p>
                            <p class="font-medium">{{ $paymentMethod->card_holder ?? $subscription->customer->firstName ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase">Expires</p>
                            <p class="font-medium">{{ $paymentMethod->expiry_display }}</p>
                        </div>
                    </div>
                    
                    @if($paymentMethod->isExpired())
                        <div class="mt-3 px-2 py-1 bg-red-500/20 rounded text-center">
                            <span class="text-xs text-red-300 font-medium">EXPIRED</span>
                        </div>
                    @elseif($paymentMethod->isExpiringSoon())
                        <div class="mt-3 px-2 py-1 bg-yellow-500/20 rounded text-center">
                            <span class="text-xs text-yellow-300 font-medium">EXPIRING SOON</span>
                        </div>
                    @endif
                </div>
                
                <div class="mt-4 space-y-2 text-sm">
                    @if($paymentMethod->funding)
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Card Type</span>
                            <span class="text-gray-900 dark:text-white capitalize">{{ $paymentMethod->funding }}</span>
                        </div>
                    @endif
                    @if($paymentMethod->country)
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Country</span>
                            <span class="text-gray-900 dark:text-white">{{ $paymentMethod->country }}</span>
                        </div>
                    @endif
                    @if($paymentMethod->created_at)
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Added</span>
                            <span class="text-gray-900 dark:text-white">{{ $paymentMethod->created_at->format('M d, Y') }}</span>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <p class="mt-4 text-gray-500">No payment method on file</p>
                </div>
            @endif
        </div>
    </div>

    @if($subscription->dunning_status && $subscription->dunning_status !== 'none')
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-lg font-semibold text-red-900 dark:text-red-200">Payment Recovery in Progress</h4>
                    <div class="mt-2 text-red-700 dark:text-red-300 space-y-1">
                        <p><strong>Dunning Status:</strong> {{ ucfirst(str_replace('_', ' ', $subscription->dunning_status)) }}</p>
                        @if($subscription->payment_retry_count)
                            <p><strong>Retry Attempts:</strong> {{ $subscription->payment_retry_count }}</p>
                        @endif
                        @if($subscription->next_payment_retry_at)
                            <p><strong>Next Retry:</strong> {{ $subscription->next_payment_retry_at->format('M d, Y H:i') }}</p>
                        @endif
                        @if($subscription->last_payment_error)
                            <p><strong>Last Error:</strong> {{ $subscription->last_payment_error }}</p>
                        @endif
                        @if($subscription->past_due_since)
                            <p><strong>Past Due Since:</strong> {{ $subscription->past_due_since->format('M d, Y') }} ({{ $subscription->past_due_since->diffForHumans() }})</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($subscription->isTrialing())
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-semibold text-blue-900">Trial Active</h4>
                    <p class="text-blue-700">
                        Trial ends on {{ $subscription->trial_end->format('F d, Y') }} 
                        ({{ $subscription->trial_end->diffForHumans() }})
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($subscription->cancel_at_period_end)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-semibold text-yellow-900">Scheduled Cancellation</h4>
                    <p class="text-yellow-700">
                        This subscription will be canceled at the end of the current billing period 
                        ({{ $subscription->current_period_end?->format('F d, Y') }})
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment History</h3>
        
        @if(isset($transactions) && $transactions->count() > 0)
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                @if($transaction->isSuccessful()) bg-green-100
                                @elseif($transaction->isFailed()) bg-red-100
                                @elseif($transaction->isRefunded()) bg-orange-100
                                @else bg-gray-100
                                @endif
                            ">
                                @if($transaction->isSuccessful())
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @elseif($transaction->isFailed())
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                @elseif($transaction->isRefunded())
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $transaction->formatted_amount }}</p>
                                <p class="text-sm text-gray-500">{{ $transaction->payment_method_display }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $transaction->status_color }}-100 text-{{ $transaction->status_color }}-800">
                                {{ $transaction->status_label }}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">{{ $transaction->paid_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <p class="mt-4 text-gray-500">No transactions found</p>
            </div>
        @endif
    </div>

    @if(isset($subscriptionEvents) && count($subscriptionEvents) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Subscription Events Timeline</h3>
            
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                
                <div class="space-y-6">
                    @foreach($subscriptionEvents as $event)
                        @php
                            $eventColor = match($event->event_type ?? '') {
                                'subscription_created' => 'blue',
                                'subscription_updated' => 'indigo',
                                'subscription_deleted', 'canceled' => 'red',
                                'subscription_paused' => 'purple',
                                'subscription_resumed', 'reactivated' => 'green',
                                'trial_started', 'trial_ending' => 'cyan',
                                'trial_ended', 'trial_converted' => 'teal',
                                'payment_succeeded', 'invoice_paid' => 'green',
                                'payment_failed', 'invoice_payment_failed' => 'red',
                                'payment_refunded' => 'orange',
                                'invoice_created', 'invoice_upcoming' => 'blue',
                                'plan_changed' => 'purple',
                                'quantity_changed' => 'indigo',
                                'status_changed' => 'yellow',
                                'dunning_started', 'dunning_ended' => 'orange',
                                default => 'gray',
                            };
                            $eventLabel = match($event->event_type ?? '') {
                                'subscription_created' => 'Subscription Created',
                                'subscription_updated' => 'Subscription Updated',
                                'subscription_deleted' => 'Subscription Deleted',
                                'subscription_paused' => 'Subscription Paused',
                                'subscription_resumed' => 'Subscription Resumed',
                                'trial_started' => 'Trial Started',
                                'trial_ending' => 'Trial Ending',
                                'trial_ended' => 'Trial Ended',
                                'trial_converted' => 'Trial Converted',
                                'payment_succeeded' => 'Payment Succeeded',
                                'payment_failed' => 'Payment Failed',
                                'payment_refunded' => 'Payment Refunded',
                                'invoice_created' => 'Invoice Created',
                                'invoice_paid' => 'Invoice Paid',
                                'invoice_payment_failed' => 'Invoice Payment Failed',
                                'invoice_upcoming' => 'Invoice Upcoming',
                                'plan_changed' => 'Plan Changed',
                                'quantity_changed' => 'Quantity Changed',
                                'status_changed' => 'Status Changed',
                                'canceled' => 'Canceled',
                                'reactivated' => 'Reactivated',
                                'dunning_started' => 'Dunning Started',
                                'dunning_ended' => 'Dunning Ended',
                                default => ucfirst(str_replace('_', ' ', $event->event_type ?? 'Unknown')),
                            };
                        @endphp
                        <div class="relative flex items-start pl-10">
                            <div class="absolute left-0 w-8 h-8 rounded-full flex items-center justify-center z-10
                                @if($eventColor === 'green') bg-green-100 text-green-600
                                @elseif($eventColor === 'red') bg-red-100 text-red-600
                                @elseif($eventColor === 'blue') bg-blue-100 text-blue-600
                                @elseif($eventColor === 'indigo') bg-indigo-100 text-indigo-600
                                @elseif($eventColor === 'purple') bg-purple-100 text-purple-600
                                @elseif($eventColor === 'orange') bg-orange-100 text-orange-600
                                @elseif($eventColor === 'yellow') bg-yellow-100 text-yellow-600
                                @elseif($eventColor === 'cyan') bg-cyan-100 text-cyan-600
                                @elseif($eventColor === 'teal') bg-teal-100 text-teal-600
                                @else bg-gray-100 text-gray-600
                                @endif
                            ">
                                @if(in_array($event->event_type, ['subscription_created']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                @elseif(in_array($event->event_type, ['payment_succeeded', 'invoice_paid']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @elseif(in_array($event->event_type, ['payment_failed', 'invoice_payment_failed']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                @elseif(in_array($event->event_type, ['canceled', 'subscription_deleted']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                @elseif(in_array($event->event_type, ['trial_started', 'trial_ending', 'trial_ended']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif(in_array($event->event_type, ['plan_changed']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                @elseif(in_array($event->event_type, ['payment_refunded']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                @elseif(in_array($event->event_type, ['dunning_started', 'dunning_ended']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                @elseif(in_array($event->event_type, ['subscription_resumed', 'reactivated']))
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </div>
                            
                            <div class="flex-1 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($eventColor === 'green') bg-green-100 text-green-800
                                            @elseif($eventColor === 'red') bg-red-100 text-red-800
                                            @elseif($eventColor === 'blue') bg-blue-100 text-blue-800
                                            @elseif($eventColor === 'indigo') bg-indigo-100 text-indigo-800
                                            @elseif($eventColor === 'purple') bg-purple-100 text-purple-800
                                            @elseif($eventColor === 'orange') bg-orange-100 text-orange-800
                                            @elseif($eventColor === 'yellow') bg-yellow-100 text-yellow-800
                                            @elseif($eventColor === 'cyan') bg-cyan-100 text-cyan-800
                                            @elseif($eventColor === 'teal') bg-teal-100 text-teal-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                        ">{{ $eventLabel }}</span>
                                        @if($event->description)
                                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $event->description }}</p>
                                        @endif
                                        @if($event->amount)
                                            <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ strtoupper($event->currency ?? 'USD') }} {{ number_format($event->amount / 100, 2) }}
                                            </p>
                                        @endif
                                        @if($event->old_status && $event->new_status)
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                Status: <span class="line-through">{{ $event->old_status }}</span> &rarr; <span class="font-medium">{{ $event->new_status }}</span>
                                            </p>
                                        @endif
                                        @if($event->failure_message)
                                            <p class="mt-1 text-xs text-red-600">{{ $event->failure_message }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $event->occurred_at ? \Carbon\Carbon::parse($event->occurred_at)->format('M d, Y H:i') : ($event->created_at ? \Carbon\Carbon::parse($event->created_at)->format('M d, Y H:i') : 'N/A') }}
                                        </p>
                                        @if($event->actor)
                                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                                by {{ ucfirst($event->actor) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($subscription->current_period_end && $subscription->status === 'active')
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Events</h3>
            
            <div class="space-y-3">
                <div class="flex items-center p-4 bg-indigo-50 rounded-lg">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-indigo-900">Next Renewal</p>
                        <p class="text-sm text-indigo-700">{{ $subscription->current_period_end->format('F d, Y') }} ({{ $subscription->current_period_end->diffForHumans() }})</p>
                    </div>
                    <div class="ml-auto">
                        <span class="text-lg font-bold text-indigo-900">{{ $subscription->formatted_amount ?? '$' . number_format(($subscription->amount ?? 0) / 100, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

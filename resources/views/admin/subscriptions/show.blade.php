@extends('admin.layouts.app')

@section('title', 'Subscription Details')

@section('content')
<div class="space-y-6">
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
                    
                    if ($subscription->createdAt) {
                        $stages[] = [
                            'label' => 'Created',
                            'date' => $subscription->createdAt,
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
                        if ($firstPayment && $firstPayment->created_at) {
                            $stages[] = [
                                'label' => 'First Payment',
                                'date' => $firstPayment->created_at,
                                'active' => true,
                                'payment' => true,
                                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>'
                            ];
                        }
                    }
                    
                    if ($subscription->status === 'active' && !$subscription->canceled_at) {
                        $stages[] = [
                            'label' => 'Active',
                            'date' => $subscription->current_period_start ?? $subscription->trial_end ?? $subscription->createdAt,
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
                    <p class="text-sm font-medium text-gray-500">Plan</p>
                    <p class="text-base text-gray-900">{{ $subscription->plan->name ?? $subscription->price_id ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        bg-{{ $subscription->status_color ?? 'gray' }}-100 text-{{ $subscription->status_color ?? 'gray' }}-800
                    ">{{ $subscription->status_label ?? ucfirst($subscription->status) }}</span>
                </div>
                @if($subscription->cancellation_reason)
                    <div>
                        <p class="text-sm font-medium text-gray-500">Cancellation Reason</p>
                        <p class="text-base text-gray-900">{{ $subscription->cancellation_reason }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Billing Details</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Amount</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $subscription->formatted_amount ?? '$' . number_format(($subscription->amount ?? 0) / 100, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Billing Interval</p>
                    <p class="text-base text-gray-900">{{ ucfirst($subscription->billing_interval ?? 'monthly') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Current Period</p>
                    <p class="text-base text-gray-900">
                        {{ $subscription->current_period_start?->format('M d, Y') ?? 'N/A' }} - 
                        {{ $subscription->current_period_end?->format('M d, Y') ?? 'N/A' }}
                    </p>
                </div>
                @if($subscription->days_until_renewal !== null && $subscription->status === 'active')
                    <div>
                        <p class="text-sm font-medium text-gray-500">Days Until Renewal</p>
                        <p class="text-base text-gray-900">
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
                        <p class="text-sm font-medium text-gray-500">Trial Period</p>
                        <p class="text-base text-gray-900">{{ $subscription->trial_days }} days</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

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
                            <p class="text-sm text-gray-500 mt-1">{{ $transaction->created_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
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

@extends('admin.layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.customers.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Customers
        </a>
        <div class="space-x-2">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Customer
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card">
            <div class="card-body text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/30">
                    <span class="text-4xl text-white font-bold">{{ strtoupper(substr($customer->firstName, 0, 1)) }}</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $customer->firstName }} {{ $customer->lastName }}</h3>
                <p class="text-gray-500 dark:text-gray-400">{{ $customer->email }}</p>
                <div class="mt-3">
                    @if($customer->status)
                        <span class="badge badge-success">
                            <span class="badge-dot bg-emerald-500"></span>
                            Active
                        </span>
                    @else
                        <span class="badge badge-danger">
                            <span class="badge-dot bg-red-500"></span>
                            Inactive
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="card-body pt-0 space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">UUID</span>
                    <span class="text-gray-900 dark:text-white font-mono text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ Str::limit($customer->uuid, 20) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Company</span>
                    <span class="text-gray-900 dark:text-white">{{ $customer->company ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Job Title</span>
                    <span class="text-gray-900 dark:text-white">{{ $customer->jobTitle ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Location</span>
                    <span class="text-gray-900 dark:text-white">{{ $customer->userLocation ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Timezone</span>
                    <span class="text-gray-900 dark:text-white">{{ $customer->timeZone ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Joined</span>
                    <span class="text-gray-900 dark:text-white">{{ $customer->createdAt->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Connected Social Accounts</h4>
                    <span class="badge badge-primary">{{ $customer->socialUsers->count() }} connected</span>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        @forelse($customer->socialUsers as $socialUser)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                                        <span class="text-white font-bold text-lg">{{ strtoupper(substr($socialUser->platform, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $socialUser->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($socialUser->platform) }} - {{ $socialUser->email ?? 'No email' }}</p>
                                    </div>
                                </div>
                                <span class="badge badge-gray">{{ $socialUser->pages->count() }} pages</span>
                            </div>
                        @empty
                            <div class="empty-state py-8">
                                <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="empty-state-description">No social accounts connected</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Subscriptions</h4>
                    <span class="badge badge-primary">{{ $customer->subscriptions->count() }} total</span>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        @forelse($customer->subscriptions as $subscription)
                            <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md hover:border-primary-300 dark:hover:border-primary-600 transition-all">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white font-mono text-sm">{{ $subscription->stripe_subscription_id }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $subscription->current_period_start?->format('M d') }} - {{ $subscription->current_period_end?->format('M d, Y') }}
                                        </span>
                                    </p>
                                </div>
                                <span class="badge 
                                    @if($subscription->status === 'active') badge-success
                                    @elseif($subscription->status === 'trialing') badge-primary
                                    @elseif($subscription->status === 'past_due') badge-warning
                                    @elseif($subscription->status === 'canceled') badge-danger
                                    @else badge-gray
                                    @endif
                                ">{{ ucfirst($subscription->status) }}</span>
                            </a>
                        @empty
                            <div class="empty-state py-8">
                                <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <p class="empty-state-description">No subscriptions</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Posts</h4>
                    <span class="badge badge-primary">{{ $customer->posts->count() }} posts</span>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        @forelse($customer->posts as $post)
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900 dark:text-white">{{ Str::limit($post->message, 100) }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="badge badge-gray">{{ ucfirst($post->platform) }}</span>
                                            <span class="badge 
                                                @if($post->status === 'published') badge-success
                                                @elseif($post->status === 'scheduled') badge-primary
                                                @elseif($post->status === 'draft') badge-warning
                                                @else badge-gray
                                                @endif
                                            ">{{ ucfirst($post->status) }}</span>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap ml-4">{{ $post->createdAt->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state py-8">
                                <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <p class="empty-state-description">No posts yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Activity Timeline</h4>
            <span class="badge badge-primary">{{ $customer->activities->count() }} events</span>
        </div>
        <div class="card-body">
            @if($customer->activities->count() > 0)
                <div class="relative">
                    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
                    
                    <div class="space-y-6">
                        @foreach($customer->activities->sortByDesc('createdAt')->take(20) as $activity)
                            @php
                                $activityConfig = match(strtolower($activity->activity_type ?? '')) {
                                    'login', 'auth' => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>',
                                        'bg' => 'bg-blue-100 dark:bg-blue-900/40',
                                        'text' => 'text-blue-600 dark:text-blue-400',
                                        'border' => 'border-blue-200 dark:border-blue-800'
                                    ],
                                    'signup', 'register', 'registration' => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>',
                                        'bg' => 'bg-green-100 dark:bg-green-900/40',
                                        'text' => 'text-green-600 dark:text-green-400',
                                        'border' => 'border-green-200 dark:border-green-800'
                                    ],
                                    'subscription', 'subscribe', 'plan' => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                        'bg' => 'bg-purple-100 dark:bg-purple-900/40',
                                        'text' => 'text-purple-600 dark:text-purple-400',
                                        'border' => 'border-purple-200 dark:border-purple-800'
                                    ],
                                    'payment', 'billing', 'charge' => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>',
                                        'bg' => 'bg-emerald-100 dark:bg-emerald-900/40',
                                        'text' => 'text-emerald-600 dark:text-emerald-400',
                                        'border' => 'border-emerald-200 dark:border-emerald-800'
                                    ],
                                    'post', 'content', 'publish' => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
                                        'bg' => 'bg-indigo-100 dark:bg-indigo-900/40',
                                        'text' => 'text-indigo-600 dark:text-indigo-400',
                                        'border' => 'border-indigo-200 dark:border-indigo-800'
                                    ],
                                    'social', 'connect', 'integration' => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
                                        'bg' => 'bg-cyan-100 dark:bg-cyan-900/40',
                                        'text' => 'text-cyan-600 dark:text-cyan-400',
                                        'border' => 'border-cyan-200 dark:border-cyan-800'
                                    ],
                                    'cancel', 'unsubscribe', 'churn' => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                        'bg' => 'bg-red-100 dark:bg-red-900/40',
                                        'text' => 'text-red-600 dark:text-red-400',
                                        'border' => 'border-red-200 dark:border-red-800'
                                    ],
                                    'upgrade', 'downgrade', 'change' => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>',
                                        'bg' => 'bg-amber-100 dark:bg-amber-900/40',
                                        'text' => 'text-amber-600 dark:text-amber-400',
                                        'border' => 'border-amber-200 dark:border-amber-800'
                                    ],
                                    default => [
                                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                        'bg' => 'bg-gray-100 dark:bg-gray-700',
                                        'text' => 'text-gray-600 dark:text-gray-400',
                                        'border' => 'border-gray-200 dark:border-gray-600'
                                    ]
                                };
                            @endphp
                            
                            <div class="relative flex items-start">
                                <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center z-10">
                                    <div class="w-10 h-10 rounded-full {{ $activityConfig['bg'] }} flex items-center justify-center border-2 {{ $activityConfig['border'] }}">
                                        <span class="{{ $activityConfig['text'] }}">{!! $activityConfig['icon'] !!}</span>
                                    </div>
                                </div>
                                
                                <div class="flex-1 ml-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activityConfig['bg'] }} {{ $activityConfig['text'] }}">
                                                    {{ $activity->activity_type }}
                                                </span>
                                                @if($activity->activity_subType)
                                                    <span class="text-xs text-gray-400 dark:text-gray-500">/</span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->activity_subType }}</span>
                                                @endif
                                            </div>
                                            <p class="mt-1 text-sm text-gray-900 dark:text-white font-medium">{{ $activity->action }}</p>
                                            @if($activity->account_platform)
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                    {{ $activity->account_platform }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->createdAt->diffForHumans() }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $activity->createdAt->format('M d, Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="empty-state-title">No activity recorded yet</p>
                    <p class="empty-state-description">Customer activities will appear here as they use the platform</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

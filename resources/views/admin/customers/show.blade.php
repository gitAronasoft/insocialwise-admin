@extends('admin.layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.customers.index') }}" class="text-indigo-600 hover:text-indigo-800">&larr; Back to Customers</a>
        <div class="space-x-2">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Edit</a>
            <form action="{{ route('admin.customers.impersonate', $customer) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">Impersonate</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="text-center">
                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl text-indigo-600 font-bold">{{ strtoupper(substr($customer->firstName, 0, 1)) }}</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">{{ $customer->firstName }} {{ $customer->lastName }}</h3>
                <p class="text-gray-500">{{ $customer->email }}</p>
                <div class="mt-2">
                    @if($customer->status)
                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                    @endif
                </div>
            </div>
            
            <div class="mt-6 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">UUID</span>
                    <span class="text-gray-900 font-mono text-xs">{{ $customer->uuid }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Company</span>
                    <span class="text-gray-900">{{ $customer->company ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Job Title</span>
                    <span class="text-gray-900">{{ $customer->jobTitle ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Location</span>
                    <span class="text-gray-900">{{ $customer->userLocation ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Timezone</span>
                    <span class="text-gray-900">{{ $customer->timeZone ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Joined</span>
                    <span class="text-gray-900">{{ $customer->createdAt->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Connected Social Accounts</h4>
                <div class="space-y-4">
                    @forelse($customer->socialUsers as $socialUser)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold">{{ strtoupper(substr($socialUser->platform, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $socialUser->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $socialUser->platform }} - {{ $socialUser->email ?? 'No email' }}</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $socialUser->pages->count() }} pages</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No social accounts connected</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Subscriptions</h4>
                <div class="space-y-4">
                    @forelse($customer->subscriptions as $subscription)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $subscription->stripe_subscription_id }}</p>
                                <p class="text-sm text-gray-500">
                                    Period: {{ $subscription->current_period_start?->format('M d') }} - {{ $subscription->current_period_end?->format('M d, Y') }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($subscription->status === 'active') bg-green-100 text-green-800
                                @elseif($subscription->status === 'trialing') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif
                            ">{{ ucfirst($subscription->status) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No subscriptions</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Recent Posts</h4>
                <div class="space-y-4">
                    @forelse($customer->posts as $post)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900">{{ Str::limit($post->message, 100) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $post->platform }} - {{ $post->status }}</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $post->createdAt->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No posts yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-lg font-semibold text-gray-900">Activity Timeline</h4>
            <span class="text-sm text-gray-500">{{ $customer->activities->count() }} events</span>
        </div>
        
        @if($customer->activities->count() > 0)
            <div class="relative">
                <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                
                <div class="space-y-6">
                    @foreach($customer->activities->sortBy('createdAt') as $activity)
                        @php
                            $activityConfig = match(strtolower($activity->activity_type ?? '')) {
                                'login', 'auth' => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>',
                                    'bg' => 'bg-blue-100',
                                    'text' => 'text-blue-600',
                                    'border' => 'border-blue-200'
                                ],
                                'signup', 'register', 'registration' => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>',
                                    'bg' => 'bg-green-100',
                                    'text' => 'text-green-600',
                                    'border' => 'border-green-200'
                                ],
                                'subscription', 'subscribe', 'plan' => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                    'bg' => 'bg-purple-100',
                                    'text' => 'text-purple-600',
                                    'border' => 'border-purple-200'
                                ],
                                'payment', 'billing', 'charge' => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>',
                                    'bg' => 'bg-emerald-100',
                                    'text' => 'text-emerald-600',
                                    'border' => 'border-emerald-200'
                                ],
                                'post', 'content', 'publish' => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
                                    'bg' => 'bg-indigo-100',
                                    'text' => 'text-indigo-600',
                                    'border' => 'border-indigo-200'
                                ],
                                'social', 'connect', 'integration' => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
                                    'bg' => 'bg-cyan-100',
                                    'text' => 'text-cyan-600',
                                    'border' => 'border-cyan-200'
                                ],
                                'cancel', 'unsubscribe', 'churn' => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                    'bg' => 'bg-red-100',
                                    'text' => 'text-red-600',
                                    'border' => 'border-red-200'
                                ],
                                'upgrade', 'downgrade', 'change' => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>',
                                    'bg' => 'bg-amber-100',
                                    'text' => 'text-amber-600',
                                    'border' => 'border-amber-200'
                                ],
                                default => [
                                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                    'bg' => 'bg-gray-100',
                                    'text' => 'text-gray-600',
                                    'border' => 'border-gray-200'
                                ]
                            };
                        @endphp
                        
                        <div class="relative flex items-start">
                            <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center z-10">
                                <div class="w-10 h-10 rounded-full {{ $activityConfig['bg'] }} flex items-center justify-center border-2 {{ $activityConfig['border'] }}">
                                    <span class="{{ $activityConfig['text'] }}">{!! $activityConfig['icon'] !!}</span>
                                </div>
                            </div>
                            
                            <div class="flex-1 ml-4 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activityConfig['bg'] }} {{ $activityConfig['text'] }}">
                                                {{ $activity->activity_type }}
                                            </span>
                                            @if($activity->activity_subType)
                                                <span class="text-xs text-gray-400">/</span>
                                                <span class="text-xs text-gray-500">{{ $activity->activity_subType }}</span>
                                            @endif
                                        </div>
                                        <p class="mt-1 text-sm text-gray-900 font-medium">{{ $activity->action }}</p>
                                        @if($activity->account_platform)
                                            <p class="mt-1 text-xs text-gray-500 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                </svg>
                                                {{ $activity->account_platform }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">{{ $activity->createdAt->diffForHumans() }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $activity->createdAt->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="mt-4 text-gray-500">No activity recorded yet</p>
                <p class="text-sm text-gray-400">Customer activities will appear here as they use the platform</p>
            </div>
        @endif
    </div>
</div>
@endsection

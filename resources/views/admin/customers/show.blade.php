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
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Activity Log</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($customer->activities as $activity)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $activity->activity_type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $activity->action }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $activity->account_platform ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $activity->createdAt->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No activity recorded</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

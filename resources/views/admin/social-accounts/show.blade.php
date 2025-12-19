@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Social Account Details')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Social Accounts', 'url' => route('admin.social-accounts.index')], ['label' => 'View Details', 'url' => null]
    ]" />
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.social-accounts.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300">
            &larr; Back to Social Accounts
        </a>
    </div>

    @php
        $tokenExpiry = $socialAccount->token_expires_at;
        $isExpired = $tokenExpiry && $tokenExpiry->isPast();
        $isExpiringSoon = $tokenExpiry && !$isExpired && $tokenExpiry->diffInDays(now()) < 7;
        $isDisconnected = $socialAccount->status === 'disconnected';
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="text-center">
                @if($socialAccount->profile_pic)
                    <img src="{{ $socialAccount->profile_pic }}" alt="{{ $socialAccount->name }}" class="w-20 h-20 rounded-full mx-auto mb-4">
                @else
                    <div class="w-20 h-20 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl text-primary-600 dark:text-primary-400 font-bold">{{ strtoupper(substr($socialAccount->name ?? 'S', 0, 1)) }}</span>
                    </div>
                @endif
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $socialAccount->name ?? 'Unknown Account' }}</h3>
                <p class="text-gray-500 dark:text-gray-400">{{ $socialAccount->email ?? 'No email' }}</p>
                <div class="mt-3">
                    @if($socialAccount->platform === 'facebook')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </span>
                    @elseif($socialAccount->platform === 'instagram')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 dark:bg-pink-900/30 text-pink-800 dark:text-pink-400">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/>
                            </svg>
                            Instagram
                        </span>
                    @elseif($socialAccount->platform === 'linkedin')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-sky-100 dark:bg-sky-900/30 text-sky-800 dark:text-sky-400">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                            {{ ucfirst($socialAccount->platform ?? 'Unknown') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Social ID</span>
                    <span class="text-gray-900 dark:text-gray-100 font-mono text-xs">{{ $socialAccount->social_id }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Status</span>
                    @if($socialAccount->status === 'active')
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">Active</span>
                    @elseif($socialAccount->status === 'disconnected')
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">Disconnected</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400">{{ ucfirst($socialAccount->status ?? 'Unknown') }}</span>
                    @endif
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Connected Pages</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $socialAccount->pages->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Connected</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $socialAccount->created_at ? $socialAccount->created_at->format('M d, Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Token Health Status</h4>
                
                @if($isDisconnected)
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-800 dark:text-gray-300">Account Disconnected</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">This account has been disconnected from the platform.</p>
                            </div>
                        </div>
                    </div>
                @elseif($isExpired)
                    <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-red-800 dark:text-red-400">Token Expired</p>
                                <p class="text-sm text-red-600 dark:text-red-500">Expired {{ DateHelper::diffForHumans($tokenExpiry) }} on {{ DateHelper::formatDateTime($tokenExpiry) }}</p>
                            </div>
                        </div>
                    </div>
                @elseif($isExpiringSoon)
                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900/50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-yellow-800 dark:text-yellow-400">Token Expiring Soon</p>
                                <p class="text-sm text-yellow-600 dark:text-yellow-500">Expires {{ DateHelper::diffForHumans($tokenExpiry) }} on {{ DateHelper::formatDateTime($tokenExpiry) }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-green-800 dark:text-green-400">Token Active</p>
                                @if($tokenExpiry)
                                    <p class="text-sm text-green-600 dark:text-green-500">Valid until {{ DateHelper::formatDateTime($tokenExpiry) }}</p>
                                @else
                                    <p class="text-sm text-green-600 dark:text-green-500">No expiration date set (long-lived token)</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Owner Information</h4>
                @if($socialAccount->customer)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                <span class="text-primary-600 dark:text-primary-400 font-bold">{{ strtoupper(substr($socialAccount->customer->firstName, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $socialAccount->customer->firstName }} {{ $socialAccount->customer->lastName }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $socialAccount->customer->email }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.customers.show', $socialAccount->customer->uuid) }}" 
                           class="px-4 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700 transition-colors">
                            View Profile
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Owner information not available</p>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Connected Pages ({{ $socialAccount->pages->count() }})</h4>
                <div class="space-y-3">
                    @forelse($socialAccount->pages as $page)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                @if($page->picture)
                                    <img src="{{ $page->picture }}" alt="{{ $page->name }}" class="w-10 h-10 rounded-full">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                        <span class="text-gray-600 dark:text-gray-300 font-medium">{{ strtoupper(substr($page->name ?? 'P', 0, 1)) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $page->name ?? 'Unnamed Page' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $page->pageId }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                @if($page->platform === 'facebook')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">Facebook</span>
                                @elseif($page->platform === 'instagram')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-pink-100 dark:bg-pink-900/30 text-pink-800 dark:text-pink-400">Instagram</span>
                                @elseif($page->platform === 'linkedin')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-sky-100 dark:bg-sky-900/30 text-sky-800 dark:text-sky-400">LinkedIn</span>
                                @endif
                                <a href="{{ route('admin.pages.show', $page) }}" 
                                   class="text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 text-sm font-medium">
                                    View
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">No pages connected to this account</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'InSocialWise Admin') }} - @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-dark">
    <div x-data class="min-h-screen">
        <div x-show="$store.sidebar.mobileOpen" 
             @click="$store.sidebar.closeMobile()" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="sidebar-overlay"></div>

        <aside :class="{ 
                   'w-64': $store.sidebar.expanded, 
                   'w-20': !$store.sidebar.expanded,
                   'translate-x-0': $store.sidebar.mobileOpen,
                   '-translate-x-full lg:translate-x-0': !$store.sidebar.mobileOpen
               }" 
               class="sidebar transition-all duration-300 ease-in-out">
            <div class="flex flex-col h-full relative z-10">
                <div class="flex items-center h-16 px-4 border-b border-slate-700/50">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div x-show="$store.sidebar.expanded" x-transition class="overflow-hidden">
                            <h1 class="text-lg font-bold text-white whitespace-nowrap">InSocialWise</h1>
                            <p class="text-xs text-slate-400">Admin Panel</p>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 py-4 space-y-1 overflow-y-auto scrollbar-thin">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       title="Dashboard">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span x-show="$store.sidebar.expanded" x-transition>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.master-control.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.master-control.*') ? 'active' : '' }}"
                       title="Master Control">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                        <span x-show="$store.sidebar.expanded" x-transition>Master Control</span>
                    </a>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">User Management</p>
                        <a href="{{ route('admin.customers.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                           title="Customers">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Customers</span>
                        </a>
                        <a href="{{ route('admin.pages.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}"
                           title="Connected Pages">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Connected Pages</span>
                        </a>
                        <a href="{{ route('admin.social-accounts.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.social-accounts.*') ? 'active' : '' }}"
                           title="Social Accounts">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Social Accounts</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">Billing & Subscriptions</p>
                        <a href="{{ route('admin.billing.overview') }}" 
                           class="nav-link {{ request()->routeIs('admin.billing.overview') ? 'active' : '' }}"
                           title="Billing Overview">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Billing Overview</span>
                        </a>
                        <a href="{{ route('admin.subscriptions.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.subscriptions.index') || request()->routeIs('admin.subscriptions.show') ? 'active' : '' }}"
                           title="Subscriptions">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Subscriptions</span>
                        </a>
                        <a href="{{ route('admin.subscription-plans.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.subscription-plans.*') ? 'active' : '' }}"
                           title="Subscription Plans">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Plans</span>
                        </a>
                        <a href="{{ route('admin.transactions.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}"
                           title="Transactions">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Transactions</span>
                        </a>
                        <a href="{{ route('admin.revenue') }}" 
                           class="nav-link {{ request()->routeIs('admin.revenue') ? 'active' : '' }}"
                           title="Revenue">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Revenue</span>
                        </a>
                        <a href="{{ route('admin.billing.activity-logs') }}" 
                           class="nav-link {{ request()->routeIs('admin.billing.activity-logs') || request()->routeIs('admin.billing.show-log') ? 'active' : '' }}"
                           title="Billing Activity">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Activity Logs</span>
                        </a>
                        <a href="{{ route('admin.billing.payment-methods') }}" 
                           class="nav-link {{ request()->routeIs('admin.billing.payment-methods') ? 'active' : '' }}"
                           title="Payment Methods">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Payment Methods</span>
                        </a>
                        <a href="{{ route('admin.notifications.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}"
                           title="Notification Queue">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Notifications</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">Content</p>
                        <a href="{{ route('admin.posts.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
                           title="Posts">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Posts</span>
                        </a>
                        <a href="{{ route('admin.comments.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}"
                           title="Comments">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Comments</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">Advertising</p>
                        <a href="{{ route('admin.campaigns.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}"
                           title="Campaigns">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Campaigns</span>
                        </a>
                        <a href="{{ route('admin.ads-accounts.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.ads-accounts.*') ? 'active' : '' }}"
                           title="Ad Accounts">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Ad Accounts</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">Analytics & Reports</p>
                        <a href="{{ route('admin.analytics.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}"
                           title="Analytics">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Analytics</span>
                        </a>
                        <a href="{{ route('admin.reports.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                           title="Reports">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Reports</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">Messaging</p>
                        <a href="{{ route('admin.inbox.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.inbox.*') ? 'active' : '' }}"
                           title="Inbox">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Inbox</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">Support</p>
                        <a href="{{ route('admin.knowledge-base.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.knowledge-base.*') ? 'active' : '' }}"
                           title="Knowledge Base">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Knowledge Base</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">Integrations</p>
                        <a href="{{ route('admin.webhooks.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.webhooks.*') ? 'active' : '' }}"
                           title="Webhooks">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Webhooks</span>
                        </a>
                        <a href="{{ route('admin.api-keys.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.api-keys.*') ? 'active' : '' }}"
                           title="API Keys">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>API Keys</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">Compliance</p>
                        <a href="{{ route('admin.compliance.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.compliance.*') ? 'active' : '' }}"
                           title="Compliance & Legal">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Compliance</span>
                        </a>
                    </div>

                    <div class="space-y-1">
                        <p x-show="$store.sidebar.expanded" class="nav-group-title">System</p>
                        @if(Auth::guard('admin')->user()->hasPermission('view_admin_users'))
                        <a href="{{ route('admin.admin-users.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.admin-users.*') ? 'active' : '' }}"
                           title="Admin Users">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m12.5-2.803a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Admin Users</span>
                        </a>
                        @endif
                        <a href="{{ route('admin.activities.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}"
                           title="Activity Logs">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Activity Logs</span>
                        </a>
                        <a href="{{ route('admin.alerts.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.alerts.*') ? 'active' : '' }}"
                           title="Alerts">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Alerts</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" 
                           class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                           title="Settings">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span x-show="$store.sidebar.expanded" x-transition>Settings</span>
                        </a>
                    </div>
                </nav>

                <div class="p-3 border-t border-slate-700/50">
                    <button @click="$store.sidebar.toggle()" 
                            class="hidden lg:flex w-full items-center justify-center p-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 transition-all duration-200"
                            title="Toggle sidebar">
                        <svg x-show="$store.sidebar.expanded" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                        </svg>
                        <svg x-show="!$store.sidebar.expanded" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <div :class="{ 'lg:ml-64': $store.sidebar.expanded, 'lg:ml-20': !$store.sidebar.expanded }" 
             class="flex-1 transition-all duration-300">
            <header class="sticky top-0 z-30 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <div class="flex items-center space-x-4">
                        <button @click="$store.sidebar.toggleMobile()" 
                                class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        
                        <div class="hidden sm:block">
                            @yield('breadcrumbs')
                        </div>
                        
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white sm:hidden">@yield('title', 'Dashboard')</h2>
                    </div>

                    <div class="flex items-center space-x-2 lg:space-x-4">
                        <button @click="$store.darkMode.toggle()" 
                                class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                title="Toggle dark mode">
                            <svg x-show="!$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg x-show="$store.darkMode.on" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        <div x-data="notifications()" class="relative">
                            <button @click="toggle()" 
                                    class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span x-show="unreadCount > 0" 
                                      class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"
                                      x-text="unreadCount"></span>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="close()" 
                                 x-transition
                                 class="dropdown-menu w-80">
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                    <button @click="markAllAsRead()" class="text-xs text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                        Mark all read
                                    </button>
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <template x-for="item in items" :key="item.id">
                                        <a href="#" @click.prevent="markAsRead(item.id)" 
                                           class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 last:border-0"
                                           :class="{ 'bg-primary-50 dark:bg-primary-900/20': !item.read }">
                                            <p class="text-sm text-gray-900 dark:text-white" x-text="item.title"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="item.time"></p>
                                        </a>
                                    </template>
                                </div>
                                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                                    <a href="#" class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400">View all notifications</a>
                                </div>
                            </div>
                        </div>

                        <div x-data="dropdown()" class="relative">
                            <button @click="toggle()" 
                                    class="flex items-center space-x-3 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-medium text-sm">
                                    {{ substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="hidden lg:block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                                </span>
                                <svg class="hidden lg:block w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div x-show="open" 
                                 @click.away="close()" 
                                 x-transition
                                 class="dropdown-menu">
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::guard('admin')->user()->email ?? '' }}</p>
                                </div>
                                <a href="{{ route('admin.profile.show') }}" class="dropdown-item flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    My Profile
                                </a>
                                <a href="{{ route('admin.profile.change-password') }}" class="dropdown-item flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item flex items-center w-full text-left text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-4 lg:p-6">
                <div class="page-enter">
                    @yield('content')
                </div>
            </main>
            
            @if(session('success') || session('error') || session('warning') || session('info'))
            <script>
                document.addEventListener('alpine:initialized', function() {
                    @if(session('success'))
                        Alpine.store('toast').success(@json(session('success')));
                    @endif
                    @if(session('error'))
                        Alpine.store('toast').error(@json(session('error')));
                    @endif
                    @if(session('warning'))
                        Alpine.store('toast').warning(@json(session('warning')));
                    @endif
                    @if(session('info'))
                        Alpine.store('toast').info(@json(session('info')));
                    @endif
                });
            </script>
            @endif
        </div>

        <div x-data class="toast-container">
            <template x-for="notification in $store.toast.notifications" :key="notification.id">
                <div class="toast"
                     :class="[
                         'toast-' + notification.type,
                         notification.entering ? 'toast-entering' : '',
                         notification.leaving ? 'toast-leaving' : '',
                         !notification.entering && !notification.leaving ? 'toast-visible' : ''
                     ]"
                     role="alert"
                     aria-live="assertive">
                    <div class="toast-content">
                        <template x-if="notification.type === 'success'">
                            <svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </template>
                        <template x-if="notification.type === 'error'">
                            <svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </template>
                        <template x-if="notification.type === 'warning'">
                            <svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </template>
                        <template x-if="notification.type === 'info'">
                            <svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </template>
                        <div class="toast-body">
                            <p class="toast-title" x-text="notification.title"></p>
                            <p class="toast-message" x-text="notification.message"></p>
                        </div>
                        <button x-show="notification.dismissible" 
                                @click="$store.toast.dismiss(notification.id)" 
                                class="toast-dismiss"
                                aria-label="Dismiss">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

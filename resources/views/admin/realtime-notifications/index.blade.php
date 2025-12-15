@extends('admin.layouts.app')

@section('title', 'Real-Time Notifications')

@section('content')
<div x-data="realtimeNotifications()" x-init="init()" class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Real-Time Notifications', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-600 rounded-xl flex items-center justify-center relative">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse"></span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Real-Time Notifications</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Live monitoring of system events and alerts</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button @click="toggleLive()" :class="isLive ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-600 hover:bg-gray-700'" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors">
                <span :class="isLive ? 'bg-green-400' : 'bg-gray-400'" class="w-2 h-2 rounded-full mr-2 animate-pulse"></span>
                <span x-text="isLive ? 'Live' : 'Paused'"></span>
            </button>
            <button @click="markAllRead()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Mark All Read
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Critical Alerts</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="stats.critical">0</p>
                </div>
                <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Warnings</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="stats.warnings">0</p>
                </div>
                <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Info</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="stats.info">0</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Success</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="stats.success">0</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Live Feed</h3>
                    <div class="flex items-center gap-2">
                        <select x-model="filter" class="text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="all">All Types</option>
                            <option value="critical">Critical</option>
                            <option value="warning">Warnings</option>
                            <option value="info">Info</option>
                            <option value="success">Success</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[600px] overflow-y-auto">
                <template x-for="notification in filteredNotifications" :key="notification.id">
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer" :class="{ 'bg-blue-50 dark:bg-blue-900/10': !notification.read }">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div :class="{
                                    'bg-red-100 dark:bg-red-900/30': notification.type === 'critical',
                                    'bg-amber-100 dark:bg-amber-900/30': notification.type === 'warning',
                                    'bg-blue-100 dark:bg-blue-900/30': notification.type === 'info',
                                    'bg-green-100 dark:bg-green-900/30': notification.type === 'success'
                                }" class="w-10 h-10 rounded-lg flex items-center justify-center">
                                    <template x-if="notification.type === 'critical'">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </template>
                                    <template x-if="notification.type === 'warning'">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </template>
                                    <template x-if="notification.type === 'info'">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </template>
                                    <template x-if="notification.type === 'success'">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </template>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.title"></p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400" x-text="notification.time"></span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="notification.message"></p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full" :class="{
                                        'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': notification.type === 'critical',
                                        'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400': notification.type === 'warning',
                                        'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400': notification.type === 'info',
                                        'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400': notification.type === 'success'
                                    }" x-text="notification.type"></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500" x-text="notification.source"></span>
                                </div>
                            </div>
                            <button @click.stop="dismissNotification(notification.id)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
                <div x-show="filteredNotifications.length === 0" class="p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">No notifications to display</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.webhook-logs.index') }}" class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Webhook Logs</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">View incoming webhooks</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.alerts.index') }}" class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">System Alerts</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Manage alert settings</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.audit-logs.index') }}" class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Audit Trail</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Security and access logs</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Notification Settings</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Sound Alerts</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Play sound for new alerts</p>
                        </div>
                        <button @click="settings.sound = !settings.sound" :class="settings.sound ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full transition-colors">
                            <span :class="settings.sound ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition mt-0.5 ml-0.5"></span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Desktop Notifications</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Show browser notifications</p>
                        </div>
                        <button @click="settings.desktop = !settings.desktop" :class="settings.desktop ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full transition-colors">
                            <span :class="settings.desktop ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition mt-0.5 ml-0.5"></span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Critical Only</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Only show critical alerts</p>
                        </div>
                        <button @click="settings.criticalOnly = !settings.criticalOnly" :class="settings.criticalOnly ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full transition-colors">
                            <span :class="settings.criticalOnly ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition mt-0.5 ml-0.5"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function realtimeNotifications() {
    return {
        isLive: true,
        filter: 'all',
        unreadCount: 0,
        notifications: [],
        stats: {
            critical: 0,
            warnings: 0,
            info: 0,
            success: 0
        },
        settings: {
            sound: true,
            desktop: false,
            criticalOnly: false
        },
        pollInterval: null,

        init() {
            this.loadNotifications();
            this.startPolling();
        },

        get filteredNotifications() {
            if (this.filter === 'all') return this.notifications;
            return this.notifications.filter(n => n.type === this.filter);
        },

        loadNotifications() {
            fetch('/admin/realtime-notifications/feed')
                .then(r => r.json())
                .then(data => {
                    this.notifications = data.notifications || [];
                    this.stats = data.stats || this.stats;
                    this.unreadCount = this.notifications.filter(n => !n.read).length;
                })
                .catch(console.error);
        },

        startPolling() {
            this.pollInterval = setInterval(() => {
                if (this.isLive) {
                    this.loadNotifications();
                }
            }, 5000);
        },

        toggleLive() {
            this.isLive = !this.isLive;
        },

        markAllRead() {
            fetch('/admin/realtime-notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => {
                this.notifications.forEach(n => n.read = true);
                this.unreadCount = 0;
            });
        },

        dismissNotification(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }
}
</script>
@endsection

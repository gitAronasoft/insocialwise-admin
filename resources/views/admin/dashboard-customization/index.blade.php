@extends('admin.layouts.app')

@section('title', 'Dashboard Customization')

@section('content')
<div x-data="dashboardCustomization()" x-init="init()" class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Customization', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Customization</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Drag and drop widgets to customize your dashboard</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button @click="resetLayout()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Layout
            </button>
            <button @click="saveLayout()" :disabled="saving" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 disabled:opacity-50">
                <svg x-show="!saving" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <svg x-show="saving" class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-text="saving ? 'Saving...' : 'Save Layout'"></span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Available Widgets</h3>
                <div class="space-y-3">
                    <template x-for="widget in availableWidgets" :key="widget.id">
                        <div draggable="true" @dragstart="dragStart($event, widget)" class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-move hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors border-2 border-dashed border-transparent hover:border-indigo-300 dark:hover:border-indigo-600">
                            <div class="flex items-center">
                                <div :class="widget.color" class="w-8 h-8 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="widget.icon"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="widget.name"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400" x-text="widget.size"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Dashboard Layout</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Drag widgets from the left panel or reorder existing widgets below</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 min-h-[400px] p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600"
                     @dragover.prevent
                     @drop="dropWidget($event)">

                    <template x-for="(widget, index) in layoutWidgets" :key="widget.id + '-' + index">
                        <div draggable="true" 
                             @dragstart="dragStartLayout($event, index)"
                             @dragend="dragEnd()"
                             :class="[widget.span, 'cursor-move group']"
                             class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div :class="widget.color" class="w-8 h-8 rounded-lg flex items-center justify-center mr-2">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="widget.icon"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="widget.name"></span>
                                    </div>
                                    <button @click="removeWidget(index)" class="opacity-0 group-hover:opacity-100 transition-opacity p-1 text-gray-400 hover:text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="h-20 bg-gray-100 dark:bg-gray-700/50 rounded-lg flex items-center justify-center">
                                    <span class="text-xs text-gray-400 dark:text-gray-500">Widget Preview</span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div x-show="layoutWidgets.length === 0" class="col-span-4 flex items-center justify-center h-40 text-gray-400 dark:text-gray-500">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                            </svg>
                            <p>Drop widgets here to build your dashboard</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Widget Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Default Time Period</label>
                        <select x-model="settings.defaultPeriod" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="7d">Last 7 Days</option>
                            <option value="30d">Last 30 Days</option>
                            <option value="90d">Last 90 Days</option>
                            <option value="1y">Last Year</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Refresh Interval</label>
                        <select x-model="settings.refreshInterval" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="0">Manual</option>
                            <option value="30">Every 30 seconds</option>
                            <option value="60">Every minute</option>
                            <option value="300">Every 5 minutes</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Show Animations</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Enable chart animations</p>
                        </div>
                        <button @click="settings.animations = !settings.animations" :class="settings.animations ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full transition-colors">
                            <span :class="settings.animations ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition mt-0.5 ml-0.5"></span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Compact Mode</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Use smaller widget sizes</p>
                        </div>
                        <button @click="settings.compact = !settings.compact" :class="settings.compact ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full transition-colors">
                            <span :class="settings.compact ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition mt-0.5 ml-0.5"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function dashboardCustomization() {
    return {
        saving: false,
        draggedWidget: null,
        draggedIndex: null,
        availableWidgets: [
            { id: 'revenue', name: 'Total Revenue', size: 'Small', span: 'col-span-1', color: 'bg-green-500', icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' },
            { id: 'mrr', name: 'MRR', size: 'Small', span: 'col-span-1', color: 'bg-indigo-500', icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' },
            { id: 'subscriptions', name: 'Active Subscriptions', size: 'Small', span: 'col-span-1', color: 'bg-blue-500', icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' },
            { id: 'churn', name: 'Churn Rate', size: 'Small', span: 'col-span-1', color: 'bg-amber-500', icon: 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' },
            { id: 'revenue-chart', name: 'Revenue Chart', size: 'Large', span: 'col-span-2', color: 'bg-purple-500', icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' },
            { id: 'health', name: 'Subscription Health', size: 'Medium', span: 'col-span-1', color: 'bg-cyan-500', icon: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z' },
            { id: 'activity', name: 'Recent Activity', size: 'Medium', span: 'col-span-1', color: 'bg-pink-500', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
            { id: 'customers', name: 'Customer Growth', size: 'Large', span: 'col-span-2', color: 'bg-teal-500', icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' }
        ],
        layoutWidgets: [],
        settings: {
            defaultPeriod: '30d',
            refreshInterval: '60',
            animations: true,
            compact: false
        },

        init() {
            this.loadLayout();
        },

        loadLayout() {
            const saved = localStorage.getItem('dashboardLayout');
            if (saved) {
                const data = JSON.parse(saved);
                this.layoutWidgets = data.widgets || [];
                this.settings = { ...this.settings, ...data.settings };
            } else {
                this.layoutWidgets = [
                    this.availableWidgets[0],
                    this.availableWidgets[1],
                    this.availableWidgets[2],
                    this.availableWidgets[3]
                ];
            }
        },

        dragStart(event, widget) {
            this.draggedWidget = { ...widget };
            event.dataTransfer.effectAllowed = 'copy';
        },

        dragStartLayout(event, index) {
            this.draggedIndex = index;
            event.dataTransfer.effectAllowed = 'move';
        },

        dragEnd() {
            this.draggedWidget = null;
            this.draggedIndex = null;
        },

        dropWidget(event) {
            event.preventDefault();
            if (this.draggedWidget) {
                this.layoutWidgets.push({ ...this.draggedWidget });
            }
            this.draggedWidget = null;
        },

        removeWidget(index) {
            this.layoutWidgets.splice(index, 1);
        },

        resetLayout() {
            this.layoutWidgets = [
                this.availableWidgets[0],
                this.availableWidgets[1],
                this.availableWidgets[2],
                this.availableWidgets[3]
            ];
            this.settings = {
                defaultPeriod: '30d',
                refreshInterval: '60',
                animations: true,
                compact: false
            };
        },

        async saveLayout() {
            this.saving = true;
            try {
                localStorage.setItem('dashboardLayout', JSON.stringify({
                    widgets: this.layoutWidgets,
                    settings: this.settings
                }));
                await fetch('/admin/dashboard-customization/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        widgets: this.layoutWidgets.map(w => w.id),
                        settings: this.settings
                    })
                });
                window.dispatchEvent(new CustomEvent('toast', { 
                    detail: { message: 'Dashboard layout saved successfully!', type: 'success' }
                }));
            } catch (error) {
                console.error('Failed to save layout:', error);
            } finally {
                this.saving = false;
            }
        }
    }
}
</script>
@endsection

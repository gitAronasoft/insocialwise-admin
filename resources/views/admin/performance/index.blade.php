@extends('admin.layouts.app')

@section('title', 'Performance Monitoring')

@section('content')
<div x-data="performanceMonitor()" x-init="init()" class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Performance Monitoring', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Performance Monitoring</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">System health and performance metrics</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <select x-model="timeRange" @change="loadMetrics()" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                <option value="1h">Last 1 Hour</option>
                <option value="6h">Last 6 Hours</option>
                <option value="24h">Last 24 Hours</option>
                <option value="7d">Last 7 Days</option>
                <option value="30d">Last 30 Days</option>
            </select>
            <button @click="loadMetrics()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Response Time</p>
                <div :class="metrics.response_time < 200 ? 'bg-green-100 dark:bg-green-900/30' : metrics.response_time < 500 ? 'bg-amber-100 dark:bg-amber-900/30' : 'bg-red-100 dark:bg-red-900/30'" class="p-2 rounded-lg">
                    <svg :class="metrics.response_time < 200 ? 'text-green-600 dark:text-green-400' : metrics.response_time < 500 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><span x-text="metrics.response_time"></span>ms</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Avg response time</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Request Rate</p>
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><span x-text="metrics.requests_per_min"></span>/min</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Requests per minute</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Error Rate</p>
                <div :class="metrics.error_rate < 1 ? 'bg-green-100 dark:bg-green-900/30' : metrics.error_rate < 5 ? 'bg-amber-100 dark:bg-amber-900/30' : 'bg-red-100 dark:bg-red-900/30'" class="p-2 rounded-lg">
                    <svg :class="metrics.error_rate < 1 ? 'text-green-600 dark:text-green-400' : metrics.error_rate < 5 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><span x-text="metrics.error_rate"></span>%</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Error percentage</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Uptime</p>
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white"><span x-text="metrics.uptime"></span>%</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">System uptime</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Database Performance</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Query Count</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total queries executed</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white" x-text="metrics.db.query_count.toLocaleString()"></span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Avg Query Time</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Average execution time</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white"><span x-text="metrics.db.avg_query_time"></span>ms</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Slow Queries</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Queries > 1 second</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white" x-text="metrics.db.slow_queries"></span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Active Connections</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Current DB connections</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white" x-text="metrics.db.connections"></span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Webhook Performance</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Processed</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Successfully processed</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-green-600 dark:text-green-400" x-text="metrics.webhooks.processed.toLocaleString()"></span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Failed</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Failed to process</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-red-600 dark:text-red-400" x-text="metrics.webhooks.failed.toLocaleString()"></span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Avg Processing Time</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Time to process webhook</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-gray-900 dark:text-white"><span x-text="metrics.webhooks.avg_time"></span>ms</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Pending Retry</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Awaiting retry</p>
                        </div>
                    </div>
                    <span class="text-lg font-semibold text-amber-600 dark:text-amber-400" x-text="metrics.webhooks.pending"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Endpoints</h3>
            <div class="space-y-3">
                <template x-for="(endpoint, index) in metrics.top_endpoints" :key="index">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-1 min-w-0 mr-4">
                            <span class="text-xs font-mono text-gray-600 dark:text-gray-400 truncate" x-text="endpoint.path"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400" x-text="endpoint.count + ' hits'"></span>
                            <span class="text-xs px-2 py-0.5 rounded-full" :class="endpoint.avg_time < 100 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : endpoint.avg_time < 300 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'" x-text="endpoint.avg_time + 'ms'"></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Error Distribution</h3>
            <div class="space-y-3">
                <template x-for="(error, index) in metrics.errors" :key="index">
                    <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex items-center">
                            <span class="w-8 h-8 flex items-center justify-center text-sm font-bold rounded-lg" :class="{
                                'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': error.code >= 500,
                                'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400': error.code >= 400 && error.code < 500
                            }" x-text="error.code"></span>
                            <span class="ml-3 text-sm text-gray-600 dark:text-gray-400" x-text="error.message"></span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="error.count"></span>
                    </div>
                </template>
                <div x-show="metrics.errors.length === 0" class="text-center py-4 text-gray-500 dark:text-gray-400 text-sm">
                    No errors in selected period
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">System Resources</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Memory Usage</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="metrics.system.memory + '%'"></span>
                    </div>
                    <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all" :class="metrics.system.memory < 70 ? 'bg-green-500' : metrics.system.memory < 90 ? 'bg-amber-500' : 'bg-red-500'" :style="'width: ' + metrics.system.memory + '%'"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600 dark:text-gray-400">CPU Usage</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="metrics.system.cpu + '%'"></span>
                    </div>
                    <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all" :class="metrics.system.cpu < 70 ? 'bg-green-500' : metrics.system.cpu < 90 ? 'bg-amber-500' : 'bg-red-500'" :style="'width: ' + metrics.system.cpu + '%'"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Disk Usage</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="metrics.system.disk + '%'"></span>
                    </div>
                    <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all" :class="metrics.system.disk < 70 ? 'bg-green-500' : metrics.system.disk < 90 ? 'bg-amber-500' : 'bg-red-500'" :style="'width: ' + metrics.system.disk + '%'"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function performanceMonitor() {
    return {
        timeRange: '24h',
        metrics: {
            response_time: 0,
            requests_per_min: 0,
            error_rate: 0,
            uptime: 99.9,
            db: {
                query_count: 0,
                avg_query_time: 0,
                slow_queries: 0,
                connections: 0
            },
            webhooks: {
                processed: 0,
                failed: 0,
                avg_time: 0,
                pending: 0
            },
            top_endpoints: [],
            errors: [],
            system: {
                memory: 0,
                cpu: 0,
                disk: 0
            }
        },

        init() {
            this.loadMetrics();
        },

        loadMetrics() {
            fetch('/admin/performance/metrics?range=' + this.timeRange)
                .then(r => r.json())
                .then(data => {
                    this.metrics = { ...this.metrics, ...data };
                })
                .catch(console.error);
        }
    }
}
</script>
@endsection

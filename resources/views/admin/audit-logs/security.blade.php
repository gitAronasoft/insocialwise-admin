@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')

@section('title', 'Security Overview')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'System', 'url' => null],
        ['label' => 'Audit Logs', 'url' => route('admin.audit-logs.index')],
        ['label' => 'Security Overview', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Security Overview</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitor login activity and security events (Last 7 days)</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-green-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Successful Logins</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ number_format($loginAttempts['successful']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-red-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Failed Attempts</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">{{ number_format($loginAttempts['failed']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-indigo-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Unique IPs</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($loginAttempts['unique_ips']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Security Alerts</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $securityAlerts->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Login Activity (7 Days)</h3>
            <div class="h-64" id="login-chart">
                <canvas id="loginChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Login Activity</h3>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($recentLogins as $login)
                    <div class="flex items-center p-3 rounded-lg {{ $login->action_type === 'login_failed' ? 'bg-red-50 dark:bg-red-900/10' : 'bg-gray-50 dark:bg-gray-700/50' }}">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $login->action_type === 'login_failed' ? 'bg-red-100 dark:bg-red-900/30' : 'bg-green-100 dark:bg-green-900/30' }}">
                            @if($login->action_type === 'login_failed')
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $login->admin_email }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $login->ip_address }} &bull; {{ DateHelper::diffForHumans($login->created_at) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">No recent login activity.</p>
                @endforelse
            </div>
        </div>
    </div>

    @if($suspiciousActivity->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Potentially Suspicious Activity
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">IPs with more than 5 warning/critical events in the last 7 days</p>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP Address</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Event Count</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($suspiciousActivity as $activity)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="font-mono text-sm text-gray-900 dark:text-white">{{ $activity->ip_address }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        {{ $activity->count }} events
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.audit-logs.index', ['ip_address' => $activity->ip_address]) }}" 
                                        class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                                        View Logs
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if($securityAlerts->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Security Alerts (7 Days)</h3>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @foreach($securityAlerts as $alert)
                    <div class="flex items-start p-4 rounded-lg {{ $alert->severity === 'critical' ? 'bg-red-50 dark:bg-red-900/10' : 'bg-yellow-50 dark:bg-yellow-900/10' }}">
                        <div class="flex-shrink-0">
                            @if($alert->severity === 'critical')
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $alert->action_label }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ DateHelper::diffForHumans($alert->created_at) }}</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $alert->description }}</p>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $alert->admin_email }} &bull; {{ $alert->ip_address }}
                            </div>
                        </div>
                        <a href="{{ route('admin.audit-logs.show', $alert) }}" class="ml-4 text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                            Details
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('loginChart');
        if (ctx) {
            const loginData = @json($loginsByDay);
            const failedData = @json($failedLoginsByDay);
            
            const labels = loginData.map(d => d.date);
            const successCounts = loginData.map(d => d.count);
            const failedCounts = labels.map(date => {
                const found = failedData.find(d => d.date === date);
                return found ? found.count : 0;
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Successful Logins',
                            data: successCounts,
                            backgroundColor: 'rgba(34, 197, 94, 0.8)',
                            borderRadius: 4,
                        },
                        {
                            label: 'Failed Attempts',
                            data: failedCounts,
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection

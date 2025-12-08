@extends('admin.layouts.app')

@section('title', 'Revenue Dashboard')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Subscriptions', 'url' => null], ['label' => 'Revenue', 'url' => null]
    ]" />
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Successful Transactions</p>
            <p class="text-3xl font-bold text-green-600">{{ number_format($transactionCount) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Monthly Recurring Revenue</p>
            <p class="text-3xl font-bold text-blue-600">${{ number_format($mrr, 2) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Transaction Value</p>
            <p class="text-3xl font-bold text-purple-600">${{ number_format($avgTransactionValue, 2) }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Revenue Trends</h3>
            <div class="flex space-x-2">
                <button type="button" id="dailyBtn" class="px-4 py-2 text-sm font-medium rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Daily
                </button>
                <button type="button" id="weeklyBtn" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Weekly
                </button>
                <button type="button" id="monthlyBtn" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Monthly
                </button>
            </div>
        </div>
        <div class="h-80">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Transaction Volume</h3>
            <div class="h-64">
                <canvas id="transactionChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Monthly Revenue Breakdown</h3>
            <div class="h-64">
                <canvas id="monthlyBarChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Transactions</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentTransactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                @if($transaction->customer)
                                    {{ $transaction->customer->firstName }} {{ $transaction->customer->lastName }}
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ strtoupper($transaction->currency ?? 'USD') }} {{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($transaction->status === 'succeeded') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @elseif($transaction->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @endif
                                ">{{ ucfirst($transaction->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $transaction->payment_method ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($transaction->receipt_url)
                                    <a href="{{ $transaction->receipt_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Receipt</a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No transactions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dailyData = @json($dailyRevenue);
    const weeklyData = @json($weeklyRevenue);
    const monthlyData = @json($monthlyRevenue);

    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#9CA3AF' : '#6B7280';
    const gridColor = isDarkMode ? '#374151' : '#E5E7EB';

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: isDarkMode ? '#1F2937' : '#FFFFFF',
                titleColor: isDarkMode ? '#F3F4F6' : '#111827',
                bodyColor: isDarkMode ? '#D1D5DB' : '#4B5563',
                borderColor: isDarkMode ? '#374151' : '#E5E7EB',
                borderWidth: 1,
                callbacks: {
                    label: function(context) {
                        return '$' + context.parsed.y.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    color: gridColor,
                    drawBorder: false
                },
                ticks: {
                    color: textColor
                }
            },
            y: {
                grid: {
                    color: gridColor,
                    drawBorder: false
                },
                ticks: {
                    color: textColor,
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    };

    const ctx = document.getElementById('revenueChart').getContext('2d');
    let revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dailyData.map(d => d.date),
            datasets: [{
                label: 'Revenue',
                data: dailyData.map(d => d.total),
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: chartOptions
    });

    function updateChart(data, labels) {
        revenueChart.data.labels = labels;
        revenueChart.data.datasets[0].data = data.map(d => d.total);
        revenueChart.update();
    }

    const dailyBtn = document.getElementById('dailyBtn');
    const weeklyBtn = document.getElementById('weeklyBtn');
    const monthlyBtn = document.getElementById('monthlyBtn');

    function setActiveButton(activeBtn) {
        [dailyBtn, weeklyBtn, monthlyBtn].forEach(btn => {
            btn.classList.remove('bg-indigo-600', 'text-white');
            btn.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        });
        activeBtn.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        activeBtn.classList.add('bg-indigo-600', 'text-white');
    }

    dailyBtn.addEventListener('click', function() {
        setActiveButton(this);
        updateChart(dailyData, dailyData.map(d => d.date));
    });

    weeklyBtn.addEventListener('click', function() {
        setActiveButton(this);
        updateChart(weeklyData, weeklyData.map(d => d.label));
    });

    monthlyBtn.addEventListener('click', function() {
        setActiveButton(this);
        updateChart(monthlyData, monthlyData.map(d => d.label));
    });

    const transactionCtx = document.getElementById('transactionChart').getContext('2d');
    new Chart(transactionCtx, {
        type: 'line',
        data: {
            labels: dailyData.map(d => d.date),
            datasets: [{
                label: 'Transactions',
                data: dailyData.map(d => d.count),
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 3
            }]
        },
        options: {
            ...chartOptions,
            scales: {
                ...chartOptions.scales,
                y: {
                    ...chartOptions.scales.y,
                    ticks: {
                        color: textColor,
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                ...chartOptions.plugins,
                tooltip: {
                    ...chartOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString() + ' transactions';
                        }
                    }
                }
            }
        }
    });

    const monthlyBarCtx = document.getElementById('monthlyBarChart').getContext('2d');
    new Chart(monthlyBarCtx, {
        type: 'bar',
        data: {
            labels: monthlyData.map(d => d.label),
            datasets: [{
                label: 'Revenue',
                data: monthlyData.map(d => d.total),
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                borderColor: '#6366F1',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: chartOptions
    });
});
</script>
@endsection

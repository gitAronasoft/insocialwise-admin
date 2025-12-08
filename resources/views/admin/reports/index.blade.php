@extends('admin.layouts.app')
@section('title', 'Reports & Analytics')
@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Reports', 'url' => null]
    ]" />
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reports & Analytics</h1>
        <p class="mt-1 text-gray-600 dark:text-gray-400">Generate and export custom reports with data analysis</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-6">Create Custom Report</h2>
        <form x-data="reportBuilder()" @submit.prevent="previewReport()" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Date From</label>
                    <input type="date" x-model="dateFrom" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Date To</label>
                    <input type="date" x-model="dateTo" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Metrics</label>
                <div class="space-y-2">
                    <template x-for="metric in ['customers', 'revenue', 'posts', 'subscriptions', 'pages', 'campaigns']">
                        <label class="flex items-center">
                            <input type="checkbox" :value="metric" x-model="metrics" class="rounded">
                            <span class="ml-2" x-text="metric.charAt(0).toUpperCase() + metric.slice(1)"></span>
                        </label>
                    </template>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Group By</label>
                <select x-model="groupBy" class="w-full px-3 py-2 border rounded-lg">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">Generate Report</button>
                <button type="button" @click="exportReport('csv')" class="btn btn-secondary">Export CSV</button>
            </div>
        </form>
    </div>
</div>
<script>
function reportBuilder() {
    return {
        dateFrom: new Date().toISOString().split('T')[0],
        dateTo: new Date().toISOString().split('T')[0],
        metrics: ['customers'],
        groupBy: 'monthly'
    }
}
</script>
@endsection

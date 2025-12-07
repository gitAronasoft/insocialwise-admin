@extends('admin.layouts.app')
@section('title', 'Compliance & Legal')
@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Compliance & Legal Management</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Pending Requests</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_requests'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Total Requests</p>
            <p class="text-3xl font-bold">{{ $stats['total_requests'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Active Policies</p>
            <p class="text-3xl font-bold text-green-600">{{ $stats['active_policies'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <p class="text-sm text-gray-600">Retention Rules</p>
            <p class="text-3xl font-bold">{{ $stats['retention_rules'] }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h2 class="text-lg font-bold mb-4">Policies</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.compliance.policies') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100">
                    Manage Policies
                </a>
                <a href="{{ route('admin.compliance.policies.create') }}" class="block p-3 bg-primary-50 dark:bg-primary-900/20 rounded hover:bg-primary-100 text-primary-600">
                    Create Policy
                </a>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h2 class="text-lg font-bold mb-4">Data Requests</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.compliance.data-requests') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100">
                    View Requests
                </a>
                <a href="{{ route('admin.compliance.retention-rules') }}" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded hover:bg-gray-100">
                    Retention Rules
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

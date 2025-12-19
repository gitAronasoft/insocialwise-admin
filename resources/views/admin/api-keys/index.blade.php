@extends('admin.layouts.app')
@use('App\Helpers\DateHelper')
@section('title', 'API Keys')
@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Api Keys', 'url' => null]
    ]" />
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">API Keys & Integration Settings</h1>
        <p class="mt-1 text-gray-600 dark:text-gray-400">Manage external service integrations and credentials</p>
    </div>
    @forelse($apiKeys as $groupKey => $group)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
            {{ $group['label'] }}
        </h2>
        <div class="space-y-4">
            @foreach($group['keys'] as $keyName => $keyConfig)
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <div class="flex-1">
                    <p class="font-medium">{{ $keyConfig['label'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $keyConfig['has_value'] ? '●●●●●●●●' : 'Not configured' }}
                        @if($keyConfig['updated_at'])
                            <span class="text-xs">Updated {{ DateHelper::diffForHumans($keyConfig['updated_at']) }}</span>
                        @endif
                    </p>
                </div>
                <div class="space-x-2">
                    @if($keyConfig['testable'])
                    <button onclick="testKey('{{ $keyName }}')" class="btn btn-sm btn-secondary">Test</button>
                    @endif
                    <button onclick="showKeyModal('{{ $keyName }}', '{{ $keyConfig['label'] }}')" class="btn btn-sm btn-primary">Edit</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <p class="text-gray-500">No API key groups configured</p>
    @endforelse
</div>
@endsection

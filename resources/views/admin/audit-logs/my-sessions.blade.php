@extends('admin.layouts.app')

@section('title', 'My Sessions')

@section('content')
<div class="space-y-6" x-data="{ revoking: false }">
    <x-breadcrumb :items="[
        ['label' => 'System', 'url' => null],
        ['label' => 'Audit Logs', 'url' => route('admin.audit-logs.index')],
        ['label' => 'My Sessions', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Active Sessions</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your login sessions across devices</p>
        </div>
        <button 
            @click="if(confirm('Revoke all other sessions? You will remain logged in on this device only.')) { 
                revoking = true;
                fetch('{{ route('admin.audit-logs.revoke-all-other') }}', {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'}
                }).then(r => r.json()).then(d => { 
                    revoking = false;
                    if(d.success) location.reload(); 
                    else alert(d.message); 
                })
            }"
            :disabled="revoking"
            class="btn btn-danger">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
            <span x-text="revoking ? 'Revoking...' : 'Revoke All Other Sessions'"></span>
        </button>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($sessions as $session)
                <div class="p-6 {{ $session->is_current ? 'bg-green-50 dark:bg-green-900/10' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($session->device_type === 'mobile')
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $session->device_info }}</h3>
                                    @if($session->is_current)
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            Current Session
                                        </span>
                                    @endif
                                    @php $badge = $session->status_badge; @endphp
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                        @if($badge['color'] === 'green') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @elseif($badge['color'] === 'red') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @endif">
                                        {{ $badge['label'] }}
                                    </span>
                                </div>
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-mono">{{ $session->ip_address }}</span>
                                    @if($session->location)
                                        <span class="mx-1">&bull;</span>
                                        <span>{{ $session->location }}</span>
                                    @endif
                                </div>
                                <div class="mt-2 flex flex-wrap gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    <div>
                                        <span class="font-medium">Logged in:</span> {{ $session->logged_in_at?->format('M d, Y H:i') }}
                                    </div>
                                    <div>
                                        <span class="font-medium">Last active:</span> {{ $session->last_activity_at?->diffForHumans() ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($session->status === 'active' && !$session->is_current)
                            <button 
                                @click="if(confirm('Revoke this session?')) { 
                                    fetch('{{ route('admin.audit-logs.revoke-session', $session) }}', {
                                        method: 'POST',
                                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'}
                                    }).then(r => r.json()).then(d => { if(d.success) location.reload(); else alert(d.message); })
                                }"
                                class="btn btn-danger btn-sm">
                                Revoke
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    No sessions found.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('title', 'Admin Sessions')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'System', 'url' => null],
        ['label' => 'Audit Logs', 'url' => route('admin.audit-logs.index')],
        ['label' => 'Admin Sessions', 'url' => null]
    ]" />

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Admin Sessions</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitor and manage all admin login sessions</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.audit-logs.my-sessions') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                My Sessions
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-green-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Active Sessions</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ number_format($stats['total_active']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Logins Today</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_today']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-indigo-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Unique IPs</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['unique_ips']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border-l-4 border-red-500">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Revoked</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">{{ number_format($stats['revoked_count']) }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div>
                <select name="admin_id" class="form-select w-full">
                    <option value="">All Admins</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                            {{ $admin->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="form-select w-full">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>
            </div>
            <div>
                <input type="text" name="ip_address" value="{{ request('ip_address') }}" placeholder="Filter by IP..."
                    class="form-input w-full">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">Filter</button>
                <a href="{{ route('admin.audit-logs.sessions') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Admin</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Device</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP Address</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Logged In</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Activity</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" x-data>
                    @forelse($sessions as $session)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                        <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">
                                            {{ $session->admin ? strtoupper(substr($session->admin->name, 0, 1)) : '?' }}
                                        </span>
                                    </div>
                                    <div class="ml-2">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $session->admin->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $session->admin->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                    @if($session->device_type === 'mobile')
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                    {{ $session->device_info }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm text-gray-600 dark:text-gray-400">{{ $session->ip_address }}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @php $badge = $session->status_badge; @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($badge['color'] === 'green') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($badge['color'] === 'red') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @endif">
                                    @if($session->is_current) (Current) @endif {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $session->logged_in_at?->format('M d, H:i') }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $session->last_activity_at?->diffForHumans() ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($session->status === 'active' && !$session->is_current)
                                    <button 
                                        @click="if(confirm('Revoke this session?')) { 
                                            fetch('{{ route('admin.audit-logs.revoke-session', $session) }}', {
                                                method: 'POST',
                                                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'}
                                            }).then(r => r.json()).then(d => { if(d.success) location.reload(); else alert(d.message); })
                                        }"
                                        class="text-red-600 dark:text-red-400 hover:underline text-sm">
                                        Revoke
                                    </button>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                No sessions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $sessions->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

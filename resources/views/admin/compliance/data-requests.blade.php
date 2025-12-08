@extends('admin.layouts.app')

@section('title', 'Data Requests')

@section('content')
<div class="space-y-6">
    <x-breadcrumb :items="[
        ['label' => 'Compliance', 'url' => null], ['label' => 'Data Requests', 'url' => null]
    ]" />
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Requests</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage GDPR data export, deletion, and access requests</p>
        </div>
        <a href="{{ route('admin.compliance.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.compliance.data-requests') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div>
                <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="all">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <select name="type" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="all">All Types</option>
                    <option value="export" {{ request('type') === 'export' ? 'selected' : '' }}>Export</option>
                    <option value="delete" {{ request('type') === 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="access" {{ request('type') === 'access' ? 'selected' : '' }}>Access</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Filter</button>
            @if(request('status') !== 'all' || request('type') !== 'all')
                <a href="{{ route('admin.compliance.data-requests') }}" class="text-gray-600 dark:text-gray-400 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">Clear</a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Request Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($requests as $request)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->user_email ?? 'N/A' }}</div>
                                @if($request->user_id)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $request->user_id }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($request->request_type === 'export') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                    @elseif($request->request_type === 'delete') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @endif
                                ">{{ ucfirst($request->request_type) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($request->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                    @elseif($request->status === 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                    @elseif($request->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                    @endif
                                ">{{ ucfirst($request->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $request->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" x-data="{ showActions: false }">
                                @if($request->status === 'pending' || $request->status === 'processing')
                                    <div class="relative">
                                        <button @click="showActions = !showActions" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Actions
                                            <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                        <div x-show="showActions" @click.away="showActions = false" 
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 z-10 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
                                            <div class="py-1">
                                                @if($request->status === 'pending')
                                                    <form action="{{ route('admin.compliance.data-requests.process', $request) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="action" value="process">
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                            Start Processing
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($request->status === 'processing')
                                                    <form action="{{ route('admin.compliance.data-requests.process', $request) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="action" value="complete">
                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-green-700 dark:text-green-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                            Mark Complete
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.compliance.data-requests.process', $request) }}" method="POST" x-data="{ showReject: false }">
                                                    @csrf
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="button" @click="showReject = true" class="block w-full text-left px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        Reject
                                                    </button>
                                                    <div x-show="showReject" class="px-4 py-2">
                                                        <textarea name="notes" rows="2" class="w-full text-sm rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800" placeholder="Reason..."></textarea>
                                                        <button type="submit" class="mt-2 w-full bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Confirm Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Completed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                <div class="py-8">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-4 text-gray-500 dark:text-gray-400">No data requests found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

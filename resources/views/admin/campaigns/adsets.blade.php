@extends('admin.layouts.app')

@section('title', 'Ad Sets')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Ad Sets</h3>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.adsets.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <div>
                <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Active</option>
                    <option value="PAUSED" {{ request('status') === 'PAUSED' ? 'selected' : '' }}>Paused</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Daily Budget</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($adsets as $adset)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $adset->adsets_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $adset->campaign->campaign_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $adset->campaign->customer->firstName ?? 'N/A' }} {{ $adset->campaign->customer->lastName ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($adset->adsets_status === 'ACTIVE') bg-green-100 text-green-800
                                    @elseif($adset->adsets_status === 'PAUSED') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif
                                ">{{ $adset->adsets_status ?? 'Unknown' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($adset->adsets_daily_budget ?? 0, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $adset->createdAt ? $adset->createdAt->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">No ad sets found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($adsets->hasPages())
        <div class="mt-4">
            {{ $adsets->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

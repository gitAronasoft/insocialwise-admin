@extends('admin.layouts.app')

@section('title', 'Page Scores')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Page Performance Scores</h3>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Page</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Overall</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Content</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Engagement</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Growth</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Consistency</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pageScores as $pageScore)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900">
                                {{ $pageScore->customer->firstName ?? 'N/A' }} {{ $pageScore->customer->lastName ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $pageScore->page->pageName ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($pageScore->platform) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-900">{{ $pageScore->overall_score }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $pageScore->content_score }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $pageScore->engagement_score }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $pageScore->growth_score }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $pageScore->consistency_score }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                No page score data available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pageScores->hasPages())
        <div class="mt-4">
            {{ $pageScores->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

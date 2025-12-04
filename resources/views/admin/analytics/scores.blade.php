@extends('admin.layouts.app')

@section('title', 'Social Media Scores')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Social Media Scores</h3>
    </div>

    @if($averageScores)
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Avg Overall Score</p>
            <p class="text-2xl font-bold text-blue-600">{{ number_format($averageScores->avg_overall, 1) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Avg Content Score</p>
            <p class="text-2xl font-bold text-green-600">{{ number_format($averageScores->avg_content, 1) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Avg Engagement</p>
            <p class="text-2xl font-bold text-purple-600">{{ number_format($averageScores->avg_engagement, 1) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Avg Growth</p>
            <p class="text-2xl font-bold text-orange-600">{{ number_format($averageScores->avg_growth, 1) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-medium text-gray-500">Avg Consistency</p>
            <p class="text-2xl font-bold text-red-600">{{ number_format($averageScores->avg_consistency, 1) }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">User Scores</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Overall</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Content</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Engagement</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Growth</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Consistency</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scores as $score)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900">
                                {{ $score->customer->firstName ?? 'N/A' }} {{ $score->customer->lastName ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($score->platform) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-900">{{ $score->overall_score }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $score->content_score }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $score->engagement_score }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $score->growth_score }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $score->consistency_score }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No score data available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($scores->hasPages())
        <div class="mt-4">
            {{ $scores->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@props([
    'id' => 'data-table',
    'endpoint' => '',
    'columns' => [],
    'searchable' => true,
    'searchPlaceholder' => 'Search...',
    'bulkActions' => [],
    'bulkDeleteUrl' => null,
    'exportUrl' => null,
    'filters' => [],
    'defaultSort' => '',
    'defaultSortDirection' => 'desc',
    'perPage' => 15,
])

<div
    x-data="dataTable({
        endpoint: '{{ $endpoint }}',
        defaultSort: '{{ $defaultSort }}',
        defaultSortDirection: '{{ $defaultSortDirection }}',
        perPage: {{ $perPage }},
        filters: {{ json_encode(collect($filters)->mapWithKeys(fn($f, $k) => [$k => request($k, '')])->toArray()) }}
    })"
    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700"
>
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center gap-4">
            @if($searchable)
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input
                        type="text"
                        x-model="search"
                        @input="onSearch"
                        placeholder="{{ $searchPlaceholder }}"
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    >
                </div>
            </div>
            @endif
            
            {{ $toolbar ?? '' }}
            
            <div class="flex items-center gap-2">
                <select
                    x-model.number="perPage"
                    class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm py-2 pl-3 pr-8 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                >
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                
                <button
                    @click="resetFilters"
                    class="px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                    title="Reset filters"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>
        
        <div x-show="hasSelected" x-cloak class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <span class="text-sm text-gray-600 dark:text-gray-400">
                <span x-text="selectedCount"></span> item(s) selected
            </span>
            
            @if(count($bulkActions) > 0)
            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors"
                >
                    Bulk Actions
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div
                    x-show="open"
                    @click.away="open = false"
                    x-cloak
                    class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
                >
                    @foreach($bulkActions as $action)
                        @if(isset($action['type']) && $action['type'] === 'delete')
                        <button
                            @click="executeBulkAction('{{ $action['action'] }}', '{{ $action['url'] }}', '{{ $action['confirm'] ?? 'Are you sure you want to delete the selected items?' }}'); open = false"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            {{ $action['label'] }}
                        </button>
                        @elseif(isset($action['type']) && $action['type'] === 'export')
                        <button
                            @click="exportSelected('{{ $action['url'] }}'); open = false"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            {{ $action['label'] }}
                        </button>
                        @else
                        <button
                            @click="executeBulkAction('{{ $action['action'] }}', '{{ $action['url'] }}', '{{ $action['confirm'] ?? '' }}'); open = false"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            {{ $action['label'] }}
                        </button>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
            
            <button
                @click="selected = []; selectAll = false"
                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
            >
                Clear selection
            </button>
        </div>
    </div>
    
    <div class="relative">
        <div
            x-show="loading"
            x-cloak
            class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 flex items-center justify-center z-10"
        >
            <div class="w-8 h-8 border-4 border-primary-200 border-t-primary-600 rounded-full animate-spin"></div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        @if(count($bulkActions) > 0)
                        <th class="px-4 py-3 w-12">
                            <input
                                type="checkbox"
                                x-model="selectAll"
                                class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-primary-600 focus:ring-primary-500 dark:bg-gray-700"
                            >
                        </th>
                        @endif
                        
                        @foreach($columns as $column)
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            @if(isset($column['sortable']) && $column['sortable'])
                            <button
                                @click="sort('{{ $column['key'] }}')"
                                class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-gray-100 transition-colors"
                            >
                                {{ $column['label'] }}
                                <span class="text-gray-400">
                                    <template x-if="sortColumn !== '{{ $column['key'] }}'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </template>
                                    <template x-if="sortColumn === '{{ $column['key'] }}' && sortDirection === 'asc'">
                                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        </svg>
                                    </template>
                                    <template x-if="sortColumn === '{{ $column['key'] }}' && sortDirection === 'desc'">
                                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </template>
                                </span>
                            </button>
                            @else
                            {{ $column['label'] }}
                            @endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <template x-if="data.length === 0 && !loading">
                        <tr>
                            <td colspan="{{ count($columns) + (count($bulkActions) > 0 ? 1 : 0) }}" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">No data found</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Try adjusting your search or filters</p>
                                </div>
                            </td>
                        </tr>
                    </template>
                    
                    <template x-for="item in data" :key="item.id">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            @if(count($bulkActions) > 0)
                            <td class="px-4 py-3">
                                <input
                                    type="checkbox"
                                    :checked="isSelected(item.id)"
                                    @change="toggleSelect(item.id)"
                                    class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-primary-600 focus:ring-primary-500 dark:bg-gray-700"
                                >
                            </td>
                            @endif
                            
                            {{ $row }}
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 flex flex-wrap items-center justify-between gap-4">
        <div class="text-sm text-gray-600 dark:text-gray-400" x-text="paginationInfo"></div>
        
        <nav class="flex items-center gap-1">
            <button
                @click="prevPage"
                :disabled="currentPage === 1"
                class="px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <template x-for="page in visiblePages" :key="page">
                <template x-if="page === '...'">
                    <span class="px-3 py-1.5 text-sm text-gray-400">...</span>
                </template>
                <template x-if="page !== '...'">
                    <button
                        @click="goToPage(page)"
                        :class="page === currentPage
                            ? 'bg-primary-600 text-white'
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'"
                        class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors"
                        x-text="page"
                    ></button>
                </template>
            </template>
            
            <button
                @click="nextPage"
                :disabled="currentPage === lastPage"
                class="px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </nav>
    </div>
</div>

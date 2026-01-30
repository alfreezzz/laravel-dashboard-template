{{--
    Component: data-table
    Usage: <x-data-table :items="$items" :columns="$columns" />
    Props:
        - items (required): Collection|Array of items to display.
        - columns (required): Array of column definitions. Each column can be:
                ['label' => 'Header', 'key' => 'field'] or ['label' => 'Header', 'render' => fn($item, $key) => '...']
        - emptyMessage (optional): string - message when there is no data (default: 'Tidak ada data').
        - actions (optional): closure($item) or null - render action buttons for each row.
    Notes:
        - Pagination is driven by request('page') and request('per_page'). The component computes offset.
        - Column render closures receive ($item, $key) where $key is the global index (offset + local index).
--}}
@props(['items', 'columns' => [], 'emptyMessage' => 'Tidak ada data', 'actions' => null])

@php
    $perPage = request('per_page', 25);
    $currentPage = request('page', 1);
    $totalItems = $items->count();
    $totalPages = ceil($totalItems / $perPage);
    $offset = ($currentPage - 1) * $perPage;
    $paginatedItems = $items->slice($offset, $perPage);
    $startItem = $totalItems > 0 ? $offset + 1 : 0;
    $endItem = min($offset + $perPage, $totalItems);
@endphp

<div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
    <!-- Per Page Selector -->
    <div class="px-4 sm:px-6 py-4 border-b border-slate-200 dark:border-slate-700 space-y-3 sm:space-y-0 sm:flex sm:items-center sm:justify-between sm:flex-wrap sm:gap-4">
        <div class="flex items-center gap-2">
            <label for="per_page" class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">Tampilkan</label>
            <select id="per_page" name="per_page" onchange="window.location.href = '?per_page=' + this.value + '&page=1'" class="px-2 sm:px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-xs sm:text-sm">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">data per halaman</span>
        </div>
        <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            Menampilkan <span class="font-medium">{{ $startItem }}</span> sampai <span class="font-medium">{{ $endItem }}</span> dari <span class="font-medium">{{ $totalItems }}</span> data
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900">
                    @foreach($columns as $column)
                        <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ $column['label'] ?? '' }}
                        </th>
                    @endforeach
                    @if($actions)
                        <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($paginatedItems as $key => $item)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                        @foreach($columns as $column)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">
                                @if(isset($column['render']))
                                    {!! $column['render']($item, $key) !!}
                                @else
                                    {{ data_get($item, $column['key'] ?? '') ?? '-' }}
                                @endif
                            </td>
                        @endforeach
                        @if($actions)
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {!! $actions($item) !!}
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + ($actions ? 1 : 0) }}" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                            {{ $emptyMessage }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    @if($totalPages > 1)
        <div class="px-4 sm:px-6 py-4 border-t border-slate-200 dark:border-slate-700 space-y-3 sm:space-y-0">
            <!-- Mobile: Previous/Next only -->
            <div class="sm:hidden flex items-center justify-center gap-2">
                <!-- Previous Button -->
                @if($currentPage > 1)
                    <a href="?page={{ $currentPage - 1 }}&per_page={{ $perPage }}" class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition text-xs sm:text-sm font-medium">
                        ← Sebelumnya
                    </a>
                @else
                    <span class="px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 dark:text-slate-500 text-xs sm:text-sm font-medium cursor-not-allowed">
                        ← Sebelumnya
                    </span>
                @endif

                <!-- Current page display -->
                <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 font-medium">
                    {{ $currentPage }} / {{ $totalPages }}
                </span>

                <!-- Next Button -->
                @if($currentPage < $totalPages)
                    <a href="?page={{ $currentPage + 1 }}&per_page={{ $perPage }}" class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition text-xs sm:text-sm font-medium">
                        Berikutnya →
                    </a>
                @else
                    <span class="px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 dark:text-slate-500 text-xs sm:text-sm font-medium cursor-not-allowed">
                        Berikutnya →
                    </span>
                @endif
            </div>

            <!-- Tablet and Desktop: Full pagination -->
            <div class="hidden sm:flex sm:items-center sm:justify-center sm:gap-2">
                <!-- Previous Button -->
                @if($currentPage > 1)
                    <a href="?page={{ $currentPage - 1 }}&per_page={{ $perPage }}" class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition text-sm font-medium">
                        ← Sebelumnya
                    </a>
                @else
                    <span class="px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 dark:text-slate-500 text-sm font-medium cursor-not-allowed">
                        ← Sebelumnya
                    </span>
                @endif

                <!-- Page Numbers -->
                <div class="flex items-center gap-1">
                    @php
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);
                    @endphp

                    @if($startPage > 1)
                        <a href="?page=1&per_page={{ $perPage }}" class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition text-sm">1</a>
                        @if($startPage > 2)
                            <span class="px-3 py-2 text-slate-500 dark:text-slate-400">...</span>
                        @endif
                    @endif

                    @for($page = $startPage; $page <= $endPage; $page++)
                        @if($page == $currentPage)
                            <span class="px-3 py-2 border border-blue-500 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-medium">{{ $page }}</span>
                        @else
                            <a href="?page={{ $page }}&per_page={{ $perPage }}" class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition text-sm">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($endPage < $totalPages)
                        @if($endPage < $totalPages - 1)
                            <span class="px-3 py-2 text-slate-500 dark:text-slate-400">...</span>
                        @endif
                        <a href="?page={{ $totalPages }}&per_page={{ $perPage }}" class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition text-sm">{{ $totalPages }}</a>
                    @endif
                </div>

                <!-- Next Button -->
                @if($currentPage < $totalPages)
                    <a href="?page={{ $currentPage + 1 }}&per_page={{ $perPage }}" class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition text-sm font-medium">
                        Berikutnya →
                    </a>
                @else
                    <span class="px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 dark:text-slate-500 text-sm font-medium cursor-not-allowed">
                        Berikutnya →
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>

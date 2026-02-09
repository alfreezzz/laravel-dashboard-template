{{--
    Component: table-row-actions
    Usage: <x-table.table-row-actions :showUrl="route('...')" :editUrl="..." :deleteUrl="..." :extraActions="$extra" />
    Props:
        - showUrl (optional): string - URL to view details.
        - editUrl (optional): string - URL to edit.
        - deleteUrl (optional): string - URL to submit DELETE to (form will be rendered).
        - deleteMessage (optional): string - confirmation message for delete action.
        - extraActions (optional): array - each item: ['url'=>'', 'icon'=>rawSvgOrHtml, 'color'=>'slate-600', 'label'=>'', 'attrs'=>'']
    Notes:
        - If a prop is omitted or null, the corresponding action will not be rendered.
        - Tooltips use fixed positioning to avoid overflow issues.
--}}
@props([
    'editUrl' => null,
    'deleteUrl' => null,
    'showUrl' => null,
    'deleteMessage' => 'Yakin ingin menghapus data ini?',
    'extraActions' => [] // array of ['url' => '', 'icon' => '', 'color' => '', 'label' => '', 'attrs' => '']
])

<div class="flex items-center justify-center gap-2">
    {{-- Detail --}}
    @if($showUrl)
        <div class="relative inline-flex" 
             x-data="{ tooltip: false }"
             @mouseenter="tooltip = true"
             @mouseleave="tooltip = false">
            <a href="{{ $showUrl }}" 
               class="p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition inline-flex items-center justify-center">
                <svg class="w-5 h-5 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
            <x-tooltip :show="'tooltip'">Detail</x-tooltip>
        </div>
    @endif

    {{-- Edit --}}
    @if($editUrl)
        <div class="relative inline-flex" 
             x-data="{ tooltip: false }"
             @mouseenter="tooltip = true"
             @mouseleave="tooltip = false">
            <a href="{{ $editUrl }}" 
               class="p-2 rounded-md hover:bg-amber-100 dark:hover:bg-amber-900 transition inline-flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </a>
            <x-tooltip :show="'tooltip'">Edit</x-tooltip>
        </div>
    @endif

    {{-- Delete --}}
    @if($deleteUrl)
        <div class="relative inline-flex" 
             x-data="{ tooltip: false }"
             @mouseenter="tooltip = true"
             @mouseleave="tooltip = false">
            <form action="{{ $deleteUrl }}" method="POST" onsubmit="return confirm('{{ $deleteMessage }}')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="p-2 rounded-md hover:bg-red-100 dark:hover:bg-red-900 transition inline-flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z"/>
                    </svg>
                </button>
            </form>
            <x-tooltip :show="'tooltip'">Hapus</x-tooltip>
        </div>
    @endif

    {{-- Extra actions --}}
    @foreach($extraActions as $act)
        @php
            $url = $act['url'] ?? '#';
            $icon = $act['icon'] ?? null;
            $color = $act['color'] ?? 'slate-600';
            $label = $act['label'] ?? '';
            $attrs = $act['attrs'] ?? '';
        @endphp
        <div class="relative inline-flex" 
             x-data="{ tooltip: false }"
             @mouseenter="tooltip = true"
             @mouseleave="tooltip = false">
            <a href="{{ $url }}" 
               class="p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition inline-flex items-center justify-center" 
               {!! $attrs !!}>
                @if($icon)
                    {!! $icon !!}
                @else
                    <svg class="w-5 h-5 text-{{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                    </svg>
                @endif
            </a>
            @if($label)
                <x-tooltip :show="'tooltip'">{{ $label }}</x-tooltip>
            @endif
        </div>
    @endforeach
</div>
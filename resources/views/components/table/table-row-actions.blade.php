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
    'extraActions' => []
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
             x-data="{
                 tooltip: false,
                 modal: false,
                 submit() {
                     this.modal = false;
                     this.$refs.deleteForm.submit();
                 }
             }"
             @mouseenter="tooltip = true"
             @mouseleave="tooltip = false">

            {{-- Form --}}
            <form x-ref="deleteForm" action="{{ $deleteUrl }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

            {{-- Trigger Button --}}
            <button type="button"
                    @click="modal = true; tooltip = false"
                    class="p-2 rounded-md hover:bg-red-100 dark:hover:bg-red-900 transition inline-flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z"/>
                </svg>
            </button>

            <x-tooltip :show="'tooltip'">Hapus</x-tooltip>

            {{-- Modal --}}
            <div x-show="modal"
                 x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 @keydown.escape.window="modal = false">

                {{-- Backdrop --}}
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                     @click="modal = false"></div>

                {{-- Panel --}}
                <div class="relative w-full max-w-sm bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 p-6 space-y-4"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    {{-- Icon --}}
                    <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z"/>
                        </svg>
                    </div>

                    {{-- Text --}}
                    <div class="text-center space-y-1">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Hapus Data</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $deleteMessage }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-2">
                        <button @click="modal = false"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">
                            Batal
                        </button>
                        <button @click="submit()"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-xl shadow transition">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Extra actions --}}
    @foreach($extraActions as $index => $act)
        @php
            $url = $act['url'] ?? '#';
            $icon = $act['icon'] ?? null;
            $color = $act['color'] ?? 'slate-600';
            $label = $act['label'] ?? '';
            $attrs = $act['attrs'] ?? '';
            $method = $act['method'] ?? null;
        @endphp
        <div class="relative inline-flex" 
             x-data="{ tooltip: false }"
             @mouseenter="tooltip = true"
             @mouseleave="tooltip = false">

            @if($method && in_array(strtoupper($method), ['PATCH','PUT','DELETE','POST']))
                {{-- build hidden form for action --}}
                <form x-ref="extraForm{{ $index }}" action="{{ $url }}" method="POST" class="hidden">
                    @csrf
                    @method($method)
                </form>
                <a href="#" @click.prevent="$refs.extraForm{{ $index }}.submit()"
                   class="p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition inline-flex items-center justify-center" 
                   {!! $attrs !!}>
            @else
                <a href="{{ $url }}" 
                   class="p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition inline-flex items-center justify-center" 
                   {!! $attrs !!}>
            @endif

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
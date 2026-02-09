{{--
    Component: tooltip
    Usage: 
        <div x-data="{ tooltip: false }" @mouseenter="tooltip = true" @mouseleave="tooltip = false">
            <button>Hover me</button>
            <x-tooltip :show="'tooltip'" position="top">Tooltip text</x-tooltip>
        </div>
    Props:
        - show (required): string - Alpine.js variable name to control visibility (e.g., 'tooltip').
        - position (optional): string - one of 'top', 'bottom', 'left', 'right' (default: 'top').
        - arrow (optional): bool - whether to show arrow (default: true).
        - zIndex (optional): string - z-index value (default: '9999').
    Slot:
        - default: tooltip content/text
--}}
@props([
    'show' => 'tooltip',
    'position' => 'top',
    'arrow' => true,
    'zIndex' => '9999'
])

@php
    $positionClasses = match($position) {
        'top' => '-top-10 left-1/2 -translate-x-1/2',
        'bottom' => '-bottom-10 left-1/2 -translate-x-1/2',
        'left' => 'top-1/2 -translate-y-1/2 -left-24 right-auto',
        'right' => 'top-1/2 -translate-y-1/2 -right-24 left-auto',
        default => '-top-10 left-1/2 -translate-x-1/2',
    };
    
    $arrowClasses = match($position) {
        'top' => 'absolute top-full left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-slate-900 dark:border-t-slate-700',
        'bottom' => 'absolute bottom-full left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-slate-900 dark:border-b-slate-700',
        'left' => 'absolute left-full top-1/2 -translate-y-1/2 w-0 h-0 border-t-4 border-b-4 border-l-4 border-transparent border-l-slate-900 dark:border-l-slate-700',
        'right' => 'absolute right-full top-1/2 -translate-y-1/2 w-0 h-0 border-t-4 border-b-4 border-r-4 border-transparent border-r-slate-900 dark:border-r-slate-700',
        default => 'absolute top-full left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-slate-900 dark:border-t-slate-700',
    };
@endphp

<div x-show="{{ $show }}"
     x-transition:enter="transition ease-out duration-100"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-75"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     style="display: none;"
     class="absolute {{ $positionClasses }} px-3 py-1.5 bg-slate-900 dark:bg-slate-700 text-white text-xs rounded-md shadow-lg whitespace-nowrap pointer-events-none z-[{{ $zIndex }}]">
    <div class="relative">
        {{ $slot }}
        @if($arrow)
            <div class="{{ $arrowClasses }}"></div>
        @endif
    </div>
</div>
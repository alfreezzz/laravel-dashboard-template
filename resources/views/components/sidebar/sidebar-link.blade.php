{{--
    Component: sidebar-link
    Usage: 
        <x-sidebar.sidebar-link href="/" label="Beranda" :active="true">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </x-slot:icon>
        </x-sidebar.sidebar-link>
    Props:
        - href (required): string - link URL.
        - label (required): string - text shown.
        - active (optional): bool - whether link is active (default: false).
    Slots:
        - icon (required): HTML/SVG icon component.
--}}
@props(['href', 'label', 'active' => false])

<a href="{{ $href }}" 
   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ $active ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-semibold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}"
   :class="!sidebarOpen && 'justify-center lg:justify-center'"
   x-data="{ showTooltip: false }"
   @mouseenter="showTooltip = !sidebarOpen"
   @mouseleave="showTooltip = false">
    {{ $icon }}
    <span x-show="sidebarOpen" class="transition-opacity duration-300">{{ $label }}</span>
    
    {{-- Tooltip saat sidebar ditutup --}}
    <div x-show="showTooltip" 
         x-transition
         class="hidden lg:block fixed left-24 px-3 py-2 bg-slate-900 dark:bg-slate-700 text-white text-sm rounded-lg shadow-lg whitespace-nowrap pointer-events-none z-50"
         style="margin-top: 0;">
        {{ $label }}
    </div>
</a>
{{--
    Component: navbar
    Usage: include in layout via <x-navbar />
    Props: none (this navbar relies on Alpine state such as `sidebarOpen` present in the parent layout).
    Notes:
        - The date/time is rendered using server time in Asia/Jakarta timezone.
--}}
<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white dark:bg-slate-900 shadow-sm border-b border-slate-200 dark:border-slate-800">
    <div class="py-4 pr-6 transition-all duration-300"
        :class="sidebarOpen ? 'pl-7' : 'pl-5'"
    >
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <!-- Sidebar Toggle Button (all screen sizes) -->
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition" title="Toggle Sidebar">
                    <svg class="w-6 h-6 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                    POS Toko
                </h1>
            </div>
            
            <div class="hidden sm:block sm:text-sm text-slate-600 dark:text-slate-400">
                {{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
            </div>
        </div>
    </div>
</nav>

{{--
    Component: sidebar
    Usage: <x-sidebar.sidebar />
    Props: none (this component renders the application sidebar and its links).
    Notes:
        - The component expects parent layout to provide Alpine state `sidebarOpen`.
--}}
<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-40 bg-white dark:bg-slate-900 shadow-xl border-r border-slate-200 dark:border-slate-800 transition-all duration-300 transform" 
     :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-64 -translate-x-full lg:w-20 lg:translate-x-0'" 
     style="margin-top: 73px; height: calc(100vh - 73px);">
    <!-- Sidebar Content -->
    <div class="h-full overflow-y-auto">
        <div class="p-6 space-y-2" :class="!sidebarOpen && 'lg:px-3'">
            <nav class="space-y-1">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <x-sidebar.sidebar-link href="{{ route('admin.dashboard') }}" label="Beranda" :active="request()->routeIs('admin.dashboard')">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </x-slot:icon>
                        </x-sidebar.sidebar-link>

                        <x-sidebar.sidebar-link href="{{ route('categories.index') }}" label="Kategori" :active="request()->routeIs('categories.*')">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </x-slot:icon>
                        </x-sidebar.sidebar-link>

                        <x-sidebar.sidebar-link href="{{ route('items.index') }}" label="Barang" :active="request()->routeIs('items.*')">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4M4 7l8 4m-8-4v10l8 4m0-10v10" />
                                </svg>
                            </x-slot:icon>
                        </x-sidebar.sidebar-link>

                        <x-sidebar.sidebar-link href="{{ route('users.index') }}" label="Pengguna" :active="request()->routeIs('users.*')">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Primary user -->
                                    <circle cx="9" cy="7" r="3" />
                                    <path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                                    <!-- Secondary user (behind/right) -->
                                    <path d="M16 3.13a4 4 0 010 7.75" />
                                    <path d="M21 21v-2a4 4 0 00-3-3.87" />
                                </svg>
                            </x-slot:icon>
                        </x-sidebar.sidebar-link>

                        <x-sidebar.sidebar-link href="{{ route('transactions.index') }}" label="Penjualan" :active="request()->routeIs('transactions.*')">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </x-slot:icon>
                        </x-sidebar.sidebar-link>

                    @elseif (auth()->user()->role === 'user')
                        <x-sidebar.sidebar-link href="{{ route('user.dashboard') }}" label="Beranda" :active="request()->routeIs('user.dashboard')">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </x-slot:icon>
                        </x-sidebar.sidebar-link>
                    @endif
                @endauth
            </nav>
        </div>
    </div>
</div>
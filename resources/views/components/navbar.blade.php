<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white dark:bg-slate-900 shadow-sm border-b border-slate-200 dark:border-slate-800">
    <div class="py-4 pr-4 sm:pr-6 transition-all duration-300"
        :class="sidebarOpen ? 'pl-7' : 'pl-5'"
    >
        <div class="flex items-center justify-between">

            {{-- Kiri: Toggle + App Name --}}
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition"
                    title="Toggle Sidebar">
                    <svg class="w-6 h-6 text-slate-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                    <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a>
                </h1>
            </div>

            {{-- Kanan --}}
            <div class="flex items-center gap-2 sm:gap-4">

                {{-- Tanggal & Waktu: hanya di sm ke atas --}}
                <div class="hidden sm:block text-sm text-slate-500 dark:text-slate-400 tabular-nums">
                    {{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                </div>

                @guest
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Login</a>
                        @if(config('auth.registration_enabled'))
                            <a href="{{ route('register') }}" class="text-sm text-green-600 hover:underline">Daftar</a>
                        @endif
                    </div>
                @endguest

                @auth
                    <div x-data="{ open: false }" class="relative">
                        {{-- Trigger: tampil di semua ukuran --}}
                        <button @click="open = !open"
                            class="flex items-center gap-2 p-1.5 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            {{-- Avatar --}}
                            <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-full flex items-center justify-center text-sm font-bold shadow shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            {{-- Nama & Email: hanya sm ke atas --}}
                            <div class="hidden sm:flex sm:flex-col sm:text-left">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 max-w-[120px] truncate leading-tight">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="text-xs text-slate-400 dark:text-slate-500 max-w-[120px] truncate leading-tight">
                                    {{ auth()->user()->email }}
                                </span>
                            </div>
                            {{-- Chevron: hanya sm ke atas --}}
                            <svg class="hidden sm:block w-4 h-4 text-slate-400 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg py-1 z-50">

                            {{-- Info user di mobile --}}
                            <div class="sm:hidden px-4 py-2.5 border-b border-slate-100 dark:border-slate-700">
                                <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <a href="{{ route('settings') }}"
                               class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Pengaturan
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</nav>
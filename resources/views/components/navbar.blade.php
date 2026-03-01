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

                @php
                    $logoFile = public_path('logo.png');
                    $logo = file_exists($logoFile) ? asset('logo.png') : null;
                @endphp
                @if($logo)
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ $logo }}" alt="logo" class="h-8 w-auto">
                    </a>
                @else
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                        <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a>
                    </h1>
                @endif
            </div>

            {{-- Kanan --}}
            <div class="flex items-center gap-1 sm:gap-3">

                @guest
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Login</a>
                        @if(config('auth.registration_enabled'))
                            <a href="{{ route('register') }}" class="text-sm text-green-600 hover:underline">Daftar</a>
                        @endif
                    </div>
                @endguest

                @auth
                    {{-- ===================== NOTIFICATION BELL ===================== --}}
                    @php
                        $unread = auth()->user()->notifications()->whereNull('read_at')->count();
                        $recent = auth()->user()->notifications()->latest()->limit(5)->get();
                    @endphp

                    <div x-data="{
                            open: false,
                            unread: {{ $unread }},
                            items: @js($recent),
                            truncate(str, len = 60) {
                                if (!str) return '–';
                                return str.length > len ? str.substring(0, len) + '…' : str;
                            }
                        }"
                        class="relative">

                        {{-- Bell --}}
                        <button @click="open = !open"
                            class="relative flex items-center justify-center w-9 h-9 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-150 group">
                            <svg class="w-5 h-5 text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            {{-- Badge --}}
                            <span x-show="unread > 0"
                                x-text="unread > 9 ? '9+' : unread"
                                class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 flex items-center justify-center text-[10px] font-bold text-white bg-red-500 rounded-full leading-none ring-2 ring-white dark:ring-slate-900">
                            </span>
                        </button>

                        {{-- Dropdown --}}
                        {{-- Mobile: full width dengan margin. Desktop: fixed 20rem --}}
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="fixed sm:absolute left-3 right-3 sm:left-auto sm:right-0 top-[64px] sm:top-auto sm:mt-3 sm:w-[20rem] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700/80 rounded-2xl shadow-2xl shadow-slate-200/60 dark:shadow-slate-950/60 overflow-hidden z-50">

                            {{-- Header --}}
                            <div class="flex items-center justify-between px-4 sm:px-5 py-3 sm:py-3.5 border-b border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-sm font-semibold text-slate-800 dark:text-white">Notifikasi</span>
                                    <span x-show="unread > 0"
                                        x-text="unread"
                                        class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full">
                                    </span>
                                </div>
                                <form x-show="unread > 0" method="POST" action="{{ route('notifications.markAllRead') }}">
                                    @csrf @method('patch')
                                    <button type="submit"
                                        class="text-xs font-medium text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                        Baca semua
                                    </button>
                                </form>
                            </div>

                            {{-- Items --}}
                            <div class="overflow-y-auto max-h-[60vh] sm:max-h-[340px] divide-y divide-slate-100 dark:divide-slate-800">

                                {{-- Empty --}}
                                <template x-if="items.length === 0">
                                    <div class="flex flex-col items-center justify-center gap-2 py-12">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Tidak ada notifikasi</p>
                                    </div>
                                </template>

                                {{-- List --}}
                                <template x-for="notif in items" :key="notif.id">
                                    <div class="relative flex items-start gap-3 sm:gap-3.5 px-4 sm:px-5 py-3 sm:py-3.5 transition-colors duration-100"
                                         :class="!notif.read_at
                                             ? 'bg-blue-50/50 dark:bg-blue-950/20 hover:bg-blue-50 dark:hover:bg-blue-950/30'
                                             : 'hover:bg-slate-50 dark:hover:bg-slate-800/50'">

                                        {{-- Unread line indicator --}}
                                        <span x-show="!notif.read_at"
                                            class="absolute left-0 top-3 bottom-3 w-0.5 rounded-full bg-blue-500"></span>

                                        {{-- Icon --}}
                                        <div class="shrink-0 w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center mt-0.5"
                                             :class="{
                                                 'bg-amber-100 dark:bg-amber-900/30': notif.type === 'warning',
                                                 'bg-emerald-100 dark:bg-emerald-900/30': notif.type === 'success',
                                                 'bg-blue-100 dark:bg-blue-900/30': notif.type === 'info',
                                                 'bg-slate-100 dark:bg-slate-800': !['warning','success','info'].includes(notif.type),
                                             }">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 :class="{
                                                     'text-amber-500': notif.type === 'warning',
                                                     'text-emerald-500': notif.type === 'success',
                                                     'text-blue-500': notif.type === 'info',
                                                     'text-slate-400': !['warning','success','info'].includes(notif.type),
                                                 }">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      :d="notif.type === 'warning'
                                                            ? 'M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z'
                                                            : notif.type === 'success'
                                                            ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                                            : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'" />
                                            </svg>
                                        </div>

                                        {{-- Content --}}
                                        <div class="flex-1 min-w-0 overflow-hidden">
                                            <p class="text-sm leading-snug break-words"
                                               :class="!notif.read_at
                                                   ? 'font-semibold text-slate-800 dark:text-white'
                                                   : 'text-slate-500 dark:text-slate-400'"
                                               x-text="truncate(notif.data?.message, 65)">
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400 dark:text-slate-500"
                                               x-text="new Date(notif.created_at).toLocaleString('id-ID', { day:'numeric', month:'short', hour:'2-digit', minute:'2-digit' })">
                                            </p>
                                        </div>

                                        {{-- Unread dot --}}
                                        <span x-show="!notif.read_at"
                                            class="shrink-0 w-2 h-2 mt-2 rounded-full bg-blue-500"></span>
                                    </div>
                                </template>
                            </div>

                            {{-- Footer --}}
                            <div class="border-t border-slate-100 dark:border-slate-800">
                                <a href="{{ route('notifications.index') }}"
                                    class="flex items-center justify-center gap-1.5 px-5 py-3 text-xs font-medium text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    Lihat semua notifikasi
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- =================== END NOTIFICATION BELL =================== --}}

                    {{-- User Dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-full flex items-center justify-center text-sm font-bold shadow shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <div class="hidden sm:flex sm:flex-col sm:text-left">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 max-w-[120px] truncate leading-tight">
                                    {{ auth()->user()->name }}
                                </span>
                                <span class="text-xs text-slate-400 dark:text-slate-500 max-w-[120px] truncate leading-tight">
                                    {{ auth()->user()->email }}
                                </span>
                            </div>
                            <svg class="hidden sm:block w-4 h-4 text-slate-400 transition-transform duration-200"
                                :class="open ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-xl shadow-slate-200/60 dark:shadow-slate-950/60 py-1.5 z-50">

                            {{-- Mobile user info --}}
                            <div class="sm:hidden px-4 py-2.5 mb-1 border-b border-slate-100 dark:border-slate-800">
                                <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <a href="{{ route('settings') }}"
                               class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Pengaturan
                            </a>

                            <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
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
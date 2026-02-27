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
                    <a href="{{ url('/') }}">
                        {{ env('APP_NAME') }}
                    </a>
                </h1>
            </div>
            
            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <div class="sm:text-sm text-slate-600 dark:text-slate-400">
                    {{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                </div>

                @guest
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Login</a>
                        @if(config('auth.registration_enabled'))
                            <a href="{{ route('register') }}" class="text-sm text-green-600 hover:underline">Register</a>
                        @endif
                    </div>
                @endguest

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                            <span class="hidden sm:inline text-sm text-slate-600 dark:text-slate-400">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">Pengaturan</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

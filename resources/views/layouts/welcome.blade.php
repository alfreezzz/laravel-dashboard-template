<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Selamat Datang')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script>
        (function() {
            let theme = localStorage.getItem('theme') || 'system';
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (theme === 'dark' || (theme === 'system' && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 dark:bg-slate-950 antialiased">
    <!-- Decorative background blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-100 dark:bg-indigo-900/20 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-sky-50 dark:bg-sky-900/10 rounded-full blur-3xl opacity-40"></div>
    </div>

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            @php
                $logoFile = public_path('logo.png');
                $logo = file_exists($logoFile) ? asset('logo.png') : null;
            @endphp
            @if($logo)
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ $logo }}" alt="logo" class="h-8 w-auto">
                    {{-- <span class="ml-2 text-lg sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                        {{ env('APP_NAME') }}
                    </span> --}}
                </a>
            @else
                <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                    {{ env('APP_NAME') }}
                </h1>
            @endif
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg shadow transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg shadow transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk
                    </a>
                    @if(config('auth.registration_enabled'))
                        <a href="{{ route('register') }}"
                           class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-sm font-semibold rounded-lg border border-slate-200 dark:border-slate-700 transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative min-h-screen flex flex-col items-center justify-center p-4 pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative text-center py-6 text-sm text-slate-500 dark:text-slate-500 border-t border-slate-200 dark:border-slate-800">
        &copy; {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>
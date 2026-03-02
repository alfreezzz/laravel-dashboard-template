<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth') — {{ config('app.name') }}</title>
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

    {{-- Decorative background blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-100 dark:bg-indigo-900/20 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-sky-50 dark:bg-sky-900/10 rounded-full blur-3xl opacity-40"></div>
    </div>

    {{-- Navbar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
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
                <a href="{{ url('/') }}"
                   class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                    {{ config('app.name') }}
                </a>
            @endif
            <a href="{{ url('/') }}"
               class="flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
    </nav>

    {{-- Main --}}
    <main class="relative min-h-screen flex items-center justify-center p-4 pt-20">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="relative text-center py-6 text-xs text-slate-400 dark:text-slate-600 border-t border-slate-200 dark:border-slate-800">
        &copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>
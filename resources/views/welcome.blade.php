@extends('layouts.welcome')

@section('title', 'Selamat Datang')

@section('content')
    <div class="w-full max-w-md mx-auto text-center space-y-8">

        {{-- Icon / Logo Area --}}
        {{-- <div class="flex justify-center">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 shadow-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
        </div> --}}

        {{-- Heading --}}
        <div class="space-y-3">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white leading-tight">
                Selamat Datang di
                <span class="bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                    {{ config('app.name') }}
                </span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-base">
                Masuk ke akun Anda untuk melanjutkan, atau daftar jika belum memiliki akun.
            </p>
        </div>

        {{-- Card --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-8 space-y-4">

            {{-- Login Button --}}
            <a href="{{ route('login') }}"
               class="flex items-center justify-center gap-2 w-full px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Masuk
            </a>

            {{-- Register Button (conditional) --}}
            @if(config('auth.registration_enabled'))
                <a href="{{ route('register') }}"
                   class="flex items-center justify-center gap-2 w-full px-5 py-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold rounded-xl border border-slate-200 dark:border-slate-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Daftar Akun Baru
                </a>
            @endif
        </div>

    </div>
@endsection
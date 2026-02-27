@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ===================== DASHBOARD HEADER ===================== --}}
<div class="relative mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 p-8 shadow-2xl border border-slate-700/50">

    {{-- Decorative background grid --}}
    <div class="pointer-events-none absolute inset-0 opacity-10"
         style="background-image: linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px); background-size: 32px 32px;"></div>

    {{-- Decorative glow blobs --}}
    <div class="pointer-events-none absolute -top-16 -right-16 h-64 w-64 rounded-full bg-blue-500 opacity-10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-16 -left-16 h-64 w-64 rounded-full bg-emerald-500 opacity-10 blur-3xl"></div>

    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

        {{-- Left: Greeting & subtitle --}}
        <div>
            {{-- Eyebrow label --}}
            <span class="inline-flex items-center gap-1.5 rounded-full border border-blue-500/30 bg-blue-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-blue-400 mb-4">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                </span>
                {{ env('APP_NAME') }}
            </span>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight tracking-tight mb-2"
                style="font-family: 'Georgia', serif; letter-spacing: -0.02em;">
                Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">{{ explode(' ', auth()->user()->name)[0] }}</span> 👋
            </h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-2xl">
                Pantau performa bisnis Anda secara real-time. Semua data tersinkronisasi dan siap digunakan.
            </p>
        </div>

        {{-- Right: Date & quick action --}}
        <div class="flex flex-col items-start sm:items-end gap-3">
            {{-- Current date/time --}}
            <div class="flex items-center gap-2 text-slate-400 text-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span id="dashboard-date" class="font-medium text-slate-300">
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
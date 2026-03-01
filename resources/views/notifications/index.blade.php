@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Notifikasi</h1>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                {{ $notifications->whereNull('read_at')->count() }} belum dibaca
                <span class="mx-1.5 text-slate-300 dark:text-slate-600">·</span>
                {{ $notifications->count() }} total
            </p>
        </div>

        {{-- Mark all read (opsional, bisa tambahkan route) --}}
        @if($notifications->whereNull('read_at')->count() > 0)
            <form method="POST" action="{{ route('notifications.markAllRead') }}">
                @csrf @method('patch')
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- Empty state --}}
    @if($notifications->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 mb-4 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Tidak ada notifikasi</p>
            <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Semua notifikasi akan muncul di sini</p>
        </div>

    @else
        <ul class="space-y-2">
            @foreach($notifications as $notification)
                @php
                    $isUnread = is_null($notification->read_at);

                    $iconBg = match($notification->type) {
                        'warning' => 'bg-amber-100 dark:bg-amber-900/40',
                        'success' => 'bg-emerald-100 dark:bg-emerald-900/40',
                        'info'    => 'bg-blue-100 dark:bg-blue-900/40',
                        default   => 'bg-slate-100 dark:bg-slate-700',
                    };
                    $iconColor = match($notification->type) {
                        'warning' => 'text-amber-500',
                        'success' => 'text-emerald-500',
                        'info'    => 'text-blue-500',
                        default   => 'text-slate-400',
                    };
                    $dotColor = match($notification->type) {
                        'warning' => 'bg-amber-400',
                        'success' => 'bg-emerald-400',
                        'info'    => 'bg-blue-400',
                        default   => 'bg-slate-400',
                    };
                    $icon = match($notification->type) {
                        'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>',
                        'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'info'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        default   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
                    };
                @endphp

                <li class="group relative flex items-start gap-3 p-4 rounded-xl transition-all duration-150
                    {{ $isUnread
                        ? 'bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700'
                        : 'bg-slate-50 dark:bg-slate-800/50 border border-transparent hover:border-slate-200 dark:hover:border-slate-700' }}">

                    {{-- Unread indicator --}}
                    @if($isUnread)
                        <span class="absolute top-4 right-4 w-2 h-2 rounded-full {{ $dotColor }}"></span>
                    @endif

                    {{-- Icon --}}
                    <div class="shrink-0 w-9 h-9 rounded-full {{ $iconBg }} flex items-center justify-center mt-0.5">
                        <svg class="w-4.5 h-4.5 w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $icon !!}
                        </svg>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0 pr-6">
                        <p class="text-sm leading-snug
                            {{ $isUnread
                                ? 'font-semibold text-slate-800 dark:text-white'
                                : 'font-normal text-slate-600 dark:text-slate-400' }}">
                            {{ $notification->data['message'] ?? '–' }}
                        </p>
                        <div class="mt-1.5 flex items-center gap-3">
                            <span class="text-xs text-slate-400 dark:text-slate-500">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>

                            @if($isUnread)
                                <form method="POST" action="{{ route('notifications.mark', $notification) }}">
                                    @csrf @method('patch')
                                    <button type="submit"
                                        class="text-xs text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition">
                                        Tandai dibaca
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs text-slate-400 dark:text-slate-600">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Sudah dibaca
                                </span>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

</div>
@endsection
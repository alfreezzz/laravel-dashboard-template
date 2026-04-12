@extends('layouts.app')

@section('title', $example->title)

@section('content')

<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $example->title }}</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1">
                <span class="inline-block">Slug: <code class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-sm">{{ $example->slug }}</code></span>
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('examples.edit', $example->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white rounded-lg transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit
            </a>
            <a href="{{ route('examples.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-300 hover:bg-slate-400 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white rounded-lg transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status & Active Badge -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Status</h2>
            <div class="flex gap-3">
                <x-badge :color="$example->status === 'published' ? 'green' : 'yellow'">
                    {{ ucfirst($example->status) }}
                </x-badge>
                <x-badge :color="$example->is_active ? 'green' : 'red'">
                    {{ $example->is_active ? 'Aktif' : 'Nonaktif' }}
                </x-badge>
            </div>
        </div>

        <!-- Featured Image -->
        @if($example->featured_image)
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Gambar Utama</h2>
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $example->featured_image) }}" alt="{{ $example->title }}" class="w-full object-cover max-h-96">
                </div>
            </div>
        @endif

        <!-- Description -->
        @if($example->description)
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Deskripsi</h2>
                <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ $example->description }}</p>
            </div>
        @endif

        <!-- Content -->
        @if($example->content)
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Konten</h2>
                <div class="ql-content text-slate-700 dark:text-slate-300">
                    {!! $example->content !!}
                </div>
            </div>
        @endif

        <!-- Document -->
        @if($example->document)
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Dokumen</h2>
                <a href="{{ asset('storage/' . $example->document) }}" download class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-lg transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download
                </a>
            </div>
        @endif
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <!-- Price & Quantity -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6 mb-6">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Informasi</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Harga</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($example->price, 0, ',', '.') }}</p>
                </div>
                <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Kuantitas</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $example->quantity }}</p>
                </div>
            </div>
        </div>

        <!-- Category -->
        @if($example->category)
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6 mb-6">
                <h2 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-3">Kategori</h2>
                <a href="{{ route('categories.show', $example->category->id) }}" class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-lg transition text-sm font-medium">
                    {{ $example->category->name }}
                </a>
            </div>
        @endif

        <!-- Timestamps -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-4">Tanggal</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Dibuat pada</p>
                    <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $example->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                </div>
                <div class="pt-3 border-t border-slate-200 dark:border-slate-700">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Diperbarui pada</p>
                    <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $example->updated_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

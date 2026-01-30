@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-2">Selamat Datang</h1>
    <p class="text-slate-600 dark:text-slate-400">Kelola bisnis Anda dengan mudah menggunakan sistem POS terpadu</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-700 dark:to-blue-800 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Total Kategori</p>
                <h3 class="text-3xl font-bold">{{ \App\Models\Category::count() }}</h3>
            </div>
            <svg class="w-12 h-12 text-blue-400 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" /></svg>
        </div>
    </div>

    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 dark:from-emerald-700 dark:to-emerald-800 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-emerald-100 text-sm font-medium mb-1">Total Barang</p>
                <h3 class="text-3xl font-bold">{{ \App\Models\Item::count() }}</h3>
            </div>
            <svg class="w-12 h-12 text-emerald-400 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" /></svg>
        </div>
    </div>

    <div class="bg-gradient-to-br from-orange-500 to-orange-600 dark:from-orange-700 dark:to-orange-800 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-1">Total Penjualan</p>
                <h3 class="text-3xl font-bold">{{ \App\Models\Transaction::count() }}</h3>
            </div>
            <svg class="w-12 h-12 text-orange-400 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 3H3zM5 16a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('categories.index') }}" class="bg-white dark:bg-slate-800 rounded-lg shadow hover:shadow-lg transition border border-slate-200 dark:border-slate-700 p-6 group">
        <div class="flex items-start justify-between mb-4">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:translate-x-1 transition" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
        </div>
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Master Kategori</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm">Kelola kategori produk Anda</p>
    </a>

    <a href="{{ route('items.index') }}" class="bg-white dark:bg-slate-800 rounded-lg shadow hover:shadow-lg transition border border-slate-200 dark:border-slate-700 p-6 group">
        <div class="flex items-start justify-between mb-4">
            <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10M3 12a9 9 0 0118 0" /></svg>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:translate-x-1 transition" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
        </div>
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Master Barang</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm">Kelola barang/produk bisnis</p>
    </a>

    <a href="{{ route('transactions.index') }}" class="bg-white dark:bg-slate-800 rounded-lg shadow hover:shadow-lg transition border border-slate-200 dark:border-slate-700 p-6 group">
        <div class="flex items-start justify-between mb-4">
            <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg group-hover:bg-orange-200 dark:group-hover:bg-orange-900/50 transition">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:translate-x-1 transition" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
        </div>
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Data Penjualan</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm">Catat dan kelola penjualan</p>
    </a>
</div>
@endsection
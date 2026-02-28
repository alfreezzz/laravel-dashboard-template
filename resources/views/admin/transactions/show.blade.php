@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Page Header --}}
    <x-page-header
        title="Detail Penjualan"
        subtitle="Informasi lengkap transaksi"
    />

    {{-- Main Card --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">

        {{-- Card Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-none mb-0.5">Nomor Faktur</p>
                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400 font-mono">#{{ $transaction->id }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-none mb-0.5">Tanggal Transaksi</p>
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ $transaction->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                </p>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- Buyer & Item Info --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3">Informasi Pembeli & Barang</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl px-4 py-3">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Nama Pembeli</p>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->consumer_name }}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl px-4 py-3">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Kode Barang</p>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white font-mono">
                            {{ $transaction->item_code ?? ($transaction->item->code ?? '-') }}
                        </p>
                    </div>
                    <div class="sm:col-span-2 bg-slate-50 dark:bg-slate-800 rounded-xl px-4 py-3">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Nama Barang</p>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->item->name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-slate-100 dark:border-slate-800"></div>

            {{-- Price Summary --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3">Rincian Harga</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl px-4 py-3">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Jumlah</p>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->quantity }} pcs</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-xl px-4 py-3">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Harga Satuan</p>
                        <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                            Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl px-4 py-3">
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-1">Total Harga</p>
                        <p class="text-sm font-bold text-emerald-700 dark:text-emerald-300">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Card Footer --}}
        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
            <a href="{{ url()->previous() }}"
               class="flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <div class="flex items-center gap-2">
                @can('update', $transaction)
                <a href="{{ route('transactions.edit', $transaction) }}"
                   class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                @endcan
                @can('delete', $transaction)
                <form method="POST" action="{{ route('transactions.destroy', $transaction) }}"
                      onsubmit="return confirm('Hapus transaksi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
                @endcan
            </div>
        </div>

    </div>
</div>
@endsection
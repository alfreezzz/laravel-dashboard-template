@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<x-page-header 
    title="Detail Penjualan"
    subtitle="Informasi lengkap transaksi"
    action-label="Kembali"
    :action-url="route('transactions.index')"
/>

<div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-lg shadow p-6 border border-slate-200 dark:border-slate-700">
    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Faktur: <span class="text-blue-600">#{{ $transaction->id }}</span></h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Nama Pembeli</p>
            <p class="font-medium text-slate-900 dark:text-white">{{ $transaction->consumer_name }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Tanggal</p>
            <p class="font-medium text-slate-900 dark:text-white">{{ $transaction->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Kode Barang</p>
            <p class="font-medium text-slate-900 dark:text-white">{{ $transaction->item_code ?? ($transaction->item->code ?? '-') }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Nama Barang</p>
            <p class="font-medium text-slate-900 dark:text-white">{{ $transaction->item->name ?? '-' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Jumlah</p>
            <p class="font-medium text-slate-900 dark:text-white">{{ $transaction->quantity }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Harga Satuan</p>
            <p class="font-medium text-emerald-600 dark:text-emerald-400">Rp {{ number_format($transaction->unit_price,0,',','.') }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Harga</p>
            <p class="font-semibold text-emerald-700 dark:text-emerald-300">Rp {{ number_format($transaction->total_price,0,',','.') }}</p>
        </div>
    </div>

</div>

@endsection

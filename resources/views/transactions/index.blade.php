@extends('layouts.app')

@section('title', 'Data Penjualan')

@section('content')
<x-page-header 
    title="Data Penjualan"
    subtitle="Lihat dan kelola semua transaksi penjualan"
    action-label="Tambah Penjualan"
    :action-url="route('transactions.create')"
/>

@if(session('success'))
    <x-alert type="success" :message="session('success')" />
@endif

@if(session('error'))
    <x-alert type="error" :message="session('error')" />
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-6 border border-blue-200 dark:border-blue-700">
        <p class="text-blue-700 dark:text-blue-300 text-sm font-medium mb-1">Total Transaksi</p>
        <h3 class="text-3xl font-bold text-blue-900 dark:text-blue-100">{{ $transactions->count() }}</h3>
    </div>
    
    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-lg p-6 border border-emerald-200 dark:border-emerald-700">
        <p class="text-emerald-700 dark:text-emerald-300 text-sm font-medium mb-1">Total Penjualan</p>
        <h3 class="text-3xl font-bold text-emerald-900 dark:text-emerald-100">Rp {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}</h3>
    </div>

    <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-lg p-6 border border-orange-200 dark:border-orange-700">
        <p class="text-orange-700 dark:text-orange-300 text-sm font-medium mb-1">Rata-rata Transaksi</p>
        <h3 class="text-3xl font-bold text-orange-900 dark:text-orange-100">
            Rp {{ $transactions->count() > 0 ? number_format($transactions->sum('total_price') / $transactions->count(), 0, ',', '.') : '0' }}
        </h3>
    </div>
</div>

@php
    $columns = [
        [
            'label' => 'No. Faktur',
            'key' => 'id',
            'sortable' => true,
            'render' => fn($item) => view('components.badge', [
                'color' => 'blue',
                'prefix' => '#'
            ])->with('slot', $item->id)->render()
        ],
        [
            'label' => 'Nama Pembeli',
            'key' => 'consumer_name',
            'sortable' => true,
            'render' => fn($item) => "<span class='text-sm font-medium text-slate-900 dark:text-white'>" . $item->consumer_name . "</span>"
        ],
        [
            'label' => 'Kode Barang',
            'key' => 'item_code',
            'sortable' => true,
            'render' => fn($item) => view('components.badge', [
                'color' => 'purple',
            ])->with('slot', $item->item_code)->render()
        ],
        [
            'label' => 'Jumlah',
            'key' => 'quantity',
            'sortable' => true,
            'render' => fn($item) => $item->quantity
        ],
        [
            'label' => 'Harga Satuan',
            'key' => 'unit_price',
            'sortable' => true,
            'render' => fn($item) => 'Rp ' . number_format($item->unit_price, 0, ',', '.')
        ],
        [
            'label' => 'Total Harga',
            'key' => 'total_price',
            'sortable' => true,
            'render' => fn($item) => "<span class='font-semibold text-emerald-600 dark:text-emerald-400'>Rp " . number_format($item->total_price, 0, ',', '.') . "</span>"
        ],
        [
            'label' => 'Tanggal Faktur',
            'key' => 'created_at',
            'sortable' => true,
            'render' => fn($item) => $item->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i')
        ]
    ];
    
    $actions = fn($item) => view('components.table.table-row-actions', [
        'showUrl' => route('transactions.show', $item->id),
    ])->render();
@endphp

<x-table.data-table 
    :items="$transactions"
    :columns="$columns"
    :actions="$actions"
    emptyMessage="Tidak ada data penjualan"
/>
@endsection
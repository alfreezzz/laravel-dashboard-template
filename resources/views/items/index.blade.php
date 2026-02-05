@extends('layouts.app')

@section('title', 'Master Barang')

@section('content')
<x-page-header 
    title="Master Barang"
    subtitle="Kelola semua barang/produk Anda"
    action-label="Tambah Barang"
    :action-url="route('items.create')"
/>

@if(session('success'))
    <x-alert type="success" :message="session('success')" />
@endif

@if(session('error'))
    <x-alert type="error" :message="session('error')" />
@endif

@php
    $columns = [
        [
            'label' => 'No',
            'key' => 'id',
            'sortable' => true,
            'render' => fn($item, $key) => $key + 1
        ],
        [
            'label' => 'Kode Barang',
            'key' => 'code',
            'sortable' => true,
            'render' => fn($item) => "<span class='inline-flex px-3 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 rounded-full'>" . $item->code . "</span>"
        ],
        [
            'label' => 'Nama Barang',
            'key' => 'name',
            'sortable' => true,
            'render' => fn($item) => "<span class='text-sm font-medium text-slate-900 dark:text-white'>" . $item->name . "</span>"
        ],
        [
            'label' => 'Kategori',
            'render' => fn($item) => $item->category->name ?? '-'
        ],
        [
            'label' => 'Harga Beli',
            'key' => 'buying_price',
            'sortable' => true,
            'render' => fn($item) => 'Rp ' . number_format($item->buying_price, 0, ',', '.')
        ],
        [
            'label' => 'Harga Jual',
            'key' => 'selling_price',
            'sortable' => true,
            'render' => fn($item) => "<span class='font-medium text-emerald-600 dark:text-emerald-400'>Rp " . number_format($item->selling_price, 0, ',', '.') . "</span>"
        ],
        [
            'label' => 'Satuan',
            'render' => fn($item) => $item->unit
        ],
        [
            'label' => 'Tanggal',
            'key' => 'created_at',
            'sortable' => true,
            'render' => fn($item) => $item->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i')
        ]
    ];
    
    $actions = fn($item) => view('components.table.table-row-actions', [
        'editUrl' => route('items.edit', $item->id),
        'deleteUrl' => route('items.destroy', $item->id),
        'deleteMessage' => 'Yakin ingin menghapus barang ini?'
    ])->render();
@endphp

<x-table.data-table 
    :items="$items"
    :columns="$columns"
    :actions="$actions"
    emptyMessage="Tidak ada data barang"
/>
@endsection

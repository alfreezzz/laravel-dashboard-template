@extends('layouts.app')

@section('title', 'Master Kategori')

@section('content')
<x-page-header 
    title="Master Kategori"
    subtitle="Kelola semua kategori produk Anda"
    action-label="Tambah Kategori"
    :action-url="route('categories.create')"
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
            'render' => fn($item, $key) => $key + 1
        ],
        [
            'label' => 'Nama Kategori',
            'render' => fn($item) => "<span class='text-sm font-medium text-slate-900 dark:text-white'>" . $item->name . "</span>"
        ],
        [
            'label' => 'Deskripsi',
            'render' => fn($item) => substr($item->description ?? '-', 0, 50) . (strlen($item->description ?? '') > 50 ? '...' : '')
        ],
        [
            'label' => 'Tanggal',
            'render' => fn($item) => $item->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i')
        ]
    ];
    
    $actions = fn($category) => view('components.table-row-actions', [
        'editUrl' => route('categories.edit', $category->id),
        'deleteUrl' => route('categories.destroy', $category->id),
        'deleteMessage' => 'Yakin ingin menghapus kategori ini?'
    ])->render();
@endphp

<x-data-table 
    :items="$categories"
    :columns="$columns"
    :actions="$actions"
    emptyMessage="Tidak ada data kategori"
/>
@endsection

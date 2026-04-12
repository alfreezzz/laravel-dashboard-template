@extends('layouts.app')

@section('title', 'Contoh Menu')

@section('content')
<x-page-header 
    title="Contoh Menu"
    subtitle="Demonstrasi penggunaan semua komponen form input dalam satu CRUD"
    action-label="Tambah Contoh"
    :action-url="route('examples.create')"
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
            'render' => fn($example, $key) => $key + 1
        ],
        [
            'label' => 'Judul',
            'key' => 'title',
            'sortable' => true,
            'render' => fn($example) => "<span class='font-medium text-slate-900 dark:text-white'>" . $example->title . "</span>"
        ],
        [
            'label' => 'Kategori',
            'render' => fn($example) => $example->category ? view('components.badge', [
                'color' => 'blue',
            ])->with('slot', $example->category->name)->render() : '-'
        ],
        [
            'label' => 'Harga',
            'key' => 'price',
            'sortable' => true,
            'render' => fn($example) => "<span class='text-emerald-600 dark:text-emerald-400 font-medium'>Rp " . number_format($example->price, 0, ',', '.') . "</span>"
        ],
        [
            'label' => 'Kuantitas',
            'key' => 'quantity',
            'sortable' => true,
            'render' => fn($example) => $example->quantity
        ],
        [
            'label' => 'Status',
            'key' => 'status',
            'sortable' => true,
            'render' => fn($example) => view('components.badge', [
                'color' => $example->status === 'published' ? 'green' : 'yellow',
            ])->with('slot', ucfirst($example->status))->render()
        ],
        [
            'label' => 'Aktif',
            'render' => fn($example) => view('components.badge', [
                'color' => $example->is_active ? 'green' : 'red',
            ])->with('slot', $example->is_active ? 'Ya' : 'Tidak')->render()
        ],
        [
            'label' => 'Tanggal',
            'key' => 'created_at',
            'sortable' => true,
            'render' => fn($example) => $example->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i')
        ]
    ];
    
    $actions = fn($example) => view('components.table.table-row-actions', [
        'showUrl' => route('examples.show', $example->id),
        'editUrl' => route('examples.edit', $example->id),
        'deleteUrl' => route('examples.destroy', $example->id),
        'deleteMessage' => 'Yakin ingin menghapus contoh ini?'
    ])->render();
@endphp

<x-table.data-table 
    :items="$examples"
    :columns="$columns"
    :actions="$actions"
    emptyMessage="Tidak ada data contoh"
/>
@endsection

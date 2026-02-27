@extends('layouts.app')

@section('title', 'Master Pengguna')

@section('content')
<x-page-header 
    title="Master Pengguna"
    subtitle="Kelola semua akun pengguna aplikasi"
    action-label="Tambah Pengguna"
    :action-url="route('users.create')"
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
            'label' => 'Nama',
            'key' => 'name',
            'sortable' => true,
            'render' => fn($item) => "<span class='text-sm font-medium text-slate-900 dark:text-white'>" . $item->name . "</span>"
        ],
        [
            'label' => 'Email',
            'key' => 'email',
            'sortable' => true,
        ],
        [
            'label' => 'Peran',
            'key' => 'role',
            'render' => fn($item) => ucfirst($item->role)
        ],
        [
            'label' => 'Tanggal',
            'key' => 'created_at',
            'sortable' => true,
            'render' => fn($item) => $item->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i')
        ]
    ];
    
    $actions = fn($user) => view('components.table.table-row-actions', [
        'editUrl' => route('users.edit', $user->id),
        // 'deleteUrl' => route('users.destroy', $user->id),
        // 'deleteMessage' => 'Yakin ingin menghapus pengguna ini?'
    ])->render();
@endphp

<x-table.data-table 
    :items="$users"
    :columns="$columns"
    :actions="$actions"
    emptyMessage="Tidak ada data pengguna"
/>
@endsection

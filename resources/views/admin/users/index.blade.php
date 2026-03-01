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
            'label' => 'Status',
            'key' => 'is_active',
            'render' => fn($item) => $item->is_active
                ? view('components.badge', ['color' => 'emerald', 'size' => 'xs'])
                        ->with('slot', 'Aktif')
                        ->render()
                : view('components.badge', ['color' => 'red', 'size' => 'xs'])
                        ->with('slot', 'Nonaktif')
                        ->render()
        ],
        [
            'label' => 'Tanggal',
            'key' => 'created_at',
            'sortable' => true,
            'render' => fn($item) => $item->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i')
        ]
    ];
    
    $actions = function($user) {
        $extra = [];

        if (auth()->id() !== $user->id) {
            $extra[] = [
                'url' => route('users.toggle', $user->id),
                'method' => 'patch',
                'icon' => $user->is_active
                    ? '<svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>'
                    : '<svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
                'color' => $user->is_active ? 'red' : 'emerald',
                'label' => $user->is_active ? 'Nonaktifkan' : 'Aktifkan',
            ];
        }

        return view('components.table.table-row-actions', [
            'editUrl' => route('users.edit', $user->id),
            'extraActions' => $extra,
        ])->render();
    };
@endphp

<x-table.data-table 
    :items="$users"
    :columns="$columns"
    :actions="$actions"
    emptyMessage="Tidak ada data pengguna"
/>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<x-form-card title="Tambah Kategori Baru" :backUrl="route('categories.index')">
    <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <x-input
            label="Nama Kategori"
            name="name"
            placeholder="Masukkan nama kategori"
            :value="old('name')"
            required
        />

        <x-textarea
            label="Deskripsi"
            name="description"
            placeholder="Masukkan deskripsi kategori (opsional)"
            :value="old('description')"
            rows="4"
        />

        <x-form-actions :cancelUrl="route('categories.index')" />
    </form>
</x-form-card>
@endsection

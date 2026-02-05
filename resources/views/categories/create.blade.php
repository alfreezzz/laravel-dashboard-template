@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<x-form.form-card title="Tambah Kategori Baru" :backUrl="route('categories.index')">
    <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.input
            label="Nama Kategori"
            name="name"
            placeholder="Masukkan nama kategori"
            :value="old('name')"
            required
        />

        <x-form.textarea
            label="Deskripsi"
            name="description"
            placeholder="Masukkan deskripsi kategori (opsional)"
            :value="old('description')"
            rows="4"
        />

        <x-form.form-actions :cancelUrl="route('categories.index')" />
    </form>
</x-form.form-card>
@endsection

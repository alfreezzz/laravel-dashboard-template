@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<x-form-card title="Edit Kategori" :backUrl="route('categories.index')">
    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <x-input
            label="Nama Kategori"
            name="name"
            placeholder="Masukkan nama kategori"
            :value="old('name', $category->name)"
            required
        />

        <input type="hidden" 
                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white cursor-not-allowed" 
                value="{{ $category->slug }}" 
                disabled>

        <x-textarea
            label="Deskripsi"
            name="description"
            placeholder="Masukkan deskripsi kategori (opsional)"
            :value="old('description', $category->description)"
            rows="4"
        />

        <x-form-actions submitLabel="Simpan Perubahan" :cancelUrl="route('categories.index')" />
    </form>
</x-form-card>
@endsection

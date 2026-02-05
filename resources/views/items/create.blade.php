@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<x-form.form-card title="Tambah Barang Baru" :backUrl="route('items.index')">
    <form action="{{ route('items.store') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.input
            label="Kode Barang"
            name="code"
            placeholder="Masukkan kode barang unik"
            :value="old('code')"
            required
        />

        <x-form.input
            label="Nama Barang"
            name="name"
            placeholder="Masukkan nama barang"
            :value="old('name')"
            required
        />

        <x-form.select
            label="Kategori"
            name="category_id"
            :options="$categories"
            option-value="id"
            option-label="name"
            placeholder="-- Pilih Kategori --"
            :value="old('category_id')"
            required
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-form.input
                label="Harga Beli"
                name="buying_price"
                type="number"
                placeholder="0"
                :value="old('buying_price')"
                required
                min="0"
            />

            <x-form.input
                label="Harga Jual"
                name="selling_price"
                type="number"
                placeholder="0"
                :value="old('selling_price')"
                required
                min="0"
            />
        </div>

        <x-form.select
            label="Satuan"
            name="unit"
            :options="[
                'Pcs' => 'Pcs',
                'Kg' => 'Kg',
                'Gram' => 'Gram',
                'Liter' => 'Liter',
                'Mililiter' => 'Mililiter',
                'Box' => 'Box',
                'Dus' => 'Dus',
                'Karton' => 'Karton',
                'Meter' => 'Meter',
                'Lembar' => 'Lembar',
                'Botol' => 'Botol',
                'Kaleng' => 'Kaleng'
            ]"
            option-value="key"
            option-label="value"
            placeholder="-- Pilih Satuan --"
            :value="old('unit')"
            required
        />

        <x-form.form-actions :cancelUrl="route('items.index')" />
    </form>
</x-form.form-card>
@endsection

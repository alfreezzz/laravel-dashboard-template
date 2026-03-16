@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<x-form.form-card title="Tambah Pengguna Baru" :backUrl="route('users.index')">
    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.input label="Nama" name="name" :value="old('name')" required />
        <x-form.input label="Email" name="email" type="email" :value="old('email')" required />

        <x-form.select
            label="Peran"
            name="role"
            :options="[
                'user' => 'User',
                'admin' => 'Admin'
            ]"
            placeholder="-- Pilih Peran --"
            :value="old('role')"
            required
        />

        <x-form.input label="Password" name="password" type="password" required />
        <x-form.input label="Konfirmasi Password" name="password_confirmation" type="password" required />

        <x-form.checkbox label="Akun aktif" name="is_active" :checked="old('is_active', true)" />

        <x-form.form-actions :cancelUrl="route('users.index')" />
    </form>
</x-form.form-card>
@endsection

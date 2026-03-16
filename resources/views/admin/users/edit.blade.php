@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<x-form.form-card title="Edit Pengguna" :backUrl="route('users.index')">
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <x-form.input label="Nama" name="name" :value="old('name', $user->name)" required />
        <x-form.input label="Email" name="email" type="email" :value="old('email', $user->email)" required />

        <x-form.select
            label="Peran"
            name="role"
            :options="[
                'user' => 'User',
                'admin' => 'Admin'
            ]"
            placeholder="-- Pilih Peran --"
            :value="old('role', $user->role)"
            required
        />

        <x-form.input label="Password baru (kosongkan bila tidak diubah)" name="password" type="password" />
        <x-form.input label="Konfirmasi Password" name="password_confirmation" type="password" />

        <x-form.checkbox 
            label="Akun aktif" 
            name="is_active" 
            :checked="old('is_active', $user->is_active)"
            :disabled="auth()->id() === $user->id"
            :description="auth()->id() === $user->id ? '(tidak bisa dinonaktifkan sendiri)' : null" 
        />

        <x-form.form-actions submitLabel="Simpan Perubahan" :cancelUrl="route('users.index')" />
    </form>
</x-form.form-card>
@endsection

@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<x-form.form-card title="Edit Pengguna" :backUrl="route('users.index')">
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <x-form.input label="Nama" name="name" :value="old('name', $user->name)" required />
        <x-form.input label="Email" name="email" type="email" :value="old('email', $user->email)" required />

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Peran</label>
            <select name="role" required class="w-full rounded-lg border border-slate-300 dark:border-slate-700 px-4 py-2 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

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

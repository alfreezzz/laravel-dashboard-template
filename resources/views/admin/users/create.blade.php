@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<x-form.form-card title="Tambah Pengguna Baru" :backUrl="route('users.index')">
    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.input label="Nama" name="name" :value="old('name')" required />
        <x-form.input label="Email" name="email" type="email" :value="old('email')" required />

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Peran</label>
            <select name="role" required class="w-full rounded-lg border border-slate-300 dark:border-slate-700 px-4 py-2 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <x-form.input label="Password" name="password" type="password" required />
        <x-form.input label="Konfirmasi Password" name="password_confirmation" type="password" required />

        <x-form.form-actions :cancelUrl="route('users.index')" />
    </form>
</x-form.form-card>
@endsection

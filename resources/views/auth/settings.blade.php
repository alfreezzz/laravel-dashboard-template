@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="max-w-lg mx-auto mt-20" x-data="{ tab: 'profile' }">
    <x-form.form-card title="Pengaturan">
        <div class="flex space-x-4 mb-6">
            <button
                @click.prevent="tab = 'profile'"
                :class="tab === 'profile' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-slate-600 dark:text-slate-400'"
                class="pb-2 font-semibold">
                Profil
            </button>
            <button
                @click.prevent="tab = 'theme'"
                :class="tab === 'theme' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-slate-600 dark:text-slate-400'"
                class="pb-2 font-semibold">
                Tema Warna
            </button>
            <button
                @click.prevent="tab = 'password'"
                :class="tab === 'password' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-slate-600 dark:text-slate-400'"
                class="pb-2 font-semibold">
                Ganti Password
            </button>
        </div>

        <!-- Profile tab -->
        <form x-show="tab === 'profile'" x-cloak method="POST" action="{{ route('settings.update') }}">
            @csrf
            <x-form.input label="Nama" name="name" :value="old('name', $user->name)" required />
            <x-form.input label="Email" name="email" type="email" :value="old('email', $user->email)" required />
            <div class="flex justify-end">
                <x-form.form-actions submitLabel="Simpan" :cancelUrl="url()->previous()" cancelLabel="Kembali" />
            </div>
        </form>

        <!-- Theme tab -->
        <form x-show="tab === 'theme'" x-cloak class="space-y-4" onsubmit="event.preventDefault(); localStorage.setItem('theme', theme); location.reload();">
            <div x-data="{ theme: localStorage.getItem('theme') || 'system' }">
                <template x-for="opt in ['light','dark','system']" :key="opt">
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" name="_theme" :value="opt" x-model="theme" class="form-radio" />
                        <span class="ml-1 capitalize" x-text="opt"></span>
                    </label>
                </template>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>

        <!-- Password tab -->
        <form x-show="tab === 'password'" x-cloak method="POST" action="{{ route('settings.password') }}" class="space-y-4">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password Lama</label>
                <input name="old_password" type="password" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('old_password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password Baru</label>
                <input name="new_password" type="password" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('new_password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Konfirmasi Password</label>
                <input name="new_password_confirmation" type="password" required
                    class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Ubah Password</button>
            </div>
        </form>

        @if(session('success'))
            <x-alert type="success" :message="session('success')" class="mt-4" />
        @endif
    </x-form.form-card>
</div>
@endsection

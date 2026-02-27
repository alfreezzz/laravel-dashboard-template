@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="max-w-md mx-auto mt-20">
        <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-center">Register</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ show: false }" class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required
                               class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm">
                            <span x-text="show ? 'Hide' : 'Show'"></span>
                        </button>
                    </div>
                </div>

                <div x-data="{ show: false }" class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" required
                               class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm">
                            <span x-text="show ? 'Hide' : 'Show'"></span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ url('/') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Kembali</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Daftar</button>
                </div>

                <div class="mt-4 text-center text-sm">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk</a>
                </div>
            </form>

            @if($errors->any())
                <div class="mt-4">
                    <x-alert type="error" :message="$errors->first()" />
                </div>
            @endif
        </div>
    </div>
@endsection

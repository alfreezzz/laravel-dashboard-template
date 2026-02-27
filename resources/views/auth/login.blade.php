@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="max-w-md mx-auto mt-20">
        <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-center">Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label class="inline-flex items-center gap-1 text-sm">
                        <input type="checkbox" name="remember" class="form-checkbox" />
                        <span>Ingat saya</span>
                    </label>
                    {{-- <a href="#" class="text-sm text-blue-600 hover:underline">Lupa password?</a> --}}
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ url('/') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Kembali</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Masuk</button>
                </div>

            @if(config('auth.registration_enabled'))
                <div class="mt-4 text-center text-sm">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a>
                </div>
            @endif
            </form>
        </div>

        @if($errors->any())
            <div class="mt-4">
                <x-alert type="error" :message="$errors->first()" />
            </div>
        @endif
    </div>
@endsection

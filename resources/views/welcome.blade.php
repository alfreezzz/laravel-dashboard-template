@extends('layouts.welcome')

@section('title', 'Selamat Datang')

@section('content')
    <div class="max-w-md mx-auto mt-20 text-center">
        <h1 class="text-3xl font-bold mb-4">Selamat Datang di {{ env('APP_NAME') }}</h1>
        <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Login</a>
        @if(config('auth.registration_enabled'))
            <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-green-600 text-white rounded-lg">Register</a>
        @endif
    </div>
@endsection

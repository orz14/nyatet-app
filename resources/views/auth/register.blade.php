@extends('layouts.guest')
@section('content')
<div class="w-full max-w-md overflow-hidden">
    <x-logo />

    <form method="POST" action="{{ route('register') }}">
        @csrf
        {{-- Name --}}
        <x-form-auth type="text" name="name" ph="Masukkan Nama" value="{{ old('name') }}" required autofocus>{{ __('Nama') }}</x-form-auth>

        {{-- Username --}}
        <x-form-auth type="text" name="username" ph="Masukkan Username" value="{{ old('username') }}" required>{{ __('Username') }}</x-form-auth>

        {{-- Email Address --}}
        <x-form-auth type="email" name="email" ph="Masukkan Email" value="{{ old('email') }}" required>{{ __('Email') }}</x-form-auth>

        {{-- Password --}}
        <x-form-auth type="password" name="password" ph="Masukkan Password" required>{{ __('Password') }}</x-form-auth>

        {{-- Confirm Password --}}
        <x-form-auth type="password" name="password_confirmation" ph="Konfirmasi Password" required>{{ __('Konfirmasi Password') }}</x-form-auth>

        <x-auth-button class="mt-5">{{ __('Daftar') }}</x-auth-button>
    </form>

    <div class="mb-1 text-sm text-center text-slate-500">
        {{ __('Sudah memiliki akun?') }} <a href="{{ route('login') }}" class="text-teal-700 underline transition hover:text-teal-500 decoration-2 decoration-teal-500/30">{{ __('Login') }}</a>
    </div>
</div>
@endsection

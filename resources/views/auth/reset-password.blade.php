@extends('layouts.guest')
@section('content')
<div class="w-full max-w-md overflow-hidden">
    <x-logo />

    <div class="text-center">
        <x-error name="email" />
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Password Reset Token --}}
        <x-hidden name="token" value="{{ $request->route('token') }}" />
        
        {{-- Email Address --}}
        <x-hidden name="email" value="{{ old('email', $request->email) }}" />

        {{-- Password --}}
        <x-form-auth type="password" name="password" ph="Masukkan Password Baru" required autofocus>{{ __('Password Baru') }}</x-form-auth>

        {{-- Confirm Password --}}
        <x-form-auth type="password" name="password_confirmation" ph="Konfirmasi Password Baru" required>{{ __('Konfirmasi Password Baru') }}</x-form-auth>

        <x-auth-button class="mt-3">{{ __('Reset Password') }}</x-auth-button>
    </form>
</div>
@endsection

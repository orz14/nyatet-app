@extends('layouts.guest')
@section('content')
<div class="w-full max-w-md overflow-hidden">
    <div class="mb-5">
        <x-logo class="h-auto mx-auto pointer-events-none select-none w-36" />
    </div>
    
    {{-- Session Status --}}
    <x-auth-session-status :status="session('status')" />
    
    <form method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf
        {{-- Username --}}
        <x-form-auth type="text" name="username" ph="Masukkan Username" value="{{ old('username') }}" required autofocus>{{ __('Username') }}</x-form-auth>
        
        {{-- Password --}}
        <x-form-auth type="password" name="password" ph="Masukkan Password" required>{{ __('Password') }}</x-form-auth>
        
        <div class="flex items-center justify-between w-full max-w-sm mx-auto mt-4 mb-5 text-sm">
            {{-- Remember Me --}}
            <div class="inline-flex items-center gap-x-2">
                <input class="text-teal-700 transition-all duration-300 ease-in-out bg-white border-teal-700 rounded shadow-sm focus:border-teal-700 focus:ring focus:ring-teal-600/20 focus:ring-opacity-80" type="checkbox" name="remember" id="remember">
                <label class="select-none text-slate-500" for="remember">
                    {{ __('Ingat saya') }}
                </label>
            </div>
            
            {{-- Lupa Password --}}
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-teal-700 underline transition hover:text-teal-500 decoration-2 decoration-teal-500/30">{{ __('Lupa Password?') }}</a>
            @endif
        </div>
        
        <x-auth-button>{{ __('Login') }}</x-auth-button>
    </form>
    
    @if(env('ENABLE_SOCIAL_LOGIN'))
    <div class="w-full max-w-sm mx-auto divider before:bg-slate-300/70 after:bg-slate-300/70 text-slate-500">OR</div>
    <x-auth-button-github>{{ __('Sign In with GitHub') }}</x-auth-button-github>
    
    <x-auth-button-google>{{ __('Sign In with Google') }}</x-auth-button-google>
    @endif
    
    <div class="mb-1 text-sm text-center text-slate-500">
        {{ __('Belum memiliki akun?') }} <a href="{{ route('register') }}" class="text-teal-700 underline transition hover:text-teal-500 decoration-2 decoration-teal-500/30">{{ __('Daftar') }}</a>
    </div>
</div>
@endsection

@extends('layouts.guest')
@section('content')
<div class="w-full max-w-md overflow-hidden">
    <div class="mb-5">
        <x-logo class="h-auto mx-auto pointer-events-none select-none w-36" />
    </div>

    {{-- Session Status --}}
    <x-auth-session-status />

    <form method="POST" action="{{ route('password.store') }}" autocomplete="off">
        @csrf
        {{-- Password Reset Token --}}
        <x-hidden name="token" value="{{ $request->route('token') }}" />
        
        {{-- Email Address --}}
        <x-hidden name="email" value="{{ old('email', $request->email) }}" />

        <livewire:reset-password />

        <x-auth-button class="mt-3" :label="__('Reset Password')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 md:w-5 md:h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
            </svg>
            {{ __('Reset Password') }}
        </x-auth-button>
    </form>
</div>
@endsection

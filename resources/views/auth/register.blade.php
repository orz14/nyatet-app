@extends('layouts.guest')
@section('content')
<div class="w-full max-w-md overflow-hidden">
    <div class="mb-5">
        <x-logo class="h-auto mx-auto pointer-events-none select-none w-36" />
    </div>
    
    @livewire('register')
    
    <div class="mb-1 text-sm text-center text-slate-500">
        {{ __('Sudah memiliki akun?') }} <a href="{{ route('login') }}" class="text-teal-700 underline transition hover:text-teal-500 decoration-2 decoration-teal-500/30">{{ __('Masuk') }}</a>
    </div>
</div>
@endsection

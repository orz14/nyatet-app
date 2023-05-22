@extends('layouts.guest')
@section('content')
<div class="w-full max-w-md overflow-hidden">
    <div class="w-full max-w-sm mx-auto mb-2 text-sm text-gray-600">
        {{ __('Masukkan alamat email yang terkait dengan akun Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.') }}
    </div>

    {{-- Session Status --}}
    <x-auth-session-status :status="session('status')" />

    @livewire('forgot-password')
</div>
@endsection

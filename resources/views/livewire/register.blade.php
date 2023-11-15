<form method="POST" action="{{ route('register') }}" autocomplete="off">
    @csrf
    {{-- Name --}}
    <x-form-auth type="text" name="name" wire:model.live="name" ph="Masukkan Nama" value="{{ old('name') }}" required autofocus>{{ __('Nama') }}</x-form-auth>
    
    {{-- Username --}}
    <x-form-auth type="text" name="username" wire:model.live="username" ph="Masukkan Username" value="{{ old('username') }}" required>{{ __('Username') }}</x-form-auth>
    
    {{-- Email Address --}}
    <x-form-auth type="email" name="email" wire:model.live="email" ph="Masukkan Email" value="{{ old('email') }}" required>{{ __('Email') }}</x-form-auth>
    
    {{-- Password --}}
    <x-form-auth type="password" name="password" wire:model.live="password" ph="Masukkan Password" required>{{ __('Password') }}</x-form-auth>
    
    {{-- Confirm Password --}}
    <x-form-auth type="password" name="password_confirmation" wire:model.live="password_confirmation" ph="Konfirmasi Password" required>{{ __('Konfirmasi Password') }}</x-form-auth>
    
    <x-auth-button class="mt-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 md:w-5 md:h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
        </svg>
        {{ __('Daftar') }}
    </x-auth-button>
</form>

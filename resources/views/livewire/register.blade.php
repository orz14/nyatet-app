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
    
    <x-auth-button class="mt-5">{{ __('Daftar') }}</x-auth-button>
</form>

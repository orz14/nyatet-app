{{-- Password --}}
<x-form-auth type="password" name="password" wire:model="password" ph="Masukkan Password Baru" required autofocus>{{ __('Password Baru') }}</x-form-auth>

{{-- Confirm Password --}}
<x-form-auth type="password" name="password_confirmation" wire:model="password_confirmation" ph="Konfirmasi Password Baru" required>{{ __('Konfirmasi Password Baru') }}</x-form-auth>

<div>
    {{-- Password --}}
    <x-form-auth :type="__('password')" :name="__('password')" wire:model.live="password" :ph="__('Masukkan Password Baru')" required autofocus>{{ __('Password Baru') }}</x-form-auth>

    {{-- Confirm Password --}}
    <x-form-auth :type="__('password')" :name="__('password_confirmation')" wire:model.live="password_confirmation" :ph="__('Konfirmasi Password Baru')" required>{{ __('Konfirmasi Password Baru') }}</x-form-auth>
</div>

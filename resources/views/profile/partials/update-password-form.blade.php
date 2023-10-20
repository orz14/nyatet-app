<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-center text-teal-900 bg-teal-200 rounded-lg sm:text-left">
        {{ __('Ubah Password') }}
    </h2>
    
    <form wire:submit="savePassword" autocomplete="off">
        {{-- Password Saat Ini --}}
        <x-form-input type="password" name="current_password" wire:model="current_password" ph="Masukkan Password Saat Ini" required>{{ __('Password Saat Ini') }}</x-form-input>
        
        {{-- Password Baru --}}
        <x-form-input type="password" name="password" wire:model="password" ph="Masukkan Password Baru" required>{{ __('Password Baru') }}</x-form-input>
        
        {{-- Konfirmasi Password Baru --}}
        <x-form-input type="password" name="password_confirmation" wire:model="password_confirmation" ph="Konfirmasi Password Baru" required>{{ __('Konfirmasi Password Baru') }}</x-form-input>
        
        <div class="block pt-2 text-center sm:flex sm:items-center sm:gap-4 sm:text-left">
            <button type="submit" class="text-white bg-teal-500 border-none btn max-[639px]:btn-block hover:bg-teal-600">
                {{ __('Simpan Password') }}
            </button>
            
            @if (session('notif') === 'password-updated')
            <p id="status" class="mt-2 text-sm text-emerald-600 sm:mt-0">{{ __('Berhasil Disimpan.') }}</p>
            @endif
            @if (session('notif') === 'password-not-updated')
            <p id="status" class="mt-2 text-sm text-red-600 sm:mt-0">{{ __('Gagal Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

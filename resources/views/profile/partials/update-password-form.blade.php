<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-center text-teal-900 bg-teal-200 rounded-lg sm:text-left">
        <span class="flex items-center gap-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
            </svg>              
            {{ __('Ubah Password') }}
        </span>
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
            
            @if (session('notif') == 'password-updated')
            <p id="status" class="mt-2 text-sm text-emerald-600 sm:mt-0">{{ __('Berhasil Disimpan.') }}</p>
            @endif
            @if (session('notif') == 'password-not-updated')
            <p id="status" class="mt-2 text-sm text-red-600 sm:mt-0">{{ __('Gagal Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

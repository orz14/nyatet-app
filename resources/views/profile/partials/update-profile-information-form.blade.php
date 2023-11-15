<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-center text-teal-900 bg-teal-200 rounded-lg sm:text-left">
        <span class="flex items-center gap-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:w-5 md:h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
            </svg>
            {{ __('Informasi Profil') }}
        </span>
    </h2>
    
    <form wire:submit="saveProfileInfo" autocomplete="off">
        {{-- Nama --}}
        <x-form-input type="text" name="name" wire:model="name" ph="Masukkan Nama Anda" required>{{ __('Nama') }}</x-form-input>
        
        {{-- Username --}}
        <x-form-input type="text" name="username" wire:model="username" disabled>{{ __('Username') }}</x-form-input>
        
        {{-- Email --}}
        <x-form-input type="email" name="email" wire:model="email" ph="Masukkan Email Anda" required>{{ __('Email') }}</x-form-input>
        
        <div class="block pt-2 text-center sm:flex sm:items-center sm:gap-4 sm:text-left">
            <button type="submit" class="text-white bg-teal-500 border-none btn max-[639px]:btn-block hover:bg-teal-600">
                {{ __('Simpan Profil') }}
            </button>
            
            @if (session('notif') === 'profile-updated')
            <p id="status" class="mt-2 text-sm text-emerald-600 sm:mt-0">{{ __('Berhasil Disimpan.') }}</p>
            @endif
            @if (session('notif') === 'profile-not-updated')
            <p id="status" class="mt-2 text-sm text-red-600 sm:mt-0">{{ __('Gagal Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

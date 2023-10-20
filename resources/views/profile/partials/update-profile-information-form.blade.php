<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-center text-teal-900 bg-teal-200 rounded-lg sm:text-left">
        {{ __('Informasi Profil') }}
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

<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-center text-teal-900 bg-teal-200 rounded-lg sm:text-left">
        {{ __('Ubah Password') }}
    </h2>
    
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')
        {{-- Password Saat Ini --}}
        <x-form-input type="password" name="current_password" ph="Masukkan Password Saat Ini" required>{{ __('Password Saat Ini') }}</x-form-input>
        
        {{-- Password Baru --}}
        <x-form-input type="password" name="password" ph="Masukkan Password Baru" required>{{ __('Password Baru') }}</x-form-input>
        
        {{-- Konfirmasi Password Baru --}}
        <x-form-input type="password" name="password_confirmation" ph="Konfirmasi Password Baru" required>{{ __('Konfirmasi Password Baru') }}</x-form-input>
        
        <div class="flex items-center gap-4">
            <button type="submit" class="text-white bg-teal-500 border-none btn hover:bg-teal-600">
                {{ __('Simpan Password') }}
            </button>
            
            @if (session('notif') === 'password-updated')
            <p id="status" class="text-sm text-emerald-600">{{ __('Berhasil Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

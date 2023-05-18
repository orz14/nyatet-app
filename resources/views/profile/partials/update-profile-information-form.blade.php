<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-center text-teal-900 bg-teal-200 rounded-lg sm:text-left">
        {{ __('Informasi Profil') }}
    </h2>
    
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        {{-- Nama --}}
        <x-form-input type="text" name="name" ph="Masukkan Nama Anda" value="{{ old('name', $user->name) }}" required>{{ __('Nama') }}</x-form-input>
        
        {{-- Username --}}
        <x-form-input type="text" name="usernameku" value="{{ $user->username }}" disabled>{{ __('Username') }}</x-form-input>
        
        {{-- Email --}}
        <x-form-input type="email" name="email" ph="Masukkan Email Anda" value="{{ old('email', $user->email) }}" required>{{ __('Email') }}</x-form-input>
        
        <div class="flex items-center gap-4">
            <button type="submit" class="text-white bg-teal-500 border-none btn hover:bg-teal-600">
                {{ __('Simpan Profil') }}
            </button>
            
            @if (session('notif') === 'profile-updated')
            <p id="status" class="text-sm text-emerald-600">{{ __('Berhasil Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

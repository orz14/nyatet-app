<form method="POST" action="{{ route('password.email') }}" autocomplete="off">
    @csrf
    {{-- Email Address --}}
    <x-form-auth type="email" name="email" wire:model="email" ph="Masukkan Email" value="{{ old('email') }}" required autofocus>{{ __('Email') }}</x-form-auth>
    
    <div class="w-full max-w-sm mx-auto mt-5 sm:flex sm:flex-row-reverse sm:gap-2">
        <x-auth-button>
            {{ __('Kirim Tautan') }}
        </x-auth-button>
        
        <div class="w-full max-w-sm mx-auto mb-5 -mt-3 sm:mt-0">
            <a href="{{ route('login') }}" class="text-white border-none bg-slate-400 hover:bg-slate-500 btn btn-block">Kembali</a>
        </div>
    </div>
</form>

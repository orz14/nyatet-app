<form method="POST" action="{{ route('password.email') }}" autocomplete="off">
    @csrf
    {{-- Email Address --}}
    <x-form-auth :type="__('email')" :name="__('email')" wire:model.live="email" :ph="__('Masukkan Email')" :value="old('email')" required autofocus>{{ __('Email') }}</x-form-auth>
    
    <div class="w-full max-w-sm mx-auto mt-5 sm:flex sm:flex-row-reverse sm:gap-2">
        <x-auth-button :label="__('Kirim Tautan')">
            {{ __('Kirim Tautan') }}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 ml-1 md:w-4 md:h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
            </svg>
        </x-auth-button>
        
        <div class="w-full max-w-sm mx-auto mb-5 -mt-3 sm:mt-0">
            <a href="{{ route('login') }}" class="text-white border-none bg-slate-400 hover:bg-slate-500 btn btn-block" role="button" aria-label="Kembali" wire:navigate.hover>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1 md:w-4 md:h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                {{ __('Kembali') }}
            </a>
        </div>
    </div>
</form>

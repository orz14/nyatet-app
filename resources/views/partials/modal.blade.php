{{-- Modal Logout --}}
<x-modal modal="$store.modal.logout" dialog="modal-logout-dialog">
    <div class="px-5 bg-white sm:p-7 sm:pb-0">
        <div>
            <div class="mt-5 sm:mt-0">
                <x-modal-title>{{ __('Konfirmasi') }}</x-modal-title>
                <div class="my-2">
                    <p class="text-sm text-slate-700">{{ __('Apakah anda yakin ingin logout ?') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 py-4 bg-slate-50 sm:flex sm:flex-row-reverse">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-modal-button type="submit" class="text-white bg-red-500 hover:bg-red-600">{{ __('Logout') }}</x-modal-button>
        </form>
        
        <x-modal-button x-on:click="$store.modal.logout = false" type="button" id="button-logout-close" class="text-black bg-transparent hover:bg-transparent">{{ __('Batal') }}</x-modal-button>
    </div>
</x-modal>

@isset($modalDelete)
{{-- Modal Delete --}}
<x-modal modal="$store.modal.delete" dialog="modal-delete-dialog">
    <div class="px-5 bg-white sm:p-7 sm:pb-0">
        <div>
            <div class="mt-5 sm:mt-0">
                <x-modal-title>{{ __('Konfirmasi') }}</x-modal-title>
                <div class="my-2">
                    <p class="text-sm text-slate-700">{{ __('Yakin ingin menghapus data ?') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 py-4 bg-slate-50 sm:flex sm:flex-row-reverse">
        <form method="POST" id="delete_link">
            @csrf
            @method('DELETE')
            <x-modal-button type="submit" class="text-white bg-red-500 hover:bg-red-600">{{ __('Hapus') }}</x-modal-button>
        </form>
        
        <x-modal-button x-on:click="$store.modal.delete = false" type="button" id="button-delete-close" class="text-black bg-transparent hover:bg-transparent">{{ __('Batal') }}</x-modal-button>
    </div>
</x-modal>
@endisset

@isset($modalLock)
{{-- Modal Lock --}}
<x-modal modal="$store.modal.lock" dialog="modal-lock-dialog">
    <form method="POST" id="data_link" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="px-5 bg-white sm:p-7 sm:pb-0">
            <div>
                <div class="mt-5 sm:mt-0">
                    <x-modal-title>{{ __('Atur Password Catatan') }}</x-modal-title>
                    <div class="my-2">
                        <x-form-input type="password" name="password" ph="Masukkan Password" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-4 bg-slate-50 sm:flex sm:flex-row-reverse">
            <x-modal-button type="submit" class="text-white bg-teal-500 hover:bg-teal-600">{{ __('Kunci') }}</x-modal-button>
            
            <x-modal-button x-on:click="$store.modal.lock = false" type="button" id="button-lock-close" class="text-black bg-transparent hover:bg-transparent">{{ __('Batal') }}</x-modal-button>
        </div>
    </form>
</x-modal>

{{-- Modal Unlock --}}
<x-modal modal="$store.modal.unlock" dialog="modal-unlock-dialog">
    <form method="POST" id="data_link_2" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="px-5 bg-white sm:p-7 sm:pb-0">
            <div>
                <div class="mt-5 sm:mt-0">
                    <x-modal-title>{{ __('Buka Password Catatan') }}</x-modal-title>
                    <div class="my-2">
                        <x-form-input type="password" name="password" ph="Masukkan Password" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-4 bg-slate-50 sm:flex sm:flex-row-reverse">
            <x-modal-button type="submit" class="text-white bg-teal-500 hover:bg-teal-600">{{ __('Buka') }}</x-modal-button>
            
            <x-modal-button x-on:click="$store.modal.unlock = false" type="button" id="button-unlock-close" class="text-black bg-transparent hover:bg-transparent">{{ __('Batal') }}</x-modal-button>
        </div>
    </form>
</x-modal>
@endisset

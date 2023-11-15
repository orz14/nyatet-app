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
    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
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
    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
        <livewire:note-destroy />
        
        <x-modal-button x-on:click="$store.modal.delete = false" type="button" id="button-delete-close" class="text-black bg-transparent hover:bg-transparent">{{ __('Batal') }}</x-modal-button>
    </div>
</x-modal>
@endisset

@isset($modalDeleteAccount)
{{-- Modal Delete Account --}}
<x-modal modal="$store.modal.delaccount" dialog="modal-delete-acc-dialog">
    <div class="px-5 bg-white sm:p-7 sm:pb-0">
        <div>
            <div class="mt-5 sm:mt-0">
                <x-modal-title>{{ __('Konfirmasi') }}</x-modal-title>
                <div class="my-2">
                    <p class="text-sm text-slate-700">{{ __('Yakin ingin menghapus akun ?') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
        <livewire:profile-destroy />
        
        <x-modal-button x-on:click="$store.modal.delaccount = false" type="button" id="button-delete-close" class="text-black bg-transparent hover:bg-transparent">{{ __('Batal') }}</x-modal-button>
    </div>
</x-modal>
@endisset

@isset($modalLock)
{{-- Modal Lock --}}
<x-modal modal="$store.modal.lock" dialog="modal-lock-dialog">
    <livewire:note-lock />
</x-modal>

{{-- Modal Unlock --}}
<x-modal modal="$store.modal.unlock" dialog="modal-unlock-dialog">
    <livewire:note-unlock />
</x-modal>
@endisset

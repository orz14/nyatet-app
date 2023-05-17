{{-- Modal Logout --}}
<div x-data x-show="$store.modal.logout" x-transition:enter="ease-out duration-300" x-transition:leave="ease-in duration-200" id="modal-logout-dialog" class="relative z-10 invisible" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div x-show="$store.modal.logout" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" id="modal-logout-backdrop" class="fixed inset-0 transition-opacity bg-teal-900/80"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
            <div id="modal-logout-panel" x-show="$store.modal.logout" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative w-full overflow-hidden text-left transition-all transform bg-white shadow-xl rounded-2xl sm:my-8 sm:max-w-lg">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="px-5 bg-white pt-7 sm:p-7 sm:pb-0">
                        <div>
                            <div class="mt-3 sm:mt-0">
                                <h3 class="text-lg font-bold leading-6 text-slate-900" id="modal-title">{{ __('Konfirmasi') }}</h3>
                                <div class="my-2">
                                    <p class="text-sm text-slate-700">{{ __('Apakah anda yakin ingin logout ?') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-4 bg-slate-50 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="inline-flex justify-center w-full text-white bg-red-500 border-none sm:ml-1 sm:w-auto btn hover:bg-red-600">
                            {{ __('Logout') }}
                        </button>

                        <button x-on:click="$store.modal.logout = false" type="button" id="button-logout-close" class="inline-flex justify-center w-full text-black bg-transparent border-none sm:ml-1 sm:w-auto btn hover:bg-transparent">
                            {{ __('Batal') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

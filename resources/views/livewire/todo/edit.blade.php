<div>
    <form wire:submit="" id="edit_action" autocomplete="off">
        <div class="px-5 bg-white sm:p-7 sm:pb-0">
            <div>
                <div class="mt-5 sm:mt-0">
                    <x-modal-title :label="__('Edit Todo')" />
                    <div class="my-2">
                        <x-form-input :name="__('edit_value')" :ph="__('Masukkan Perubahan')" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-4 sm:flex sm:flex-row-reverse">
            <x-modal-button type="submit" id="simpan" class="text-white bg-teal-500 hover:bg-teal-600" :label="__('Simpan')">{{ __('Simpan') }}</x-modal-button>
            
            <x-modal-button x-on:click="$store.modal.edit = false" type="button" id="button-lock-close" class="text-black bg-transparent hover:bg-transparent" :label="__('Batal')">{{ __('Batal') }}</x-modal-button>
        </div>
    </form>

    <script>
        document.querySelector("#simpan").addEventListener("click", () => {
            const value = document.querySelector("#edit_value").value;
            @this.set('editValue', value);
        });
    </script>
</div>
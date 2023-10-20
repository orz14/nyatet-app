<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-center text-teal-900 bg-teal-200 rounded-lg sm:text-left">
        {{ __('Hapus Akun') }}
    </h2>
    
    <div class="my-2 text-center sm:text-left">
        <span class="text-sm text-slate-500">{{ __('Setelah akun Anda dihapus, semua data akan dihapus secara permanen.') }}</span>
    </div>
    
    <div class="text-center sm:text-left">
        <button x-data x-on:click="modal_delete_acc_open()" type="button" id="button-delete-open" class="text-white bg-red-500 border-none btn max-[639px]:btn-block hover:bg-red-600">
            {{ __('Hapus Akun') }}
        </button>
    </div>
</section>

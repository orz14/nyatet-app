<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-center text-teal-900 bg-teal-200 rounded-lg sm:text-left">
        {{ __('Hapus Akun') }}
    </h2>
    
    <div class="mb-2">
        <span class="text-sm text-slate-500">{{ __('Setelah akun Anda dihapus, semua data akan dihapus secara permanen.') }}</span>
    </div>
    
    <div>
        <button x-data x-on:click="modal_delete_open('{{ route('profile.destroy') }}')" type="button" id="button-delete-open" class="text-white bg-red-500 border-none btn hover:bg-red-600">
            {{ __('Hapus Akun') }}
        </button>
    </div>
</section>

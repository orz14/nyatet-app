<section>
    <h2 class="block px-4 py-3 text-lg font-bold text-teal-900 bg-teal-200 rounded-lg">
        {{ __('Hapus Akun') }}
    </h2>
    
    <div class="mb-2">
        <span class="text-sm text-slate-500">{{ __('Setelah akun Anda dihapus, semua data akan dihapus secara permanen.') }}</span>
    </div>
    
    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')
        <div>
            <button type="submit" class="text-white bg-red-500 border-none btn hover:bg-red-600">
                {{ __('Hapus Akun') }}
            </button>
        </div>
    </form>
</section>

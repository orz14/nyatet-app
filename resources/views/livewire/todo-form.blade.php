<form wire:submit="saveTodo" autocomplete="off">
    <div class="form-control">
        <div class="justify-center input-group">
            <input type="text" name="content" wire:model.live="content" placeholder="Tulis Disini …" class="w-full truncate transition-all duration-300 ease-in-out text-slate-700 bg-teal-400/50 input placeholder:text-slate-500 focus:outline-none focus:ring focus:ring-teal-600/20 focus:border-teal-500" value="{{ old('content') }}" />
            <button type="submit" class="text-white bg-teal-700 border-teal-700 btn btn-square hover:bg-teal-900 hover:border-teal-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"><path fill="currentColor" d="M11 19v-6H5v-2h6V5h2v6h6v2h-6v6h-2Z"/></svg>
            </button>
        </div>
        <x-error name="content" />
    </div>
</form>
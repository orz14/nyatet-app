<div class="w-full mx-auto mb-4 form-control">
    <label for="editor" class="label">
        <span class="label-text text-slate-500">{{ $slot }}</span>
    </label>
    <div class="overflow-hidden text-sm text-teal-700 rounded-lg md:text-base ckeditor">
        <textarea name="{{ $name }}" id="editor" class="block w-full overflow-hidden text-sm transition-all duration-300 ease-in-out md:text-base" @isset($ph) placeholder="{{ $ph }}" @endisset>{!! $value !!}</textarea>
    </div>
    <x-error name="{{ $name }}" />
</div>

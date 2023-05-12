<div class="w-full max-w-sm mx-auto mb-2 form-control">
    <label for="{{ $name }}" class="label">
        <span class="label-text text-slate-500">{{ $slot }}</span>
    </label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" @isset($ph) placeholder="{{ $ph }}" @endisset class="w-full max-w-sm text-teal-700 truncate transition-all duration-300 ease-in-out bg-white border border-teal-700 input focus:outline-none focus:ring focus:ring-teal-600/20 focus:border-teal-500 placeholder:text-sm placeholder:text-slate-300" {{ $attributes }}>
    <x-error name="{{ $name }}" />
</div>

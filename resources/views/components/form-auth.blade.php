@props(['type', 'name', 'ph'])

<div class="w-full max-w-sm mx-auto mb-2 form-control">
    <label for="{{ $name ?? '' }}" class="label">
        <span class="label-text text-slate-500">{{ $slot }}</span>
    </label>
    <input type="{{ $type ?? 'text' }}" name="{{ $name ?? '' }}" id="{{ $name ?? '' }}" placeholder="{{ $ph ?? '' }}" class="w-full max-w-sm text-sm md:text-base text-teal-700 truncate transition-all duration-300 ease-in-out bg-white border border-teal-700 input focus:outline-none focus:ring focus:ring-teal-600/20 focus:border-teal-500 placeholder:text-sm placeholder:text-slate-300 @error($name ?? '') input-err @enderror" {!! $attributes !!}>
    <x-error :name="$name ?? ''" />
</div>

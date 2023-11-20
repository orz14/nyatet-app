@props(['type', 'name', 'ph'])

<div class="w-full mx-auto mb-2 form-control">
    <label for="{{ $name ?? '' }}" class="label">
        <span class="label-text text-slate-500">{{ $slot }}</span>
    </label>
    <input type="{{ $type ?? 'text' }}" name="{{ $name ?? '' }}" id="{{ $name ?? '' }}" placeholder="{{ $ph ?? '' }}" class="w-full text-sm md:text-base text-teal-700 truncate transition-all duration-300 ease-in-out bg-white border border-teal-700 input focus:outline-none focus:ring focus:ring-teal-600/20 focus:border-teal-500 placeholder:text-sm placeholder:text-slate-300 disabled:bg-teal-100/80 disabled:border-teal-700 disabled:text-teal-700/50 @error($name ?? '') input-err @enderror" {!! $attributes !!}>
    <x-error :name="$name ?? ''" />
</div>

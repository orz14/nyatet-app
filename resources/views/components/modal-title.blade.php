@props(['label'])

<h3 {!! $attributes->merge(['class' => 'text-lg font-bold leading-6 text-slate-900', 'id' => $label ?? 'Modal Title']) !!}>{{ $label ?? 'Modal Title' }}</h3>

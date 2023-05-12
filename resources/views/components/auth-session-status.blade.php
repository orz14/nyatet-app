@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'w-full max-w-sm p-2 mx-auto text-sm font-medium text-center text-green-600 bg-green-100 rounded-lg']) }}>
        {{ $status }}
    </div>
@endif

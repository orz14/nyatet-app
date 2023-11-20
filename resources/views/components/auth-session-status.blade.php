@if (session()->has('status'))
    <div {{ $attributes->merge(['class' => 'w-full max-w-sm p-2 mx-auto text-sm font-medium text-center text-green-600 bg-green-100 rounded-lg']) }}>
        {!! session('status') !!}
    </div>
@endif

@if (session()->has('err'))
    <div {{ $attributes->merge(['class' => 'w-full max-w-sm p-2 mx-auto text-sm font-medium text-center text-red-600 bg-red-100 rounded-lg']) }}>
        {!! session('err') !!}
    </div>
@endif

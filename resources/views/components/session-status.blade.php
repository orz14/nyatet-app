@if(session()->has('status'))
<div id="status" class="mt-4">
    <span class="inline-block px-4 py-2 text-xs text-green-800 bg-green-300 rounded-lg sm:text-sm">
        {!! session('status') !!}
    </span>
</div>
@endif

@if(session()->has('err'))
<div id="status" class="mt-4">
    <span class="inline-block px-4 py-2 text-xs text-red-800 bg-red-300 rounded-lg sm:text-sm">
        {!! session('err') !!}
    </span>
</div>
@endif

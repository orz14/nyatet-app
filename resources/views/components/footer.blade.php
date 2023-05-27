<footer id="bottom" class="container pb-20 md:pb-4">
    <div class="p-5 text-sm tracking-widest text-center rounded-lg select-none bg-teal-400/30">
        &copy; {{ date('Y') }} <a href="{{ config('app.url') }}" class="font-bold hover:underline">{{ config('app.name') }}</a> &#183; {{ __('Created with 💚 by') }} <span class="credit"><a href="{{ config('developer.url') }}" class="font-bold hover:underline" target="_blank">{{ config('developer.author') }}</a></span>
    </div>
</footer>

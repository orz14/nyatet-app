<footer id="bottom" class="container pb-20 md:pb-4">
    <div class="p-5 text-sm tracking-widest text-center rounded-lg select-none bg-teal-400/30">
        <span class="inline max-[475px]:block">
            &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="font-bold hover:underline" wire:navigate.hover>{{ config('app.name') }}</a>
        </span>
        <span class="max-[475px]:hidden"> &#183; </span>
        <span class="inline max-[475px]:block">
            {{ __('Created with 💚 by') }} <span class="credit"><a href="{{ config('developer.url') }}" class="font-bold hover:underline" target="_blank">{{ config('developer.name') }}</a></span>
        </span>
    </div>
</footer>

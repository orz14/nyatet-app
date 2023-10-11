<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#" class="scroll-smooth">
    <head>
        @include('partials.meta')
        @livewireStyles
    </head>
    <body class="min-h-screen antialiased font-semibold text-black bg-teal-50">
        <x-header />
        
        <main class="container -mt-8 text-sm md:text-base">
            @yield('content')
        </main>

        <x-footer />

        <x-bottom-nav />

        <x-to-top-down />

        @livewireScripts
        @include('partials.modal')
        @include('partials.script')
    </body>
</html>

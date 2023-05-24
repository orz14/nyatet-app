<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#" class="scroll-smooth">
    <head>
        @include('partials.meta')
        @livewireStyles
    </head>
    <body class="flex flex-wrap items-center justify-center min-h-screen antialiased font-semibold text-black bg-white">
        <main class="container flex justify-center p-4">
            @yield('content')
        </main>
        @livewireScripts
    </body>
</html>

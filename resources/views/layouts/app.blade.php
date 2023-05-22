<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#" class="scroll-smooth">
    <head>
        @include('partials.meta')
    </head>
    <body class="min-h-screen antialiased font-semibold text-black bg-teal-50">
        <x-header />
        
        <main class="container -mt-12">
            @yield('content')
        </main>

        <x-footer />

        <x-bottom-nav />

        @include('partials.modal')
        @include('partials.script')
    </body>
</html>

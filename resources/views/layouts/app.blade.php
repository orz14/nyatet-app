<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.meta')
    </head>
    <body class="min-h-screen antialiased font-semibold text-black bg-teal-50">
        <x-header />
        
        <main class="container -mt-12">
            @yield('content')
        </main>

        <x-footer />

        @include('partials.script')
    </body>
</html>

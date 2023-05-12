<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.meta')
    </head>
    <body class="flex flex-wrap items-center justify-center min-h-screen antialiased text-black bg-white">
        <main class="container flex justify-center p-4">
            @yield('content')
        </main>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.meta')
    </head>
    <body class="min-h-screen antialiased font-semibold text-black bg-teal-50">
        @yield('content')

        <script>
            feather.replace()
        </script>
    </body>
</html>

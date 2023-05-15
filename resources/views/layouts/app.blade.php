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

        <script>
            feather.replace()
        </script>

        @isset($ckeditor)
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
            .create(document.querySelector('#editor'),{
                toolbar: ['bold', 'italic', 'link', 'bulletedList', 'undo', 'redo'],
            })
            .catch(error => {
                console.error( error );
            });
        </script>
        @endisset
    </body>
</html>

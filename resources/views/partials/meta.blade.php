<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="icon" type="image/x-icon" href="{{ asset('img/logo/icon-nyatet-app.png') }}">
<title>{{ isset($title) ? $title . __(' · ') : '' }}{{ config('app.name') }}</title>

{{-- Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

{{-- Scripts --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

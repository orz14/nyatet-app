<!-- SEO Meta Tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="canonical" href="{{ url()->current() }}">
<link rel="icon" sizes="32x32" href="{{ asset('img/logo/uwd-32.png') }}">
<link rel="icon" sizes="192x192" href="{{ asset('img/logo/uwd-192.png') }}">
<link rel="apple-touch-icon-precomposed" href="{{ asset('img/logo/uwd-180.png') }}">
<meta name="msapplication-TileImage" content="{{ asset('img/logo/uwd-144.png') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('img/logo/uwd.png') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="index, follow">
<meta name="geo.country" content="id">
<meta name="geo.placename" content="Indonesia">
<meta name="rating" content="general">
<meta name="author" content="ORZCODE">
<link rel="publisher" href="https://orzproject.my.id/">
<link rel="author" href="https://orzproject.my.id/">
<link rel="me" href="https://orzproject.my.id/">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="id_ID">
<meta property="og:locale:alternate" content="en_US">
<meta property="og:locale:alternate" content="en_GB">
<meta property="article:author" content="https://orzproject.my.id/">
<meta property="article:publisher" content="https://orzproject.my.id/">
<meta name="google-site-verification" content="" />
<meta name="msvalidate.01" content="" />

<!-- Primary Meta Tags -->
<title>{{ isset($title) ? $title . __(' · ') : '' }}{{ config('app.name') }}</title>
<meta name="title" content="{{ isset($title) ? $title . __(' · ') : '' }}{{ config('app.name') }}">
<meta name="description" content="{{ config('app.description') }}">
<meta name="keywords" content="{{ config('app.keywords') }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ isset($title) ? $title . __(' · ') : '' }}{{ config('app.name') }}">
<meta property="og:description" content="{{ config('app.description') }}">
<meta property="og:image" content="{{ asset('img/logo/uwd.png') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ isset($title) ? $title . __(' · ') : '' }}{{ config('app.name') }}">
<meta property="twitter:description" content="{{ config('app.description') }}">
<meta property="twitter:image" content="{{ asset('img/logo/uwd.png') }}">

<!-- Style -->
<meta name="theme-color" content="#14b8a6">
<meta name="msapplication-navbutton-color" content="#14b8a6">
<meta name="apple-mobile-web-app-status-bar-style" content="#14b8a6">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/feather-icons"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Prefetch -->
<link rel="dns-prefetch" href="//cdn.ckeditor.com" />

@if(session()->has('reload'))
<meta content='0;url={{ url()->current() }}' http-equiv='refresh'/>
@endif
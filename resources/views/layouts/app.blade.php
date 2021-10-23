<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Search Engine -->
    <meta name="keywords" content="laravel, laravel instagram clone, laragram, instagram, php, mysql, postgresql">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Md Rafsan Jani Rafin">

    <!-- Primary Meta Tags -->
    <title>{{ __('Laragram | Social Media') }}</title>
    <meta name="title" content="Laragram | Social Media">
    <meta name="description" content="Laragram is a social media platform created with Laravel and VueJS.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('posts.index') }}">
    <meta property="og:title" content="Laragram | Social Media">
    <meta property="og:description" content="Laragram is a social media platform created with Laravel and VueJS.">
    <meta property="og:image" content="{{ asset('images/laragram.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('posts.index') }}">
    <meta property="twitter:title" content="Laragram | Social Media">
    <meta property="twitter:description" content="Laragram is a social media platform created with Laravel and VueJS.">
    <meta property="twitter:image" content="{{ asset('images/laragram.jpg') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"/>
</head>
<body>
<div id="app" class="min-vh-100 d-flex flex-column">
    @include('includes.nav')

    <main class="py-4 bg-gray-100 flex-fill">
        @yield('content')
    </main>

    @include('includes.footer')
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script>
    window.user = {
        isLoggedIn: {{ json_encode(auth()->check()) }},
        commentAppend: {{ json_encode(request()->routeIs('posts.index')) }},
        currentPageRouteName: "{{ Route::currentRouteName() }}",
    }
</script>
@stack('scripts')
</body>
</html>

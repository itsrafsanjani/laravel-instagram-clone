<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Search Engine -->
    <meta name="description" content="Laragram is an open source social media platform created with Laravel and VueJS.">
    <meta name="image" content="{{ asset('images/laragram.jpg') }}">
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="Laragram | Social Media">
    <meta itemprop="description" content="Laragram is an open source social media platform created with Laravel and VueJS.">
    <meta itemprop="image" content="{{ asset('images/laragram.jpg') }}">
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta name="og:title" content="Laragram | Social Media">
    <meta name="og:description" content="Laragram is an open source social media platform created with Laravel and VueJS.">
    <meta name="og:image" content="{{ asset('images/laragram.jpg') }}">
    <meta name="og:locale" content="en_US, bn_BD">
    <meta name="og:type" content="website">

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
        currentPageRouteName: "{{ Route::currentRouteName() }}"
    }

    @if (session('message')) {
        $.niceToast.setup({
            position: "top-right",
            timeout: 5000,
        });
        $.niceToast.{{ session('status') }}('{{ session('message') }}');
    }
    @endif
</script>
@stack('scripts')
</body>
</html>

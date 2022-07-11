<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! SEO::generate(true) !!}

    <!-- Search Engine -->
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="//fonts.googleapis.com">
    <link rel="preconnect" href="//fonts.gstatic.com" crossorigin>
    <link href="//fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- PJAX Laravel Mix Cache Busting --}}
    <meta http-equiv="x-pjax-version" content="{{ mix('css/app.css') }}">
    <!-- Styles -->
    @vite('resources/css/app.css')
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
<script>
    window.user = {
        isLoggedIn: {{ json_encode(auth()->check()) }},
        commentAppend: {{ json_encode(request()->routeIs('posts.index')) }},
        currentPageRouteName: "{{ Route::currentRouteName() }}",
        currentPageUrl: "{{ Route::currentRouteName() }}",
    }
</script>
@vite('resources/js/app.js')
@stack('scripts')
<script>
    $.niceToast.setup({
        position: "top-right",
        timeout: 5000,
    });

    @if (session('message'))
        $.niceToast.{{ session('status') }}('{{ session('message') }}');
    @endif
</script>
</body>
</html>

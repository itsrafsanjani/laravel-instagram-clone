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
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css?family=Open+Sans&Hind+Siliguri" rel="stylesheet">

    {{-- PJAX Laravel Mix Cache Busting --}}
    <meta http-equiv="x-pjax-version" content="{{ mix('css/app.css') }}">
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

    <script>
        window.user = {
            isLoggedIn: {{ json_encode(auth()->check()) }},
            commentAppend: {{ json_encode(request()->routeIs('posts.index')) }},
            currentPageRouteName: "{{ Route::currentRouteName() }}",
            currentPageUrl: "{{ Route::currentRouteName() }}",
        }
    </script>
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Search Engine -->
    <meta name="description" content="Laragram is an open source social media platform created with Laravel and VueJS.">
    <meta name="image" content="//i.ibb.co/R71RdXF/laragram.jpg">
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="Laragram | Social Media">
    <meta itemprop="description" content="Laragram is an open source social media platform created with Laravel and VueJS.">
    <meta itemprop="image" content="//i.ibb.co/R71RdXF/laragram.jpg">
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta name="og:title" content="Laragram | Social Media">
    <meta name="og:description" content="Laragram is an open source social media platform created with Laravel and VueJS.">
    <meta name="og:image" content="//i.ibb.co/R71RdXF/laragram.jpg">
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
    <link href="//cdn.jsdelivr.net/npm/nice-toast-js/dist/css/nice-toast-js.min.css" rel="stylesheet"/>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/nice-toast-js/dist/js/nice-toast-js.min.js"></script>
<script src="//www.gstatic.com/firebasejs/8.6.5/firebase-app.js"></script>
<script src="//www.gstatic.com/firebasejs/8.6.5/firebase-analytics.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
<script>
    $(document).ready(function () {
        let modalId = "";
        $(document).on('click', '.modal', function (e) {
            modalId = this.id
            console.log(modalId)
        });

        new ClipboardJS('.clipboard', {
            container: document.getElementById(modalId)
        });
    });
</script>
<script>
    window.user = {
        isLoggedIn: {{ json_encode(auth()->check()) }},
        commentAppend: {{ json_encode(request()->routeIs('posts.index')) }}
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

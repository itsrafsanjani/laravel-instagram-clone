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
@auth
<script>
    // comment store
    $('.commentButton').on('click', function (e) {
        e.preventDefault();

        let postSlug = $(this).data('postSlug');
        let comment = $('#comment-' + postSlug).val();
        let _url = '/comments';
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                post_slug: postSlug,
                comment: comment,
                _token: _token
            },
            success: function (data) {
                let comment = data
                $('#commentList-' + postSlug).{{ request()->routeIs('posts.index') ? 'append' : 'prepend' }}(`
                            <li class="list-group-item list-group-item-action flex-column align-items-start px-4 py-4">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <div class="d-flex w-100 align-items-center">
                                            <img src="{{ auth()->user()->avatar }}"
                                                 alt="Image placeholder" class="avatar avatar-xs mr-2">
                                            <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                                        </div>
                                    </div>
                                    <small>${moment(comment.data.created_at).fromNow()}</small>
                                </div>
                                <p class="text-sm mb-0 mt-2">${comment.data.comment}</p>
                            </li>
                        `);

                $('#comment-' + postSlug).val('');

                $.niceToast.success(comment.message);
            },
            error: function (response) {
                $.niceToast.error(response.responseJSON.message);
            }
        });
    })
</script>
@endauth
<script>
    window.User = {
        isLoggedIn: {{ json_encode(auth()->check()) }}
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

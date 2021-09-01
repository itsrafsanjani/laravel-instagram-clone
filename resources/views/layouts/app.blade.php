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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link href="//cdn.jsdelivr.net/npm/nice-toast-js/dist/css/nice-toast-js.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="app" class="min-vh-100 d-flex flex-column">
    <nav class="navbar navbar-top navbar-expand-md navbar-light bg-glass sticky-top bg-transparent border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div><img src="{{ asset('/svg/laragram.svg') }}"
                          class="pr-3 laragram-logo-svg" alt="{{ config('app.name') }}"></div>
                <div class="laragram-logo pl-3">{{ config('app.name') }}</div>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ auth()->user()->profile->profileImage() }}" alt="{{ auth()->user()->name }}"
                                 class="nav-avatar">
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profiles.show', auth()->user()) }}">
                                    {{ __('My Profile') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('posts.create') }}">
                                    {{ __('Add New Post') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('profiles.index') }}">
                                    {{ __('Others Profile') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 bg-gray-100 flex-fill">
        @yield('content')
    </main>

    <footer class="footer bg-glass mt-auto py-2">
        <div class="container">
            <div class="d-md-flex text-center justify-content-between">
                    <div class="text-muted">
                        &#169; <a href="{{ config('app.url') }}" target="_blank">{{ config('app.name') }}</a>
                    </div>
                <div class="text-muted">
                    <a href="{{ route('static-pages.privacy-policy') }}" target="_blank" class="ml-2">Privacy Policy</a>
                    <a href="{{ route('static-pages.terms-of-service') }}" target="_blank" class="ml-2">Terms of Service</a>
                    <a href="{{ route('static-pages.cookies') }}" target="_blank" class="ml-2">Cookies</a>
                </div>
            </div>
        </div>
    </footer>
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
                                            <img src="{{ auth()->user()->profile->profileImage() }}"
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
</body>
</html>

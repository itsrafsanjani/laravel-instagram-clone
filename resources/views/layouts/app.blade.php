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
    <link rel="stylesheet" href="//demos.creative-tim.com/argon-dashboard-pro/assets/vendor/animate.css/animate.min.css">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-top navbar-expand-md navbar-light sticky-top bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div><img src="{{ asset('/svg/laragram.svg') }}" style="height: 20px; border-right: 1px solid #333;"
                          class="pr-3" alt="{{ config('app.name') }}"></div>
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
                            <img src="{{ auth()->user()->profile->profileImage() }}" alt="{{ auth()->user()->name }}" style="border-radius: 100%; height: 2em; width: 2em;">
                                {{ Auth::user()->username }} <span class="caret"></span>
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

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4" style="background: #F0F2F5;">
        @yield('content')
    </main>
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="//demos.creative-tim.com/argon-dashboard-pro/assets/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="//www.gstatic.com/firebasejs/8.6.5/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="//www.gstatic.com/firebasejs/8.6.5/firebase-analytics.js"></script>

<script>
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    var firebaseConfig = {
        apiKey: "AIzaSyAxPpkCArq0cVN89_FwaXkd5gACoCBGAts",
        authDomain: "laragram2.firebaseapp.com",
        projectId: "laragram2",
        storageBucket: "laragram2.appspot.com",
        messagingSenderId: "49536770108",
        appId: "1:49536770108:web:6ab2e2dd4593018182e339",
        measurementId: "G-705L5J2HZN"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
</script>

@stack('scripts')
</body>
</html>

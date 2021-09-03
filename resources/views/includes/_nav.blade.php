<nav class="navbar navbar-top navbar-expand-md navbar-light bg-glass sticky-top bg-transparent border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <div><img src="{{ asset('/svg/laragram.svg') }}" class="pr-3 laragram-logo-svg"
                    alt="{{ config('app.name') }}"></div>
            <div class="laragram-logo pl-3">{{ config('app.name') }}</div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto align-items-md-center">
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
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center"><i
                                class="fal fa-home text-xl mr-md-0 mr-2"></i> <span class="d-md-none"> Home </span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center"><i
                                class="fal fa-comment text-xl mr-md-0 mr-2"></i> <span class="d-md-none"> Messages
                            </span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center"><i
                                class="fal fa-compass text-xl mr-md-0 mr-2"></i> <span class="d-md-none"> Explore
                            </span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center"><i
                                class="fal fa-heart text-xl mr-md-0 mr-2"></i> <span class="d-md-none"> Activity
                            </span></a>
                    </li>
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

                            @can('browse_admin')
                                <a class="dropdown-item" href="{{ url('/admin') }}">
                                    {{ __('Admin Panel') }}
                                </a>
                            @endcan

                            <a class="dropdown-item" href="{{ route('posts.create') }}">
                                {{ __('Add New Post') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('profiles.index') }}">
                                {{ __('Others Profile') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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

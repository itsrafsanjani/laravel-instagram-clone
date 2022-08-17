<nav class="navbar navbar-top navbar-expand-md navbar-light bg-glass sticky-top bg-transparent border-bottom shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center"
           data-pjax
           href="{{ url('/') }}">
            <div><img src="{{ asset('/svg/laragram.svg') }}" class="laragram-logo-svg"
                      alt="{{ config('app.name') }}"></div>
            <div class="laragram-logo pl-3 d-md-none">{{ config('app.name') }}</div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @auth
                <form class="form-inline my-2 my-md-0 w-33 navbar-nav mr-auto" action="{{ route('users.index') }}" method="get">
                    <input class="form-control mr-sm-2 w-100"
                            type="text"
                            name="q"
                            placeholder="{{ __('Search') }}"
                            value="{{ $query ?? '' }}">
                </form>
            @endauth

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto align-items-md-center">
                {{-- Language Switcher --}}
                <li class="nav-item dropdown">
                    <button class="btn btn-outline-primary btn-block dropdown-toggle"
                            type="button"
                            id="dropdownMenuButton"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        @switch(session('language') ?? 'en')
                            @case('bn')
                            Bengali
                            @break

                            @case('hi')
                            Hindi
                            @break

                            @default
                            English
                        @endswitch
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{ route('change_language', ['language' => 'en']) }}"
                           data-pjax
                           class="dropdown-item">
                            English
                        </a>
                        <a href="{{ route('change_language', ['language' => 'bn']) }}"
                           data-pjax
                           class="dropdown-item">
                            Bengali
                        </a>
                        <a href="{{ route('change_language', ['language' => 'hi']) }}"
                            data-pjax
                           class="dropdown-item">
                            Hindi
                        </a>
                    </div>
                </li>
                {{-- Authentication Links --}}
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
                    <li class="nav-item @if(request()->routeIs('posts.index')) active @endif">
                        <a href="{{ route('posts.index') }}"
                           data-pjax
                           class="nav-link d-flex align-items-center"
                           title="Home"
                        >
                            <i class="@if(request()->routeIs('posts.index')) fas @else fal @endif fa-home text-xl mr-md-0 mr-2"></i>
                            <span class="d-md-none"> Home </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/messages" class="nav-link d-flex align-items-center"
                           title="Messages">
                            <i class="fal fa-comment text-xl mr-md-0 mr-2"></i>
                            <span class="d-md-none"> {{ __('Messages') }} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('posts.explore') }}"
                           data-pjax
                           title="Explore"
                           class="nav-link d-flex align-items-center @if(request()->routeIs('posts.explore')) active @endif">
                            <i class="@if(request()->routeIs('posts.explore')) fas @else fal @endif fa-compass text-xl mr-md-0 mr-2"></i>
                            <span class="d-md-none"> {{ __('Explore') }} </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('notifications.index') }}"
                           data-pjax
                           title="Notifications"
                           class="nav-link d-flex align-items-center @if(request()->routeIs('notifications.index')) active @endif">
                            <i class="@if(request()->routeIs('notifications.index')) fas @else fal @endif fa-heart text-xl mr-md-0 mr-2"></i>
                            <span class="d-md-none"> {{ __('Notifications') }}</span>
                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                <span class="badge badge-circle badge-primary">
                                    {{ auth()->user()->unreadNotifications()->count() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                                 class="nav-avatar">
                            <span class="d-md-none"> {{ auth()->user()->name }} </span>
                            <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}"
                               data-pjax>
                                {{ __('My Profile') }}
                            </a>

                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item" href="{{ route('admin.dashboard.index') }}">
                                    {{ __('Admin Panel') }}
                                </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('posts.create') }}"
                                data-pjax>
                                {{ __('Add New Post') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('short-urls.index') }}"
                                data-pjax>
                                {{ __('Short Urls') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('referrals.index') }}"
                                data-pjax>
                                {{ __('Referrals') }}
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

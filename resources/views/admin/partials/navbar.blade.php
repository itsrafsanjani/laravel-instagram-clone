<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="{{route('admin.dashboard.index')}}">
                <img src="{{ asset('/svg/laragram.svg') }}" class="navbar-brand-img" alt="...">
                {{ config('app.name') }}
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.dashboard.index')) active @endif"
                           href="{{ route('admin.dashboard.index') }}">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>

                    {{--<li class="nav-item">
                        <a class="nav-link" href="#navbar-categories" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-categories">
                            <i class="ni ni-ungroup text-orange"></i>
                            <span class="nav-link-text">Users</span>
                        </a>
                        <div class="collapse" id="navbar-categories">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Add Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Manage Category</a>
                                </li>
                            </ul>
                        </div>
                    </li>--}}

                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('admin.users.index')) active @endif" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users text-default"></i>
                            <span class="nav-link-text">Users</span>
                        </a>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">
                    <span class="docs-normal">Documentation</span>
                </h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html" target="_blank">
                            <i class="ni ni-spaceship"></i>
                            <span class="nav-link-text">Getting started</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html" target="_blank">
                            <i class="ni ni-palette"></i>
                            <span class="nav-link-text">Foundation</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html" target="_blank">
                            <i class="ni ni-ui-04"></i>
                            <span class="nav-link-text">Components</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/plugins/charts.html" target="_blank">
                            <i class="ni ni-chart-pie-35"></i>
                            <span class="nav-link-text">Plugins</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active active-pro" href="upgrade.html">
                            <i class="ni ni-send text-dark"></i>
                            <span class="nav-link-text">Upgrade to PRO</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

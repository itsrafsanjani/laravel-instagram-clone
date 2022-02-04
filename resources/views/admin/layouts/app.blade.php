<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>@yield('title', 'Laragram')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('backend/assets/img/brand/favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/nucleo/css/nucleo.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.13.1/css/all.css">
    <!-- Plugins -->
    <!-- Animate, Sweetalert2 -->
    <!-- Datatables -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/chart.js/dist/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/argon.css?v=1.2.0') }}">
</head>

<body>
<!-- Sidenav -->
@include('admin.partials.navbar')
<!-- Main content -->
<div class="main-content min-vh-100 d-flex flex-column" id="panel">
    <!-- TopNav -->
    @include('admin.partials.header')
    <!-- Header -->
    <div class="flex-fill @if(!request()->routeIs('admin.dashboard.index')) py-4 @endif">
        @yield('content')
    </div>
    <!-- Footer -->
    @include('admin.partials.footer')
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
<!-- Argon Scripts -->
<!-- Core -->
<script src="{{ asset('backend/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/jquery.validate.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
<!-- Optional JS -->
<script src="{{ asset('backend/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
<!-- Plugins -->
<!-- Datatables -->
<script src="{{ asset('backend/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<!-- Argon JS -->
<script src="{{ asset('backend/assets/js/argon.js?v=1.2.0') }}"></script>
<!-- Custom JS-->
@stack('scripts')

<script>
    (function ($, DataTable) {

        // Datatable global configuration
        $.extend(true, DataTable.defaults, {
            "language": {
                "paginate": {
                    "previous": "<i class=\"fas fa-angle-left\"></i>",
                    "next": "<i class=\"fas fa-angle-right\"></i>",
                }
            }
        });

    })(jQuery, jQuery.fn.dataTable);
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('data-to-vue')
    @yield('css')
</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    @include('admin.layouts.nav')
    @include('admin.layouts.header')

    <div class="pcoded-main-container">
        <div class="pcoded-content" id="app">
            @yield('content')
            <v-dialog :width="200" :height="300" :click-to-close="true"
                :adaptive="true"></v-dialog>
        </div>
    </div>

    <!-- Required Js -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ripple.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard-main.js') }}"></script>
    @yield('js')
</body>

</html>

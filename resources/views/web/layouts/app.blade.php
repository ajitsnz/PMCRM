<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | {{config('app.name')}} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}">

@yield('page_css')
<!-- CSS Libraries -->
@yield('css')
<!-- Template CSS -->
    <link rel="stylesheet" href="{{ mix('assets/css/clients/style.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/clients/components.css') }}">
</head>

<body class="layout-3">
<div id="app">
    <div class="main-wrapper container">
    @include('web.layouts.header')
    <!-- Main Content -->
        <div class="main-content web-content">
            @yield('content')
        </div>
        @include('web.layouts.footer')
    </div>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ mix('assets/js/clients/stisla.js') }}"></script>

<!-- JS Libraies -->
@yield('scripts')
<!-- Template JS File -->
<script src="{{ mix('assets/js/clients/scripts.js') }}"></script>
<!-- Page Specific JS File -->
</body>
</html>

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
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- CSS Libraries -->
@yield('page_css')
<!-- Template CSS -->
    <link rel="stylesheet" href="{{ mix('assets/css/clients/style.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/clients/components.css') }}">
    @yield('css')
    <link href="{{ mix('assets/css/infy-loader.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body class="layout-3">
<div id="app">
    <div class="infy-loader" id="overlay-screen-lock">
        @include('loader')
    </div>
    <div class="main-wrapper container">
    {{-- Start Header   --}}
    @include('clients.layouts.header')
    {{-- End Header   --}}

    <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>

        {{-- Start Footer   --}}
        @include('clients.layouts.footer')
        {{-- End Footer  --}}
    </div>
</div>
@include('clients.user_profile.change_password_modal')
@include('clients.user_profile.change_language_modal')
<!-- General JS Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ mix('assets/js/clients/stisla.js') }}"></script>
<script src="{{ mix('assets/js/clients/scripts.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
    let showNoDataMsg = "{{ __('messages.common.no_data_available_in_table') }}";
</script>
<!-- JS Libraries -->
@yield('page_scripts')
<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script>
    let currentCurrencyClass = "{{ getCurrencyClass() }}";
    (function ($) {
        $.fn.button = function (action) {
            if (action === 'loading' && this.data('loading-text')) {
                this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
            }
            if (action === 'reset' && this.data('original-text')) {
                this.html(this.data('original-text')).prop('disabled', false);
            }
        };
    }(jQuery));
    $(document).ready(function () {
        $('.alert').delay(5000).slideUp(300);
    });
</script>
@yield('scripts')
<script>
    let changePasswordUrl = "{{ route('clients.change.password') }}";
    let loggedInUserId = "{{ getLoggedInUserId() }}";
    let ajaxCallIsRunning = false;
    let changeLanguageUrl = "{{ route('clients.change.language') }}";
</script>
<script src="{{ mix('assets/js/user-profile/user-profile.js') }}"></script>
</body>
</html>

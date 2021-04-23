<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | {{config('app.name')}} </title>
    <link rel="shortcut icon" href="{{ getSettingValue('favicon') }}" type="image/x-icon" sizes="16x16">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!-- CSS Libraries -->

    <link rel="stylesheet" href="{{ getSettingValue("favicon") ?? asset('favicon.ico') }}">
@yield('page_css')
<!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/web/css/components.css')}}">
    @yield('css')
    <link href="{{ mix('assets/css/infy-loader.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body>
<div id="app">
    <div class="infy-loader" id="overlay-screen-lock">
        @include('loader')
    </div>
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            @include('layouts.header')
        </nav>
        <div class="main-sidebar">
            @include('layouts.sidebar')
        </div>
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            @include('layouts.footer')
        </footer>
    </div>
</div>
@include('user_profile.change_password_modal')
@include('user_profile.change_language_modal')
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('assets/js/autonumeric/autoNumeric.min.js') }}"></script>
<script src="{{ asset('assets/web/js/stisla.js') }}"></script>
<script src="{{ asset('assets/web/js/scripts.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
    let showNoDataMsg = "{{ __('messages.common.no_data_available_in_table') }}";
    let noSearchResults = "{{ __('messages.common.search_results') }}";
    let noMatchingRecordsFound = "{{ __('messages.no_matching_records_found') }}";
    let searchCustomerUrl = "{{ route('customers.search.customer') }}";
    let baseUrl = "{{url('/')}}/";
    let currentUrlName = "{{ Request::url() }}";
    let yesMessages = "{{ __('messages.common.yes') }}";
    let noMessages = "{{ __('messages.common.no') }}";
    let deleteHeading = "{{ __('messages.common.delete') }}";
    let deleteConfirm = "{{ __('messages.common.delete_confirm') }}";
    let toTypeDelete = "{{ __('messages.common.to_delete_this') }}";
    let deleteWord = "{{ __('messages.common.delete') }}";
</script>
@yield('page_scripts')
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
    let changePasswordUrl = "{{ route('change.password') }}";
    let changeLanguageUrl = '{{ route('change.language') }}';
    let loggedInUserId = "{{ getLoggedInUserId() }}";
    let ajaxCallIsRunning = false;
    let pdfDocumentImageUrl = "{{ asset('img/attachments_img/pdf.png') }}";
    let docxDocumentImageUrl = "{{ asset('img/attachments_img/doc.png') }}";
    let blockedAttachmentUrl = "{{ asset('img/attachments_img/blocked.png') }}";
    let customersUrl = '{{ route('customers.index') }}';
</script>
<script src="{{ mix('assets/js/user-profile/user-profile.js') }}"></script>
</body>
</html>

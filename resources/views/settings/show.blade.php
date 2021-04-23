@extends('layouts.app')
@section('title')
    {{ __('messages.settings') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.settings') }}</h1>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="alert alert-danger display-none" id="validationErrorsBox"></div>
            <div class="card">
                <div class="card-body">
                    @include("settings.setting_menu")
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
    @if($groupName !== 'general' && $groupName !== 'note')
        <script src="{{ asset('assets/js/int-tel/js/intlTelInput.min.js') }}"></script>
        <script src="{{ asset('assets/js/int-tel/js/utils.min.js') }}"></script>
    @endif
@endsection
@section('scripts')
    <script>
        let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";
        let isEdit = true;
        let phoneNo = "{{ old('prefix_code').old('phone') }}";
    </script>
    @if($groupName !== 'general' && $groupName !== 'note')
        <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>
    @endif
    <script src="{{ mix('assets/js/settings/setting.js') }}"></script>
@endsection

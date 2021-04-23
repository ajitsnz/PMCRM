@extends('layouts.app')
@section('title')
    {{ __('messages.user.edit_profile') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.user.edit_profile') }}</h1>
        </div>
        @include('layouts.errors')
        {{ Form::model($user,['route' => 'update.profile','files' => true, 'id'=>'updateProfile']) }}
        @include('user_profile.fields')
        {{ Form::close() }}
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/int-tel/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('assets/js/int-tel/js/utils.min.js') }}"></script>
    <script src="{{mix('assets/js/custom/input-price-format.js')}}"></script>
@endsection
@section('scripts')
    <script>
        let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";
        let isEdit = true;
        let phoneNo = "{{ old('prefix_code').old('phone') }}";
    </script>
    <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>
    <script src="{{mix('assets/js/user-profile/user-profile.js')}}"></script>
    <script src="{{ mix('assets/js/custom/add-edit-profile-picture.js') }}"></script>
@endsection

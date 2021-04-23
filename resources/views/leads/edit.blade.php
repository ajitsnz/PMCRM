@extends('layouts.app')
@section('title')
    {{ __('messages.lead.edit_lead') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.lead.edit_lead') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::model($lead, ['route' => ['leads.update', $lead->id], 'method' => 'put','id'=>'editLead']) }}

                    @include('leads.fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/int-tel/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('assets/js/int-tel/js/utils.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let isEdit = true;
        let phoneNo = "{{ old('prefix_code').old('phone') }}";
        let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";
        let createCustomerUrl = '{{ route('leads.contactAsPerCustomer') }}';
    </script>
    <script src="{{ mix('assets/js/custom/input-price-format.js')}}"></script>
    <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>
    <script src="{{mix('assets/js/leads/create-edit.js')}}"></script>
@endsection

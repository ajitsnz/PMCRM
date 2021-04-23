@extends('layouts.app')
@section('title')
    {{ __('messages.email_templates') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.email_templates') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="card-header-action mr-3">
                    {{Form::select('template_type', $templateTypeArr, null, ['id' => 'filterTemplate', 'class' => 'form-control status-filter', 'placeholder' => 'Select Template Type']) }}
                </div>
                <div class="card-header-action mr-3">
                    {{ Form::select('disabled', $disabledEmailTemplate, null, ['id' => 'filterDisabledTemplate', 'class' => 'form-control status-filter','placeholder' => 'Select Email Template']) }}
                </div>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('email_templates.table')
                </div>
            </div>
        </div>
    </section>
    @include('email_templates.templates.templates')
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js')}}"></script>
@endsection
@section('scripts')
    <script>
        let emailTemplateUrl = "{{ route('email-templates.index') }}/";
    </script>
    <script src="{{mix('assets/js/email-templates/email-templates.js')}}"></script>
@endsection

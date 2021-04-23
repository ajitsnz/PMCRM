@extends('layouts.app')
@section('title')
    {{ __('messages.email_template.edit_email_template') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.email_template.edit_email_template') }}</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('email-templates.index') }}"
                   class="btn btn-primary form-btn float-right">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                @include('layouts.errors')
                <div class="card-body">
                    {{ Form::model($emailTemplate, ['route' => ['email-templates.update', $emailTemplate->id], 'method' => 'put', 'id' => 'editForm']) }}

                    @include('email_templates.fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let templateId = "{{ $emailTemplate->id }}";
    </script>
    <script src="{{mix('assets/js/email-templates/create-edit.js')}}"></script>
@endsection

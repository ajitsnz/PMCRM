@extends('layouts.app')
@section('title')
    {{ __('messages.projects') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('css')
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.project.new_project') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        @include('layouts.errors')
        <div class="section-body">
            {{ Form::open(['route' => 'projects.store', 'id' => 'createProject']) }}
            <div class="card">
                <div class="card-body">
                    @include('projects.fields')
                </div>
            </div>
                    {{ Form::close() }}
            </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/moment.min.js') }}"></script>

@endsection
@section('scripts')
    <script>
        let editData = false;
        let createCustomerUrl = '{{ route('projects.memberAsPerCustomer') }}';
    </script>
    <script src="{{mix('assets/js/projects/new.js')}}"></script>
@endsection

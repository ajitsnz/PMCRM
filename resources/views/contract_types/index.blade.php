@extends('layouts.app')
@section('title')
    {{ __('messages.contract_types') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.contract_types') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.common.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('contract_types.table')
                </div>
            </div>
        </div>
    </section>
    @include('contract_types.templates.templates')
    @include('contract_types.add_modal')
    @include('contract_types.edit_modal')
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let contractTypeUrl = "{{ route('contract-types.index') }}";
        let contractTypeCreateUrl = "{{ route('contract-types.store') }}";
    </script>
    <script src="{{ mix('assets/js/contract-types/contract-types.js') }}"></script>
@endsection

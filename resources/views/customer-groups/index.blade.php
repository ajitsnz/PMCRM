@extends('layouts.app')
@section('title')
    {{ __('messages.customer_groups') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.customer_groups') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.common.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('customer-groups.table')
                </div>
            </div>
        </div>
    </section>
    @include('customer-groups.add-modal')
    @include('customer-groups.edit-modal')
    @include('customer-groups.templates.templates')
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let customerGroupCreateUrl = "{{ route('customer-groups.store') }}";
        let customerGroupUrl = "{{ route('customer-groups.index') }}";
    </script>
    <script src="{{ mix('assets/js/customer-groups/customer-groups.js') }}"></script>
    <script src="{{ mix('assets/js/customer-groups/create-edit.js') }}"></script>
@endsection


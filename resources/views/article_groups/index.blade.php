@extends('layouts.app')
@section('title')
    {{ __('messages.article_group.article_groups') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/nano.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header m-section">
            <h1>{{ __('messages.article_group.article_groups') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn addTagModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.tag.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('article_groups.table')
                </div>
            </div>
        </div>
    </section>
    @include('article_groups.templates.templates')
    @include('article_groups.add_modal')
    @include('article_groups.edit_modal')
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/pickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let articleGroupUrl = "{{ route('article-groups.index') }}";
        let articleGroupCreateUrl = "{{ route('article-groups.store') }}";
    </script>
    <script src="{{ mix('assets/js/article-groups/article-groups.js') }}"></script>
@endsection


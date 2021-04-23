@extends('layouts.app')
@section('title')
    {{ __('messages.article.new_article') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.article.new_article') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('articles.index') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'articles.store','id' => 'createArticle', 'files' => true]) }}

                    @include('articles.fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script src="{{mix('assets/js/articles/create-edit.js')}}"></script>
    <script src="{{mix('assets/js/file-attachments/attachment.js')}}"></script>
@endsection

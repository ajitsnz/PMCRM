@extends('layouts.app')
@section('title')
    {{ __('messages.articles') }}
@endsection
@section('page_css')
    <link href="{{ mix('assets/css/articles/articles.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.articles') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="mr-2 btn-alignment">
                    {{Form::select('article_group', $groupArr, null, ['id' => 'filterArticleGroup', 'class' => 'form-control status-filter','placeholder' => 'Select Article Group']) }}
                </div>
            </div>
            <div class="float-right mr-2 btn-alignment">
                {{Form::select('internal_article', $internalArticle, null, ['id' => 'filterInternalArticle', 'class' => 'form-control status-filter','placeholder' => 'Select Internal Article']) }}
            </div>
            <div class="float-right mr-2 btn-alignment">
                {{Form::select('disabled', $disabledArticle, null, ['id' => 'filterDisabledArticle', 'class' => 'form-control status-filter','placeholder' => 'Select Status']) }}
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('articles.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.article.add') }} <i
                            class="fas fa-plus"></i></a>
            </div>
        </div>
        @include('flash::message')
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('articles')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let articleUrl = "{{ route('articles.index') }}";
    </script>
    <script src="{{mix('assets/js/articles/articles.js')}}"></script>
@endsection

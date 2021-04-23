@extends('web.layouts.app')
@section('title')
    {{ __('messages.articles') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ mix('assets/css/web/article/article.css') }}" type="text/css">
@endsection
@section('content')
    <section class="section">
        <div class="section-header header-article">
            <h1>{{ __('messages.articles') }}</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-9">
                    <div class="row" id="articles">
                        @include('web.articles.articles_list')
                    </div>
                </div>
                <div class="col-3">
                    <div class="sidebar">
                        <div class="widget">
                            <h5 class="widget-title">{{ __('messages.common.search') }}</h5>
                            <div class="search">
                                {{ Form::text('search',null,['class' => 'form-control','id' => 'searchArticle', 'placeholder' => 'Search Article', 'autocomplete' => 'off']) }}
                                {{ Form::button('<i class="fa fa-search"></i>',['class' => 'btn']) }}
                            </div>
                        </div>
                        <div class="widget">
                            <h5 class="widget-title">{{ __('messages.article_group.article_groups') }}</h5>
                            @foreach($articlesGroups as $articlesGroup)
                                <ul class="mr-5">
                                    <li>{{ $articlesGroup->group_name }}</li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        let articleSearchUrl = "{{ route('article.search') }}";
    </script>
    <script src="{{ mix('assets/js/web/article.js') }}"></script>
@endsection

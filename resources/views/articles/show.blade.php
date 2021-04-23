@extends('layouts.app')
@section('title')
    {{ __('messages.article.article_details') }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.article.article_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('articles.edit', ['article' => $article->id]) }}"
                   class="btn btn-warning mr-2 form-btn">{{ __('messages.common.edit') }}</a>
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('articles.show_fields')
                </div>
            </div>
        </div>
    </section>
@endsection

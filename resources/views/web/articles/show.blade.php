@extends('web.layouts.app')

@section('title')
    {{ __('messages.articles') }}
@endsection

@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/web/article/article.css') }}" type="text/css">
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <h2 class="section-title">{{ __('messages.articles') }}</h2>
            @include('web.articles.show_fields')
        </div>
    </section>
@endsection

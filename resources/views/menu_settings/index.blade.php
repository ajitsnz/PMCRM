@extends('layouts.app')
@section('title')
    {{ __('messages.menu_settings') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui-dist/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/menu_settings/menu_settings.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.menu_settings') }}</h1>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('menu_settings.menu')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery.nestable.js') }}"></script>
    <script src="{{ asset('assets/js/menu-settings/menu-settings.js') }}"></script>
@endsection

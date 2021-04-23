@extends('layouts.app')
@section('title')
    {{ __('messages.tax_rates') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/tax_rates/tax-rates.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.tax_rates') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.common.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('tax-rates')
                </div>
            </div>
        </div>
    </section>
    @include('tax_rates.add_modal')
    @include('tax_rates.edit_modal')
@endsection
@section('page_scripts')
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let taxRateUrl = "{{ route('tax-rates.index') }}";
        let taxRateCreateUrl = "{{ route('tax-rates.store') }}";
    </script>
    <script src="{{ mix('assets/js/tax-rates/tax-rates.js') }}"></script>
@endsection

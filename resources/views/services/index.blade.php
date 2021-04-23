@extends('layouts.app')
@section('title')
    {{ __('messages.services') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/services/services.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.services') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn addServiceModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.service.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('services')
                </div>
            </div>
        </div>
        @include('services.add_modal')
        @include('services.edit_modal')
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let serviceUrl = "{{ route('services.index') }}/";
        let serviceSaveUrl = "{{ route('services.store') }}";
    </script>
    <script src="{{mix('assets/js/services/services.js')}}"></script>
@endsection

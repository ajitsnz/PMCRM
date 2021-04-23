@extends('layouts.app')
@section('title')
    {{ __('messages.projects') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ mix('assets/css/projects/projects.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <div class="section">
        <div class="section-header">
            <h1>{{ __('messages.projects') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <div class="card-header-action mr-3">
                    {{Form::select('status', $billingType, null, ['id' => 'billing_type', 'class' => 'form-control status-filter', 'placeholder' => 'Select Billing type']) }}
                </div>
            </div>
            <div class="float-right btn-alignment mr-3">
                {{Form::select('status', $statusArr, null, ['id' => 'filter_status', 'class' => 'form-control status-filter', 'placeholder' => 'Select Status']) }}
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('projects.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.add') }} <i
                            class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @livewire('projects')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let projectUrl = "{{ route('projects.index') }}";
        let customerId = null;
    </script>
    <script src="{{mix('assets/js/projects/projects.js')}}"></script>
    <script src="{{mix('assets/js/status-counts/status-counts.js')}}"></script>
@endsection

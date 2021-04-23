@extends('layouts.app')
@section('title')
    {{ __('messages.leads') }}
@endsection
@section('css')
    @livewireStyles
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ mix('assets/css/leads/leads.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.leads') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <div class="card-header-action mr-3">
                    {{ Form::select('status', $statusArr, null, ['id' => 'filter_status', 'class' => 'form-control status-filter', 'placeholder' => 'Select Status']) }}
                </div>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('leads.kanbanList') }}"
                   class="btn btn-warning form-btn mr-2">{{ __('messages.kanban_view') }}
                </a>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('leads.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @livewire('leads')
                </div>
            </div>
        </div>
        @include('leads.templates.templates')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let leadUrl = "{{ route('leads.index') }}/";
        let ownerId = null;
        let ownerType = null;
        let currentCurrentSymbol = "{{ getCurrencyClass() }}";
    </script>
    <script src="{{ mix('assets/js/custom/get-price-format.js') }}"></script>
    <script src="{{mix('assets/js/status-counts/status-counts.js')}}"></script>
    <script src="{{mix('assets/js/leads/leads.js')}}"></script>
@endsection

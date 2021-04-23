@extends('layouts.app')
@section('title')
    {{ __('messages.lead_sources') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/lead_sources/lead-sources.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.lead_sources') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn addLeadSourceModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.lead_source.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('lead-sources')
                </div>
            </div>
        </div>
        @include('lead_sources.add_modal')
        @include('lead_sources.edit_modal')
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let leadSourceUrl = "{{ route('lead.source.index') }}/";
        let leadSourceSaveUrl = "{{ route('lead.source.store') }}";
    </script>
    <script src="{{mix('assets/js/lead-sources/lead-sources.js')}}"></script>
@endsection

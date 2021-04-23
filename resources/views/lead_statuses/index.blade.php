@extends('layouts.app')
@section('title')
    {{ __('messages.lead_status.lead_status') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/nano.min.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.lead_status.lead_status') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn addLeadStatusModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.lead_status.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('lead_statuses.table')
                </div>
            </div>
        </div>
        @include('lead_statuses.templates.templates')
        @include('lead_statuses.add_modal')
        @include('lead_statuses.edit_modal')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/pickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let leadStatusUrl = "{{ route('lead.status.index') }}/";
        let leadStatusSaveUrl = "{{ route('lead.status.store') }}";
    </script>
    <script src="{{ mix('assets/js/lead-statuses/lead-statuses.js') }}"></script>
@endsection

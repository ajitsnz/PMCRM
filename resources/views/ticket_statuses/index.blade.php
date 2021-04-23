@extends('layouts.app')
@section('title')
    {{ __('messages.ticket_status.ticket_status') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/nano.min.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.ticket_status.ticket_status') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn addTicketStatusModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.ticket_status.add') }} <i
                            class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('ticket_statuses.table')
                </div>
            </div>
        </div>
        @include('ticket_statuses.templates.templates')
        @include('ticket_statuses.add_modal')
        @include('ticket_statuses.edit_modal')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/pickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let ticketStatusUrl = "{{ route('ticket.status.index') }}/";
        let ticketStatusSaveUrl = "{{ route('ticket.status.store') }}";
    </script>
    <script src="{{mix('assets/js/ticket-statuses/ticket-statuses.js')}}"></script>
@endsection

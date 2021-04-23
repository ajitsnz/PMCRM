@extends('layouts.app')
@section('title')
    {{ __('messages.tickets') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ mix('assets/css/tickets/tickets.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.tickets') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <div class="mr-3">
                    {{Form::select('status', $statusArr, null, ['id' => 'ticketStatus', 'class' => 'form-control status-filter', 'placeholder' => 'Select Status']) }}
                </div>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('tickets.kanbanList') }}"
                   class="btn btn-warning form-btn mr-2">{{ __('messages.kanban_view') }}
                </a>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('ticket.create') }}" class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @livewire('tickets')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let ticketUrl = "{{ route('ticket.index') }}/";
        let customerId = null;
        let downloadAttachmentUrl = "{{ url('admin/tickets-attachment-download') }}";
    </script>
    <script src="{{ mix('assets/js/status-counts/status-counts.js') }}"></script>
    <script src="{{ mix('assets/js/tickets/tickets.js') }}"></script>
@endsection

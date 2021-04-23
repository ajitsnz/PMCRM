@extends('layouts.app')
@section('title')
    {{ __('messages.ticket_priorities') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/ticket_priorities/ticket-priorities.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.ticket_priorities') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <div class="card-header-action mr-3">
                    {{Form::select('status', $statusArr, \App\Models\TicketPriority::STATUS_ALL, ['id' => 'filter_status', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="float-right btn-alignment">
                <a href="#" class="btn btn-primary form-btn addTicketPriorityModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.ticket_priority.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('ticket-priorities')
                </div>
            </div>
        </div>
        @include('ticket_priorities.add_modal')
        @include('ticket_priorities.edit_modal')
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let ticketPriorityUrl = "{{ route('ticketPriorities.index') }}/";
        let ticketPrioritySaveUrl = "{{ route('ticketPriorities.store') }}";
    </script>
    <script src="{{ mix('assets/js/ticket-priorities/ticket-priorities.js') }}"></script>
@endsection

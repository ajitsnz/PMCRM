@extends('layouts.app')
@section('title')
    {{ __('messages.ticket.ticket_details') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.ticket.ticket_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('ticket.edit', ['ticket' => $ticket->id]) }}"
                   class="btn btn-warning mr-2 form-btn">{{ __('messages.common.edit') }}</a>
                <a href="{{ url()->previous() }}" class="btn btn-primary form-btn">
                    {{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('tickets.show_fields')
                </div>
            </div>
        </div>
        @include('tasks.templates.templates')
        @include('reminders.templates.templates')
        @include('reminders.add_modal')
        @include('reminders.edit_modal')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let noteUrl = "{{ route('notes.index') }}/";
        let noteSaveUrl = "{{ route('notes.store') }}";
        let reminderUrl = "{{ route('reminder.index') }}/";
        let reminderSaveUrl = "{{ route('reminder.store') }}";
        let taskUrl = "{{ route('tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
        let ownerId = "{{ $ticket->id }}";
        let ownerType = 'App\\Models\\Ticket';
        let ticketUrl = "{{ route('ticket.index') }}/";
        let ticketId = '{{ $ticket->id }}';
        let authId = '{{ Auth::id() }}';
        let ownerUrl = "{{ route('ticket.index') }}";
    </script>
    <script src="{{ mix('assets/js/tasks/tasks.js')}}"></script>
    <script src="{{ mix('assets/js/notes/new-notes.js')}}"></script>
    <script src="{{ mix('assets/js/reminder/reminder.js')}}"></script>
    <script src="{{ mix('assets/js/tickets/ticket-details.js') }}"></script>
@endsection

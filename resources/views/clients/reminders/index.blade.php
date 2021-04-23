@extends('clients.layouts.app')
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">{{__('messages.reminder.ticket_reminder')}}</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('clients.reminders.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js')}}"></script>
@endsection
@section('scripts')
    <script>
        let reminderUrl = '{{ route('clients.reminder.index') }}/';
    </script>
    <script src="{{ mix('assets/js/clients/reminders/reminder.js') }}"></script>
@endsection

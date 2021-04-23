@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">{{__('messages.reminder.ticket_reminder')}}</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right mb-5"
               href="{{ route('ticketReminders.create') }}">{{__('messages.reminder.add_new')}}</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('ticket_reminders.table')
            </div>
        </div>
    </div>
@endsection


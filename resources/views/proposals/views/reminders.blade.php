@extends('proposals.show')
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="row w-100 justify-content-end">
                <div class="justify-content-end mr-2">
                    {{ Form::select('is_notified', $notifiedReminder, null, ['id' => 'filterNotified', 'class' => 'form-control status-filter','placeholder' => 'Select Email Status']) }}
                </div>
                <a href="#" class="btn btn-primary addReminderModal add-button" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.reminder.set_reminder') }} <i
                            class="fas fa-plus"></i></a>
            </div>
            <div class="card">
                <div class="card-body">
                    @include('reminders.table')
                </div>
            </div>
        </div>
    </section>
@endsection

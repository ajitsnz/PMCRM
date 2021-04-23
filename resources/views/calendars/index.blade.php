@extends('layouts.app')
@section('title')
    {{ __('messages.calendars') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/fullcalendar.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.calendars') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('announcements.index') }}" class="btn btn-primary form-btn">
                    {{ __('messages.announcements') }}</i>
                </a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Announcement show modal --}}
    <div id="announcementDetailModal" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.announcement.announcement_details') }}</h5>
                    <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12 mb-0">
                            {{ Form::label('subject',  __('messages.announcement.subject').':') }}
                            <p id="announcementSubject"></p>
                        </div>
                        <div class="form-group col-sm-12 mb-0">
                            {{ Form::label('show_to_clients', __('messages.announcement.show_to_clients').':') }}
                            <p id="announcementShowToClients"></p>
                        </div>
                        <div class="form-group col-sm-12 mb-0">
                            {{ Form::label('date', __('messages.announcement.announcement_date').':') }}<br>
                            <p id="announcementDate"></p>
                        </div>
                        <div class="form-group col-sm-12 mb-0">
                            {{ Form::label('description', __('messages.announcement.message').':') }}
                            <p id="announcementDescription"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/fullcalendar.min.js') }}"></script>
@endsection
@section('scripts')
    <script src="{{mix('assets/js/calenders/calenders.js')}}"></script>
@endsection

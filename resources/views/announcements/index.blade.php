@extends('layouts.app')
@section('title')
    {{ __('messages.announcements') }}
@endsection
@section('page_css')
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/clients/announcements/announcements.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.announcements') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <div class="card-header-action mr-3">
                    {{ Form::select('status', $statusArr, null, ['id' => 'filterAnnouncementStatus', 'class' => 'form-control status-filter', 'placeholder' => 'Select Status']) }}
                </div>
            </div>
            <div class="float-right btn-alignment">
                @can('manage_calenders')
                    <a href="{{ route('calendars.index') }}" class="btn btn-primary form-btn mr-2"><i
                                class="fas fa-calendar mr-1"></i>{{ __('messages.calendars') }}</a>
                @endcan
                <a href="#" class="btn btn-primary form-btn addAnnouncementModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.announcement.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('announcements')
                </div>
            </div>
        </div>
        @include('announcements.add_modal')
        @include('announcements.edit_modal')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let announcementUrl = "{{ route('announcements.index') }}/";
        let announcementSaveUrl = "{{ route('announcements.store') }}";
    </script>
    <script src="{{ mix('assets/js/announcements/announcements.js') }}"></script>
@endsection

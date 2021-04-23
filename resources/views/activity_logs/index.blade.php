@extends('layouts.app')
@section('title')
    {{ __('messages.activity_log.activity_logs') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/activity_logs/activity_log.css') }}">
@endsection
@section('content')
    <section class="section">
        @include('flash::message')
        <div class="section-header">
            <h1 class="page__heading">{{ __('messages.activity_log.activity_logs') }}</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @include('activity_logs.activity_log_lists')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('activity_logs.templates.templates')
    </section>
@endsection
@section('scripts')
    <script>
        let activityLogsUrl = "{{ route('activity.logs.index') }}";
    </script>
    <script src="{{ mix('assets/js/activity-logs/activity-log.js') }}"></script>
@endsection

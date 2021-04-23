@extends('layouts.app')
@section('title')
    {{ __('messages.tasks') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.tasks') }}</h1>
            <div class="section-header-breadcrumb btn-alignment d-flex m-section-items">
                <div class="card-header-action mr-3">
                    {{ Form::select('priority', $priorities, null, ['id' => 'priorityId', 'class' => 'form-control status-filter','placeholder' => 'Select Priority']) }}
                </div>
                <div class="card-header-action mr-3">
                    {{ Form::select('status', $status, null, ['id' => 'filter_status', 'class' => 'form-control status-filter','placeholder' => 'Select Status']) }}
                </div>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('tasks.kanbanList') }}"
                   class="btn btn-warning form-btn mr-2">{{ __('messages.kanban_view') }}
                </a>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('tasks.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="section-body mb-4">
            <div class="row justify-content-md-center text-center">
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-danger">
                            <p>{{ $statusCount->not_started }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('messages.task.not_started') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-primary">
                            <p>{{ $statusCount->in_progress }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('messages.task.in_progress') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-warning">
                            <p>{{ $statusCount->testing }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('messages.task.testing') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-info">
                            <p>{{ $statusCount->awaiting_feedback }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('messages.task.awaiting_feedback') }}</h5>
                    </div>
                    <div class="item">
                        <div class="ticket-statistics mx-auto bg-success">
                            <p>{{ $statusCount->completed }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ __('messages.task.completed') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('tasks.table')
                </div>
            </div>
        </div>
        @include('tasks.templates.templates')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js')}}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let taskUrl = "{{ route('tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
        let ownerId = null;
        let ownerType = null;
    </script>
    <script src="{{mix('assets/js/tasks/tasks.js')}}"></script>
    <script src="{{mix('assets/js/status-counts/status-counts.js')}}"></script>
@endsection

@extends('clients.layouts.app')
@section('title')
    {{ __('messages.tasks') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.tasks') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="card-header-action mr-3">
                    {{ Form::select('status', $status, null, ['id' => 'filter_status', 'class' => 'form-control status-filter','placeholder' => 'Select Status']) }}
                </div>
                <a href="{{ route('tasks.kanbanList') }}"
                   class="btn btn-warning form-btn mr-2">{{ __('messages.kanban_list') }}
                </a>
                <a href="{{ route('tasks.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i>
                </a>
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
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js')}}"></script>
@endsection
@section('scripts')
    <script>
        let taskUrl = "{{ route('clients.tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
        let customerId = null;
    </script>
    <script src="{{mix('assets/js/clients/tasks/tasks.js')}}"></script>
@endsection

@extends('layouts.app')
@section('title')
    {{ __('messages.task.new_task') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.task.new_task') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'tasks.store','id'=>'createTasks']) }}

                    @include('tasks.fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{mix('assets/js/custom/input-price-format.js')}}"></script>
@endsection
@section('scripts')
    <script>
        let changeOwnerUrl = "{{ route('change-owner') }}";
        let customerId = "{{ $customerId }}";
        let relatedTo = "{{ $relatedTo }}";
        let editTasksOwner = false;
        let editTasks = false;
    </script>
    <script src="{{mix('assets/js/tasks/create-edit.js')}}"></script>
@endsection

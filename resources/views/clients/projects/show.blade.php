@extends('clients.layouts.app')
@section('title')
    {{ __('messages.project.project_details') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.project.project_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('clients.projects.index') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('clients.projects.show_fields')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let taskUrl = "{{ route('clients.tasks.index') }}";
        let ownerId = "{{ $project->id }}";
        let ownerType = 'App\\Models\\Project';
    </script>
    <script src="{{mix('assets/js/clients/tasks/tasks.js')}}"></script>
@endsection

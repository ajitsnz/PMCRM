@extends('layouts.app')
@section('title')
    {{ __('messages.project.project_details') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.project.project_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                @if($project->status !== \App\Models\Project::STATUS_CANCELLED && $project->status !== \App\Models\Project::STATUS_FINISHED)
                    <a href="{{ route('projects.edit', ['project' => $project->id]) }}"
                       class="btn btn-warning mr-2 form-btn">{{ __('messages.common.edit') }}</a>
                @endif
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('projects.show_fields')
                </div>
            </div>
        </div>
        @include('tasks.templates.templates')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let taskUrl = "{{ route('tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
        let ownerId = "{{ $project->id }}";
        let ownerType = 'App\\Models\\Project';
    </script>
    <script src="{{mix('assets/js/tasks/tasks.js')}}"></script>
@endsection

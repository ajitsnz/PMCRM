@extends('layouts.app')
@section('title')
    {{ __('messages.department.departments') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/departments/departments.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.department.departments') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn addTagModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.common.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('departments')
                </div>
            </div>
        </div>
    </section>
    @include('departments.add_modal')
    @include('departments.edit_modal')
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let departmentUrl = "{{ route('departments.index') }}";
        let departmentCreateUrl = "{{ route('departments.store') }}";
    </script>
    <script src="{{mix('assets/js/departments/departments.js')}}"></script>
@endsection

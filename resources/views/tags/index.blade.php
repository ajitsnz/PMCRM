@extends('layouts.app')
@section('title')
    {{ __('messages.tags') }}
@endsection
@section('css')
    @livewireStyles
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tags/tag.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.tags') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn addTagModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.tag.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('tags')
                </div>
            </div>
        </div>
        @include('tags.add_modal')
        @include('tags.edit_modal')
        @include('tags.show_modal')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let tagUrl = "{{ route('tags.index') }}/";
        let tagSaveUrl = "{{ route('tags.store') }}";
        let modalName = "{{ __('messages.tag.new_tag') }}";
    </script>
    <script src="{{mix('assets/js/tags/tags.js')}}"></script>
@endsection

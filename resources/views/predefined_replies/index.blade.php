@extends('layouts.app')
@section('title')
    {{ __('messages.predefined_replies') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/predefined_replay/predefined_replies.css') }}">
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.predefined_replies') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="#" class="btn btn-primary form-btn addPredefinedReplyModal" data-toggle="modal"
                   data-target="#addModal">{{ __('messages.predefined_reply.add') }} <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('predefined-replies')
                </div>
            </div>
        </div>
        @include('predefined_replies.add_modal')
        @include('predefined_replies.edit_modal')
        @include('predefined_replies.show_modal')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let predefinedReplyUrl = "{{ route('predefinedReplies.index') }}/";
        let predefinedReplySaveUrl = "{{ route('predefinedReplies.store') }}";
    </script>
    <script src="{{mix('assets/js/predefined-reply/predefined-reply.js')}}"></script>
@endsection

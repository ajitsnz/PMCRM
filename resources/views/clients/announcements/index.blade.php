@extends('clients.layouts.app')
@section('title')
    {{ __('messages.announcements') }}
@endsection
@section('page_css')
    <link href="{{ mix('assets/css/clients/announcements/announcements.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.announcements') }}</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('clients.announcements')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let announcementUrl = '{{ route('clients.announcements.index') }}/';
    </script>
    <script src="{{ mix('assets/js/clients/announcements/announcements.js') }}"></script>
@endsection

@extends('clients.layouts.app')
@section('title')
    {{ __('messages.announcement.announcement_details') }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.announcement.announcement_details') }}</h1>
            <div class="section-header-breadcrumb  btn-alignment">
                <a href="{{ route('clients.announcements.index') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('clients.announcements.show_fields')
                </div>
            </div>
        </div>
    </section>
@endsection

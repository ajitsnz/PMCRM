@extends('customers.show')
@section('section')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.contacts') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('contacts.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('contacts.table')
                </div>
            </div>
        </div>
        @include('contacts.templates.templates')
    </section>
@endsection

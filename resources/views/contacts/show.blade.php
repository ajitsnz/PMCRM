@extends('layouts.app')
@section('title')
    {{ __('messages.contact.contact_details') }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.contact.contact_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('contacts.edit', ['contact' => $contact->id]) }}"
                   class="btn btn-warning mr-2 form-btn btn-alignment">{{ __('messages.common.edit') }}</a>
                <a href="{{ url()->previous() }}" class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('contacts.show_fields')
                </div>
            </div>
        </div>
    </section>
@endsection

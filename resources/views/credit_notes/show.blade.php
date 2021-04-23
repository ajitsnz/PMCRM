@extends('layouts.app')
@section('title')
    {{ __('messages.credit_note.credit_note_details') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sales/view-as-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/credit_notes/credit_notes.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.credit_note.credit_note_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                @if($creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_CLOSED)
                <a href="{{ route('credit-notes.edit', ['creditNote' => $creditNote->id]) }}"
                   class="btn btn-warning mr-2 form-btn">{{ __('messages.common.edit') }}</a>
                @endif
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('credit_notes.show_fields')
                </div>
            </div>
        </div>
        @include('payments.templates.templates')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let creditNoteId = "{{ $creditNote->id }}";
        let ownerType = 'App\\Models\\CreditNote';
        let changePaymentStatus = "{{ route('credit-note.change-payment-status', $creditNote->id) }}";
    </script>
    <script src="{{ mix('assets/js/credit-notes/credit-notes.js') }}"></script>
@endsection

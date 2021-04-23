@extends('layouts.app')
@section('title')
    {{ __('messages.invoice.invoice_details') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sales/view-as-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/invoices/invoices.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.invoice.invoice_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                @if($invoice->payment_status !== \App\Models\Invoice::STATUS_PAID && $invoice->payment_status !== \App\Models\Invoice::STATUS_PARTIALLY_PAID && $invoice->payment_status !== \App\Models\Invoice::STATUS_CANCELLED)
                    <a href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}"
                       class="btn btn-warning mr-2 form-btn">{{ __('messages.common.edit') }}
                    </a>
                @endif
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('invoices.show_fields')
                </div>
            </div>
        </div>
        @include('tasks.templates.templates')
        @include('payments.templates.templates')
        @include('reminders.templates.templates')
        @include('payments.add_modal')
        @include('reminders.add_modal')
        @include('reminders.edit_modal')
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
        let noteUrl = "{{ route('notes.index') }}/";
        let noteSaveUrl = "{{ route('notes.store') }}";
        let paymentUrl = "{{ route('payments.index') }}/";
        let addPaymentUrl = "{{ route('payments.create') }}";
        let paymentSaveUrl = "{{ route('payments.store') }}";
        let invoiceUrl = "{{ route('invoices.index') }}";
        let invoiceId = "{{ $invoice->id }}";
        let ownerType = 'App\\Models\\Invoice';
        let reminderUrl = "{{ route('reminder.index') }}/";
        let reminderSaveUrl = "{{ route('reminder.store') }}";
        let changeStatus = "{{ route('invoice.change-status', $invoice->id) }}";
        let taskUrl = "{{ route('tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
        let ownerId = "{{ $invoice->id }}";
        let authId = '{{ Auth::id() }}';
        let ownerUrl = "{{ route('invoices.index') }}";
    </script>
    <script src="{{ mix('assets/js/notes/new-notes.js')}}"></script>
    <script src="{{ mix('assets/js/reminder/reminder.js')}}"></script>
    <script src="{{ mix('assets/js/payments/payments.js') }}"></script>
    <script src="{{ mix('assets/js/custom/get-price-format.js') }}"></script>
    <script src="{{ mix('assets/js/payments/add-payment.js') }}"></script>
    <script src="{{ mix('assets/js/invoices/show-page.js') }}"></script>
    <script src="{{ mix('assets/js/tasks/tasks.js')}}"></script>
@endsection

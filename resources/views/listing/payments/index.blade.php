@extends('layouts.app')
@section('title')
    {{ __('messages.invoice.invoice_payments') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.invoice.invoice_payments') }}</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('listing.payments.table')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let paymentUrl = "{{ route('payments.list.index') }}/";
        let paymentViewUrl = "{{ route('payments.list.show') }}/";
        let ownerType = 'App\\Models\\Invoice';
    </script>
    <script src="{{ mix('assets/js/custom/get-price-format.js') }}"></script>
    <script src="{{mix('assets/js/listing/payments/payments.js')}}"></script>
@endsection

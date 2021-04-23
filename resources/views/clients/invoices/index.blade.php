@extends('clients.layouts.app')
@section('title')
    {{ __('messages.invoices') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/invoices/invoices.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        @include('flash::message')
        <div class="section-header">
            <h1>{{ __('messages.invoices') }}</h1>
            <div class="section-header-breadcrumb">
                {{ Form::select('payment_status',$paymentStatus,null,['id' => 'paymentStatus','class' => 'form-control status-filter','placeholder' => 'Select Status']) }}
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="font-weight-bold anchor-underline text-primary">{{ __('messages.invoice.unpaid_cap') }}</span>
                                    <span class="float-right">
                                        {{ $invoiceStatusCount['unpaid'] }}
                                        / {{ $invoiceStatusCount['total_invoices'] }}
                                    </span>
                                </div>
                                @php
                                $style = 'style';
                                $width = 'width';
                                @endphp
                                <div class="col-md-12">
                                    <div class="progress no-margin height-25">
                                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic"
                                             role="progressbar"
                                             aria-valuenow="{{ $invoiceStatusCount['unpaid'] * 100/totalCountForDashboard($invoiceStatusCount['total_invoices']) }}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             {{$style}}="{{$width}}:{{ $invoiceStatusCount['unpaid'] * 100/totalCountForDashboard($invoiceStatusCount['total_invoices']) }}%">{{ number_format($invoiceStatusCount['unpaid'] * 100/totalCountForDashboard($invoiceStatusCount['total_invoices']),2) }}
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="font-weight-bold anchor-underline text-success">{{ __('messages.invoice.paid_cap') }}</span>
                                    <span class="float-right">
                                        {{ $invoiceStatusCount['paid'] }}
                                        / {{ $invoiceStatusCount['total_invoices'] }}
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <div class="progress no-margin height-25">
                                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic"
                                             role="progressbar"
                                             aria-valuenow="{{ $invoiceStatusCount['paid'] * 100/totalCountForDashboard($invoiceStatusCount['total_invoices']) }}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             {{$style}}="{{$width}} : {{ $invoiceStatusCount['paid'] * 100/totalCountForDashboard($invoiceStatusCount['total_invoices']) }}%">{{ number_format($invoiceStatusCount['paid'] * 100/totalCountForDashboard($invoiceStatusCount['total_invoices']),2) }}
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                        @livewire('clients.invoices')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page_scripts')
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let invoiceUrl = '{{ route('clients.invoices.index') }}/';
        let viewAsCustomer = 'view-as-customer';
    </script>
    <script src="{{ mix('assets/js/custom/get-price-format.js') }}"></script>
    <script src="{{ mix('assets/js/clients/invoices/invoices.js') }}"></script>
@endsection

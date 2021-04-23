@extends('clients.layouts.app')
@section('title')
    {{ __('messages.estimates') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/clients/estimates/estimates.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.estimates') }}</h1>
            <div class="section-header-breadcrumb">
                {!! Form::select('status',$estimateStatus,null,['class' => 'form-control','id' => 'estimateStatus','placeholder' => 'Select Status']) !!}
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="font-weight-bold anchor-underline text-primary">{{ __('messages.estimate.sent') }}</span>
                                    <span class="float-right">
                                        {{ $estimateStatusCount['sent'] }}
                                        / {{ $estimateStatusCount['total_estimates'] }}
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
                                             aria-valuenow="{{ $estimateStatusCount['sent'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             {{$style}}="{{$width}}:{{ $estimateStatusCount['sent'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}%">{{ number_format($estimateStatusCount['sent'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']),2) }}
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="font-weight-bold anchor-underline text-success">{{ __('messages.estimate.accepted') }}</span>
                                    <span class="float-right">
                                        {{ $estimateStatusCount['accepted'] }}
                                        / {{ $estimateStatusCount['total_estimates'] }}
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <div class="progress no-margin height-25">
                                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic"
                                             role="progressbar"
                                             aria-valuenow="{{ $estimateStatusCount['accepted'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             {{$style}}="{{$width}}:{{ $estimateStatusCount['accepted'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}%">{{ number_format($estimateStatusCount['accepted'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']),2) }}
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="font-weight-bold anchor-underline text-info">{{ __('messages.estimate.declined') }}</span>
                                    <span class="float-right">
                                        {{ $estimateStatusCount['declined'] }}
                                        / {{ $estimateStatusCount['total_estimates'] }}
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <div class="progress no-margin height-25">
                                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic"
                                             role="progressbar"
                                             aria-valuenow="{{ $estimateStatusCount['declined'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             {{$style}}="{{$width}}:{{ $estimateStatusCount['declined'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}%">{{ number_format($estimateStatusCount['declined'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']),2) }}
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('clients.estimates.index') }}"
                                       class="font-weight-bold anchor-underline text-danger">{{ __('messages.estimate.expired') }}</a>
                                    <span class="float-right">
                                        {{ $estimateStatusCount['expired'] }}
                                        / {{ $estimateStatusCount['total_estimates'] }}
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <div class="progress no-margin height-25">
                                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic"
                                             role="progressbar"
                                             aria-valuenow="{{ $estimateStatusCount['expired'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             {{$style}}="{{$width}}: {{ $estimateStatusCount['expired'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}%"
                                             data-percent="{{ $estimateStatusCount['expired'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']) }}%">{{ number_format($estimateStatusCount['expired'] * 100/totalCountForDashboard($estimateStatusCount['total_estimates']),2)}}
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
        @livewire('clients.estimates')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let estimateIndexUrl = '{{ route('clients.estimates.index') }}';
        let viewAsCustomerUrl = 'view-as-customer';
    </script>
    <script src="{{ mix('assets/js/custom/get-price-format.js') }}"></script>
    <script src="{{ mix('assets/js/clients/estimates/estimates.js') }}"></script>
@endsection

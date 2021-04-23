@extends('clients.layouts.app')
@section('title')
    {{ __('messages.proposals') }}
@endsection

@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}" type="text/css">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.proposals') }}</h1>
            <div class="section-header-breadcrumb">
                {!! Form::select('status',$proposalStatus,null,['class' => 'form-control','id' => 'proposalStatus','placeholder' => 'Select Status']) !!}
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="font-weight-bold anchor-underline text-danger">{{ __('messages.proposal.open') }}</span>
                                    <span class="float-right">
                                        {{ $proposalStatusCount['open'] }} / {{ $proposalStatusCount['total_proposals'] }}
                                    </span>
                                </div>
                                @php
                                    $style = 'style';
                                    $width = 'width';
                                @endphp
                                <div class="col-md-12">
                                    <div class="progress no-margin height-25">
                                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic" role="progressbar" aria-valuenow="{{ $proposalStatusCount['open'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']) }}" aria-valuemin="0" aria-valuemax="100"{{$style}}="{{$width}} :{{ $proposalStatusCount['open'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']) }}%">
                                        {{ number_format($proposalStatusCount['open'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']),2) }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <span class="font-weight-bold anchor-underline text-primary">{{ __('messages.proposal.revised') }}</span>
                                <span class="float-right">
                                    {{ $proposalStatusCount['revised'] }} / {{ $proposalStatusCount['total_proposals'] }}
                                </span>
                            </div>
                            <div class="col-md-12">
                                <div class="progress no-margin height-25">
                                    <div class="progress-bar progress-bar-default no-percent-text not-dynamic" role="progressbar" aria-valuenow="{{ $proposalStatusCount['revised'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']) }}" aria-valuemin="0" aria-valuemax="100" {{$style}}="{{$width}} :{{ $proposalStatusCount['revised'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']) }}%">
                                    {{ number_format($proposalStatusCount['revised'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']),2) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="font-weight-bold anchor-underline text-success">{{ __('messages.proposal.accepted') }}</span>
                            <span class="float-right">
                                {{ $proposalStatusCount['accepted'] }} / {{ $proposalStatusCount['total_proposals'] }}
                            </span>
                        </div>
                        <div class="col-md-12">
                            <div class="progress no-margin height-25">
                                <div class="progress-bar progress-bar-default no-percent-text not-dynamic" role="progressbar" aria-valuenow="{{ $proposalStatusCount['accepted'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']) }}" aria-valuemin="0" aria-valuemax="100"{{$style}}="{{$width}} :{{ $proposalStatusCount['accepted'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']) }}%">
                                {{ number_format($proposalStatusCount['accepted'] * 100/totalCountForDashboard($proposalStatusCount['total_proposals']),2) }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        @livewire('clients.proposals')
    </section>
@endsection

@section('page_scripts')
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let proposalUrl = '{{ route('clients.proposals.index') }}/';
        let viewAsCustomer = 'view-as-customer';
    </script>
    <script src="{{ mix('assets/js/custom/get-price-format.js') }}"></script>
    <script src="{{ mix('assets/js/clients/proposals/proposals.js') }}"></script>
@endsection

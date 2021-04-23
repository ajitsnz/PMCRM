@extends('clients.layouts.app')
@section('title')
    {{ __('messages.client_dashboard') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/clients/dashboard.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card card-statistic-2 d-total-four-border">
                    <div class="card-stats">
                        <div class="card-stats-title">
                            <a href="{{route('clients.projects.index')}}"
                               class="font-weight-bold anchor-underline">{{ __('messages.projects') }}</a>
                        </div>
                        <div class="card-stats-items d-stat-items-flex">
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $projectStatusCount['not_started'] }}</div>
                                <span class="font-weight-bold text-danger">{{ __('messages.project.not_started') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $projectStatusCount['in_progress'] }}</div>
                                <span class="font-weight-bold text-primary">{{ __('messages.project.in_progress') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $projectStatusCount['on_hold'] }}</div>
                                <span class="font-weight-bold text-warning">{{ __('messages.project.on_hold') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $projectStatusCount['cancelled'] }}</div>
                                <span class="font-weight-bold text-info">{{ __('messages.project.cancelled') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $projectStatusCount['finished'] }}</div>
                                <span class="font-weight-bold text-success">{{ __('messages.project.finished') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary d-total-four-bg d-border-radius">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('messages.project.total_projects') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $projectStatusCount['total_projects'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card card-statistic-2 d-total-one-border">
                    <div class="card-stats">
                        <div class="card-stats-title">
                            <a href="{{route('clients.invoices.index')}}"
                               class="font-weight-bold anchor-underline">{{ __('messages.invoices') }}</a>
                        </div>
                        <div class="card-stats-items d-stat-items-flex">
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $invoiceStatusCount['unpaid'] }}</div>
                                <span class="font-weight-bold text-primary">{{ __('messages.invoice.unpaid') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $invoiceStatusCount['partially_paid'] }}</div>
                                <span class="font-weight-bold text-info">{{ __('messages.invoice.partially_paid') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $invoiceStatusCount['paid'] }}</div>
                                <span class="font-weight-bold text-success">{{ __('messages.invoice.paid') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary d-total-one-bg d-border-radius">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('messages.invoice.total_invoices') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $invoiceStatusCount['total_invoices'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card card-statistic-2 d-total-three-border">
                    <div class="card-stats">
                        <div class="card-stats-title">
                            <a href="{{route('clients.proposals.index')}}"
                               class="font-weight-bold anchor-underline">{{ __('messages.proposals') }}</a>
                        </div>
                        <div class="card-stats-items d-stat-items-flex">
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $proposalStatusCount['open'] }}</div>
                                <span class="font-weight-bold text-danger">{{ __('messages.proposal.open') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $proposalStatusCount['revised'] }}</div>
                                <span class="font-weight-bold text-primary">{{ __('messages.proposal.revised') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $proposalStatusCount['accepted'] }}</div>
                                <span class="font-weight-bold text-success">{{ __('messages.proposal.accepted') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $proposalStatusCount['declined'] }}</div>
                                <span class="font-weight-bold text-info">{{ __('messages.proposal.declined') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary d-total-three-bg d-border-radius">
                        <i class="fas fa-scroll"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('messages.proposal.total_proposal') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $proposalStatusCount['total_proposals'] }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card card-statistic-2 d-total-two-border">
                    <div class="card-stats">
                        <div class="card-stats-title">
                            <a href="{{route('clients.estimates.index')}}"
                               class="font-weight-bold anchor-underline">{{ __('messages.estimates') }}</a>
                        </div>
                        <div class="card-stats-items d-stat-items-flex">
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $estimateStatusCount['sent'] }}</div>
                                <span class="font-weight-bold text-primary">{{ __('messages.estimate.sent') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $estimateStatusCount['accepted'] }}</div>
                                <span class="font-weight-bold text-success">{{ __('messages.estimate.accepted') }}</span>
                            </div>
                            <div class="card-stats-item d-stat-item-flex">
                                <div class="card-stats-item-count">{{ $estimateStatusCount['declined'] }}</div>
                                <span class="font-weight-bold text-info">{{ __('messages.estimate.declined') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary d-total-two-bg d-border-radius">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('messages.estimate.total_estimates') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $estimateStatusCount['total_estimates'] }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

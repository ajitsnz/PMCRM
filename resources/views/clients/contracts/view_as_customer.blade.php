<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $contract->subject }}</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/sales/view-as-customer.css') }}">
</head>
<body>
<div class="container">
    <div class="col-12">
        <div class="row">
            <div class="logo mt-4">
                <a href="{{ route('clients.dashboard') }}">
                    <img src="{{ asset('assets/img/infyom-logo.png') }}" class="img-fluid">
                </a>
            </div>
        </div>
    </div>
    <div class="buttons d-flex mt-5 justify-content-between">
        <div class="status">
        </div>
        <div class="download-btn">
            <a href="{{ route('clients.contracts.index') }}" class="btn btn-light btn-sm text-uppercase mx-1 border">
                <i class="fa fa-undo"></i> {{ __('messages.common.back') }}</a>
            <a href="{{ route('clients.contracts.pdf', ['contract' => $contract->id]) }}"
               class="btn btn-light btn-sm text-uppercase mx-1 border">
                <i class="far fa-file-pdf"></i> {{ __('messages.common.download') }}
            </a>
            {{--            <button type="button" class="btn btn-success btn-sm text-uppercase mx-1">--}}
            {{--                {{ __('messages.contract.sign') }}--}}
            {{--            </button>--}}
        </div>
    </div>
    <div class="card my-4 shadow ">
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h4>{{ html_entity_decode($contract->subject) }}</h4>
                        <div class="invoice-addresses">
                            <div class="w-75 customer-addresses text-muted mb-2">
                                <p class="m-0"><span class="font-weight-bold">{{ __('messages.contract.contract_value') .':' }}
                                    </span> {{ isset($contract->contract_value) ? number_format($contract->contract_value, 2) : __('messages.common.n/a') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="invoice-date d-table float-right">
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.contract.start_date').':' }}</div>
                                <div class="d-table-cell">{{ !empty($contract->start_date) ? Carbon\Carbon::parse($contract->start_date)->format('jS M, Y')                                    : __('messages.common.n/a')}}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.contract.end_date').':' }}</div>
                                <div class="d-table-cell">{{ !empty($contract->end_date) ? Carbon\Carbon::parse($contract->end_date)->format('jS M, Y') :                                        __('messages.common.n/a')}}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.contract.contract_type_id').':'                                              }}</div>
                                <div class="d-table-cell">{{ !empty($contract->type->name) ? html_entity_decode($contract->type->name) : __('messages.common.n/a') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="row">
                    <p>{!! !empty($contract->description) ? html_entity_decode($contract->description) : __('messages.common.n/a')!!}</p>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>

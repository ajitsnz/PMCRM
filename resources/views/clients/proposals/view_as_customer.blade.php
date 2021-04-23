<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.proposal.proposal_prefix').$proposal->proposal_number }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/sales/view-as-customer.css') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/sales/view-as-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/proposals/proposals.css') }}">
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
            <a href="#"
               class="btn btn-outline-secondary mx-1 status-{{ \App\Models\Proposal::STATUS[$proposal->status] }}">
                {{ \App\Models\Proposal::STATUS[$proposal->status] }}
            </a>
        </div>
        {{ Form::open(['route' => ['clients.proposals.change-status',$proposal->id], 'method' => 'post']) }}
        @csrf
        <div class="download-btn">
            <a href="{{ route('clients.proposals.index') }}"
               class="btn btn-light btn-sm text-uppercase mx-1 mt-1 border">
                <i class="fa fa-undo"></i> {{ __('messages.common.back') }}</a>
            <a href="{{ route('clients.proposal.pdf', ['proposal' => $proposal->id]) }}"
               class="btn btn-light btn-sm text-uppercase mx-1 mt-1 border">
                <i class="far fa-file-pdf"></i> {{ __('messages.common.download') }}
            </a>

            @if($proposal->status == \App\Models\Proposal::STATUS_DECLINED)
                <button type="button"
                        class="btn btn-success btn-sm text-uppercase mx-1 mt-1 mt-md-0">{{ __('messages.proposal.declined') }}</button>
            @elseif($proposal->status != \App\Models\Proposal::STATUS_ACCEPTED)
                <button type="submit" name="status" class="btn btn-light btn-sm text-uppercase mx-1 mt-1 border"
                        value="4">
                    <i class="fa fa-times"></i> {{ __('messages.proposal.decline') }}</button>
            @endif

            @if($proposal->status == \App\Models\Proposal::STATUS_ACCEPTED)
                <button type="button"
                        class="btn btn-success btn-sm text-uppercase mx-1 mt-1 mt-md-0">{{ __('messages.proposal.accepted') }}</button>
            @elseif($proposal->status != \App\Models\Proposal::STATUS_DECLINED)
                <button type="submit" name="status" class="btn btn-success btn-sm text-uppercase mx-1 mt-1" value="5">
                    <i class="fa fa-check"></i> {{ __('messages.proposal.accept') }}</button>
            @endif
        </div>
        {{ Form::close() }}
    </div>
    <div class="card my-4 shadow ">
        <div class="card-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h4>{{ __('messages.proposal.proposal_prefix').$proposal->proposal_number }}</h4>
                        <p class="invoice-company-name m-0 text-muted font-weight-bold">{{ html_entity_decode($proposal->title) }}</p>
                        <div class="invoice-addresses">
                            <div class="w-75 customer-addresses text-muted mb-2">
                                <p class="m-0">{{ $proposal->phone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        @foreach($proposal->proposalAddresses as $address)
                            <div class="w-75 float-right invoice-addresses text-right text-muted mb-2">
                                <p class="font-weight-bold m-0">{{ ($address->type == 1) ? __('messages.proposal.bill_to') : __('messages.proposal.ship_to') }}
                                    :</p>
                                <p class="m-0">{{ $address->street }}</p>
                                <p class="m-0">{{ $address->city }} {{ $address->state }}</p>
                                <p class="m-0">{{ $address->country }}</p>
                                <p class="m-0">{{ $address->zip_code }}</p>
                            </div>
                        @endforeach
                        <div class="invoice-date d-table float-right">
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.proposal.proposal_date').':' }}</div>
                                <div class="d-table-cell">{{ !empty($proposal->date) ? Carbon\Carbon::parse($proposal->date)->format('jS M, Y') : __('messages                                     .common.n/a')}}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.proposal.open_till').':' }}</div>
                                <div class="d-table-cell">{{ !empty($proposal->open_till) ? Carbon\Carbon::parse($proposal->open_till)->format('jS M, Y') :                                        __('messages.common.n/a')}}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.proposal.member').':' }}</div>
                                <div class="d-table-cell">{{ !empty($proposal->user) ? $proposal->user->full_name : __('messages.common.n/a')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 mt-5">
                        <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('messages.proposal.item') }}</th>
                                <th scope="col">{{ __('messages.proposal.qty') }}</th>
                                <th scope="col" class="text-right itemRate">{{ __('messages.proposal.rate') }}</th>
                                <th scope="col">{{ __('messages.proposal.taxes') }}</th>
                                <th scope="col" class="text-right itemTotal">{{ __('messages.proposal.amount') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($proposal->salesItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <p class="m-0">{{ html_entity_decode($item->item) }}</p>
                                        <p class="text-muted m-0 table-data">
                                            <small>{{ html_entity_decode($item->description) }}</small></p>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-right">
                                        <small class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></small>
                                        {{ number_format($item->rate, 2) }}
                                    </td>
                                    <td>
                                        @forelse($item->taxes as $tax)
                                            <span class="badge badge-secondary font-weight-normal">{{ $tax->tax_rate }}%</span>
                                        @empty
                                            <p>{{ __('messages.common.n/a') }}</p>
                                        @endforelse
                                    </td>
                                    <td class="text-right">
                                        <small class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></small>
                                        {{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table class="table w-25 float-right text-right">
                            <tbody>
                            <tr>
                                <td>
                                    {{ __('messages.proposal.sub_total').':' }}
                                </td>
                                <td class="amountData">
                                    <small class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></small>
                                    {{ !empty($proposal->sub_total) ? number_format($proposal->sub_total, 2) : __('messages.common.n/a') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ __('messages.proposal.discount').':' }}
                                </td>
                                <td>
                                    {{ formatNumber($proposal->discount) }}{{ isset($proposal->discount_symbol) && $proposal->discount_symbol == 1 ? '%' : '' }}
                                </td>
                            </tr>
                            @foreach($proposal->salesTaxes as $commonTax)
                                <tr>
                                    <td>{{ __('messages.item.tax') }} {{ $commonTax->tax }}%</td>
                                    <td>
                                        <small class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></small>
                                        {{ number_format($commonTax->amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>{{ __('messages.proposal.adjustment').':' }}</td>
                                <td class="w-23">
                                    <small class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></small>
                                    {{ number_format($proposal->adjustment) }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('messages.proposal.total').':' }}</td>
                                <td class="w-23">
                                    <small class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></small>
                                    {{ number_format($proposal->total_amount,2) }}
                                </td>
                            </tr>
                            <tr class="text-danger">
                                <td>{{ __('messages.proposal.amount_due').':' }}</td>
                                <td class="w-23">
                                    <small class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></small>
                                    {{ number_format($proposal->total_amount, 2) }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
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

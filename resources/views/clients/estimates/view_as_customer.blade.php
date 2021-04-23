<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.estimate.estimate_prefix').$estimate->estimate_number }}</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/sales/view-as-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/estimates/estimates.css') }}">
</head>
<body>
<div class="container">
    <div class="col-12">
        <div class="row">
            <div class="logo mt-4">
                <a href="{{ route('clients.estimates.index') }}">
                    <img src="{{ asset('assets/img/infyom-logo.png') }}" class="img-fluid">
                </a>
            </div>
        </div>
    </div>
    <div class="buttons d-flex mt-5 justify-content-between">
        <div class="status mt-1">
            <a href="#"
               class="btn btn-outline-secondary mx-1 status-{{ \App\Models\Estimate::STATUS[$estimate->status] }}">
                {{ \App\Models\Estimate::STATUS[$estimate->status] }}
            </a>
        </div>
        {{ Form::open(['route' => ['clients.estimates.change-status',$estimate->id], 'method' => 'post']) }}
        @csrf
        <div class="download-btn">
            <a href="{{ route('clients.estimates.index') }}"
               class="btn btn-light btn-sm text-uppercase mx-1 mt-1 border">
                <i class="fa fa-undo"></i> {{ __('messages.common.back') }}</a>
            <a href="{{ route('clients.estimate.pdf', ['estimate' => $estimate->id]) }}"
               class="btn btn-light btn-sm text-uppercase mx-1 mt-1 border">
                <i class="far fa-file-pdf"></i> {{ __('messages.common.download') }}
            </a>

            @if($estimate->status == \App\Models\Estimate::STATUS_SEND)
                <button type="submit" name="status" class="btn btn-light btn-sm text-uppercase mx-1 mt-1 border"
                        value="3">
                    <i class="fa fa-times"></i> {{ __('messages.proposal.decline') }}
                </button>
                <button type="submit" name="status" class="btn btn-success btn-sm text-uppercase mx-1 mt-1" value="4">
                    <i class="fa fa-check"></i> {{ __('messages.proposal.accept') }}
                </button>
            @endif

            @if($estimate->status == \App\Models\Estimate::STATUS_DECLINED)
                <button type="submit" name="status" class="btn btn-success btn-sm text-uppercase mx-1 mt-1" value="4">
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
                        <h4>{{ __('messages.estimate.estimate_prefix').$estimate->estimate_number }}</h4>
                        <p class="invoice-company-name m-0 text-muted font-weight-bold">{{ html_entity_decode($estimate->customer->company_name) }}</p>
                        <div class="invoice-addresses">
                            <div class="w-75 customer-addresses text-muted mb-2">
                                <p class="m-0">{{ !empty($estimate->customer->street) ? $estimate->customer->street : '' }}</p>
                                <p class="m-0">{{ !empty($estimate->customer->city) ? $estimate->customer->city : '' }} {{ !empty($estimate->customer->state) ? $estimate->customer->state : '' }}</p>
                                <p class="m-0">{{ !empty($estimate->customer->country) ? \App\Models\Customer::COUNTRIES[$estimate->customer->country] : '' }}</p>
                                <p class="m-0">{{ !empty($estimate->customer->zip) ? $estimate->customer->zip : '' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 estimateDetail">
                        @foreach($estimate->estimateAddresses as $address)
                            <div class="w-75 float-right invoice-addresses text-right text-muted mb-2">
                                <p class="font-weight-bold m-0">{{ ($address->type == 1) ? __('messages.estimate.bill_to') : __('messages.estimate.ship_to') }}
                                    :</p>
                                <p class="m-0">{{ $address->street }}</p>
                                <p class="m-0">{{ $address->city }}, {{ $address->state }}</p>
                                <p class="m-0">{{ $address->country }}</p>
                                <p class="m-0">{{ $address->zip_code }}</p>
                            </div>
                        @endforeach
                        <div class="invoice-date d-table float-right">
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.estimate.estimate_date').':' }}</div>
                                <div class="d-table-cell">{{ !empty($estimate->estimate_date) ? Carbon\Carbon::parse($estimate->estimate_date)->format('jS M, Y') : __('messages.common.n/a')}}
                                </div>
                            </div>
                            <div class="d-table-row">
                                <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.estimate.expiry_date').':' }}</div>
                                <div class="d-table-cell">{{ !empty($estimate->estimate_expiry_date) ? 
                                       Carbon\Carbon::parse($estimate->estimate_expiry_date)->format('jS M, Y') : __('messages.common.n/a')}}</div>
                            </div>
                            @if(isset($estimate->sales_agent_id))
                                <div class="d-table-row">
                                    <div class="d-table-cell text-right font-weight-bold text-muted pr-1">{{ __('messages.invoice.sale_agent').':' }}</div>
                                    <div class="d-table-cell">{{ !empty($estimate->sales_agent_id) ? $estimate->user->full_name : __('messages.common.n/a') }}</div>
                                </div>
                            @endif
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
                                <th scope="col">{{ __('messages.estimate.item') }}</th>
                                <th scope="col">{{ __('messages.estimate.qty') }}</th>
                                <th scope="col" class="text-right itemRate">{{ __('messages.estimate.rate') }}</th>
                                <th scope="col">{{ __('messages.estimate.taxes') }}</th>
                                <th scope="col" class="text-right itemTotal">{{ __('messages.estimate.amount') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($estimate->salesItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <p class="m-0">{{ html_entity_decode($item->item) }}</p>
                                        <p class="text-muted m-0 table-data">
                                            <small>{{ html_entity_decode($item->description) }}</small></p>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-right">
                                        <small class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></small>
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
                                        <small class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></small>
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
                                    {{ __('messages.estimate.sub_total').':' }}
                                </td>
                                <td class="amountData">
                                    <small class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></small>
                                    {{ !empty($estimate->sub_total) ? number_format($estimate->sub_total, 2) : __('messages.common.n/a') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ __('messages.estimate.discount').':' }}
                                </td>
                                <td>
                                    {{ formatNumber($estimate->discount) }}{{ isset($estimate->discount_symbol) && $estimate->discount_symbol == 1 ? '%' : '' }}
                                </td>
                            </tr>
                            @foreach($estimate->salesTaxes as $commonTax)
                                <tr>
                                    <td>{{ __('messages.item.tax') }} {{ $commonTax->tax }}%</td>
                                    <td>
                                        <small class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></small>
                                        {{ number_format($commonTax->amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>{{ __('messages.estimate.adjustment').':' }}</td>
                                <td class="w-23">
                                    <small class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></small>
                                    {{ number_format($estimate->adjustment) }}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('messages.estimate.total').':' }}</td>
                                <td class="w-23">
                                    <small class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></small>
                                    {{ number_format($estimate->total_amount,2) }}
                                </td>
                            </tr>
                            <tr class="text-danger">
                                <td>{{ __('messages.estimate.amount_due').':' }}</td>
                                <td class="w-23">
                                    <small class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></small>
                                    {{ number_format($estimate->total_amount - $totalPaid,2) }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <p class="font-weight-bold">{{ __('messages.estimate.terms_conditions').':' }}</p>
                        {!! !empty($estimate->term_conditions) ? html_entity_decode($estimate->term_conditions) :  __('messages.common.n/a')  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>

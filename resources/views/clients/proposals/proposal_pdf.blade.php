<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.proposal.proposal_pdf') }}</title>
    <link rel="stylesheet" href="{{ asset('css/invoices/invoice-pdf.css') }}">
</head>
<body>
<table class="main-table">
    <tr>
        <td class="app-logo">
            <img src="{{ $settings['logo'] }}">
        </td>
        <td class="text-right invoice-number">
            <h2 class="text-uppercase">{{ __('messages.proposals') }}</h2>
            <p>{{ __('messages.proposal.proposal_prefix') }}{{ $proposal->proposal_number }}</p>
        </td>
    </tr>
    <tr>
        <td class="invoice-customer-detail">
            <p class="font-weight-bold m-0">{{ html_entity_decode($proposal->title) }}</p>
            <div class="invoice-address">
                <div class="w-75 customer-addresses mb-2">
                    <p class="m-0">{{ $proposal->phone }}</p>
                </div>
            </div>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td>
                        @foreach($proposal->proposalAddresses as $address)
                            <div class="invoice-addresses text-right mb-2">
                                <p class="font-weight-bold m-0">{{ ($address->type == 1) ? __('messages.proposal.bill_to') : __('messages.proposal.ship_to') }}
                                    :</p>
                                <p class="m-0">{{ html_entity_decode($address->street) }}</p>
                                <p class="m-0">{{ $address->city }}, {{ $address->state }}</p>
                                <p class="m-0">{{ $address->country }}</p>
                                <p class="m-0">{{ $address->zip_code }}</p>
                            </div>
                        @endforeach
                        <div class="text-right">
                            <table class="invoice-date-table">
                                <tr>
                                    <td class="text-right font-weight-bold">{{ __('messages.proposal.proposal_date').': ' }}</td>
                                    <td>{{ !empty($proposal->date) ? Carbon\Carbon::parse($proposal->date)->format('jS M, Y') : __('messages.common.n/a') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right font-weight-bold">{{ __('messages.proposal.open_till').': ' }}</td>
                                    <td>{{ !empty($proposal->open_till) ? Carbon\Carbon::parse($proposal->open_till)->format('jS M, Y') : __('messages.common.n/a') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right font-weight-bold">{{ __('messages.proposal.member').': ' }}</td>
                                    <td>{{ !empty($proposal->user) ? html_entity_decode($proposal->user->full_name) : __('messages.common.n/a') }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" class="table table-bordered invoice-sales-items mt-2">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('messages.proposal.item') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.proposal.qty') }}</th>
                    <th scope="col" class="text-right rate">{{ __('messages.proposal.rate') }}( <span
                                class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                        )
                    </th>
                    <th scope="col">{{ __('messages.proposal.taxes') }}</th>
                    <th scope="col" class="text-right total-amount">{{ __('messages.proposal.amount') }}( <span
                                class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                        )
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($proposal->salesItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <p class="m-0">{{ html_entity_decode($item->item) }}</p>
                            <p class="text-muted m-0 table-data">
                                <small>{{ html_entity_decode($item->description) }}</small></p>
                        </td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">
                            <span class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                            {{ number_format($item->rate, 2) }}
                        </td>
                        <td>
                            @forelse($item->taxes as $tax)
                                <p><span class="badge badge-secondary font-weight-normal">{{ $tax->tax_rate }}%</span>
                                </p>
                            @empty
                                <p>{{ __('messages.common.n/a') }}</p>
                            @endforelse
                        </td>
                        <td class="text-right">
                            <span class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                            {{ number_format($item->total, 2) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td></td>
        <td class="float-right">
            <table class="table text-right invoice-footer-table mt-2">
                <tbody>
                <tr>
                    <td>
                        {{ __('messages.proposal.sub_total').':' }}
                    </td>
                    <td>
                        <span class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                        {{ !empty($proposal->sub_total) ? number_format($proposal->sub_total, 2) : __('messages.common.n/a') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('messages.invoice.discount').':' }}
                    </td>
                    <td>
                        {{ formatNumber($proposal->discount) }}{{ isset($proposal->discount_symbol) && $proposal->discount_symbol == 1 ? '%' : '' }}
                    </td>
                </tr>
                @foreach($proposal->salesTaxes as $commonTax)
                    <tr>
                        <td>{{ __('messages.item.tax') }} {{ $commonTax->tax }}%</td>
                        <td>
                            <span class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                            {{ number_format($commonTax->amount, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>{{ __('messages.invoice.adjustment').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                        {{ number_format($proposal->adjustment) }}
                    </td>
                </tr>
                <tr>
                    <td>{{ __('messages.invoice.total').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                        {{ number_format($proposal->total_amount, 2) }}
                    </td>
                </tr>
                <tr class="text-color">
                    <td>{{ __('messages.invoice.amount_due').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{ getCurrencyIcon($proposal->currency) }}</span>
                        {{ number_format($proposal->total_amount, 2) }}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p class="mt-2">{{ __('messages.proposal.authorized_signature').' _________________' }}</p>
        </td>
    </tr>
</table>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.credit_note.credit_note_pdf') }}</title>
    <link href="{{ asset('css/invoices/invoice-pdf.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
<table class="main-table">
    <tr>
        <td class="app-logo">
            <img src="{{ $settings['logo'] }}">
        </td>
        <td class="text-right invoice-number">
            <h2 class="text-uppercase">{{ __('messages.credit_note.credit_note') }}</h2>
            <p>{{ __('messages.credit_note.credit_note_prefix') }}{{ $creditNote->credit_note_number }}</p>
        </td>
    </tr>
    <tr>
        <td class="invoice-customer-detail">
            <p class="font-weight-bold m-0">{{ html_entity_decode($creditNote->customer->company_name) }}</p>
            <div class="invoice-address">
                <div class="w-75 customer-addresses mb-2">
                    <p class="m-0">{{ !empty($creditNote->customer->street) ? $creditNote->customer->street : '' }}</p>
                    <p class="m-0">{{ !empty($creditNote->customer->city) ? $creditNote->customer->city : '' }} {{ !empty($creditNote->customer->state) ? $creditNote->customer->state : '' }}</p>
                    <p class="m-0">{{ !empty($creditNote->customer->country) ? App\Models\Customer::COUNTRIES[$creditNote->customer->country] : ''}}</p>
                    <p class="m-0">{{ !empty($creditNote->customer->zip) ? $creditNote->customer->zip : '' }}</p>
                </div>
            </div>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td>
                        @foreach($creditNote->creditNoteAddresses as $address)
                            <div class="invoice-addresses text-right mb-2">
                                <p class="font-weight-bold m-0">{{ ($address->type == 1) ? __('messages.invoice.bill_to') : __('messages.invoice.ship_to') }}
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
                                    <td class="text-right font-weight-bold">{{ __('messages.credit_note.credit_note_date').': ' }}</td>
                                    <td>{{ !empty($creditNote->credit_note_date) ? Carbon\Carbon::parse($creditNote->credit_note_date)
                                        ->format('jS M, Y') : __('messages.common.n/a') }}</td>
                                </tr>
                                @if(!empty($creditNote->reference))
                                    <tr>
                                        <td class="text-right font-weight-bold">{{ __('messages.credit_note.reference').': ' }}</td>
                                        <td>{{ !empty($creditNote->reference) ? html_entity_decode($creditNote->reference) : __('messages.common.n/a') }}</td>
                                    </tr>
                                @endif
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
                    <th scope="col">{{ __('messages.invoice.item') }}</th>
                    <th scope="col" class="text-right">{{ __('messages.invoice.qty') }}</th>
                    <th scope="col" class="text-right rate">{{ __('messages.item.rate') }}( <span
                                class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}} </span>)
                    </th>
                    <th scope="col">{{ __('messages.invoice.taxes') }}</th>
                    <th scope="col" class="text-right total-amount">{{ __('messages.invoice.amount') }}( <span
                                class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}} </span>)
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($creditNote->salesItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <p class="m-0">{{ html_entity_decode($item->item) }}</p>
                            <p class="text-muted m-0 table-data">
                                <small>{{ html_entity_decode($item->description) }}</small></p>
                        </td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">
                            <span class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}}</span>
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
                            <span class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}}</span>
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
                        {{ __('messages.invoice.sub_total').':' }}
                    </td>
                    <td>
                        <span class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}}</span>
                        {{ !empty($creditNote->sub_total) ? number_format($creditNote->sub_total, 2) : __('messages.common.n/a') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('messages.invoice.discount').':' }}
                    </td>
                    <td>
                        {{ formatNumber($creditNote->discount) }}{{ isset($creditNote->discount_symbol) && $creditNote->discount_symbol == 1 ? '%' : '' }}
                    </td>
                </tr>
                @foreach($creditNote->salesTaxes as $commonTax)
                    <tr>
                        <td>{{ __('messages.item.tax') }} {{ $commonTax->tax }}%</td>
                        <td>
                            <span class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}}</span>
                            {{ number_format($commonTax->amount, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>{{ __('messages.invoice.adjustment').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}}</span>
                        {{ number_format($creditNote->adjustment) }}
                    </td>
                </tr>
                <tr>
                    <td>{{ __('messages.invoice.total').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}}</span>
                        {{ number_format($creditNote->total_amount, 2) }}
                    </td>
                </tr>
                <tr class="text-color">
                    <td>{{ __('messages.invoice.amount_due').':' }}</td>
                    <td>
                        <span class="pdf-css">&#{{getCurrencyIcon($creditNote->currency)}}</span>
                        {{ number_format($creditNote->total_amount, 2) }}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h4 class="mt-2">{{ __('messages.credit_note.client_note').':' }}</h4>
            {!! !empty($creditNote->client_note) ? html_entity_decode($creditNote->client_note) :  __('messages.common.n/a')  !!}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h4 class="mt-2">{{ __('messages.credit_note.terms_and_conditions').':' }}</h4>
            {!! !empty($creditNote->term_conditions) ? html_entity_decode($creditNote->term_conditions) :  __('messages.common.n/a')  !!}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p class="mt-2">{{ __('messages.credit_note.authorized_signature').' _________________' }}</p>
        </td>
    </tr>
</table>
</body>
</html>

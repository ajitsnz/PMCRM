<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('messages.contract.contract_pdf') }}</title>
    <link rel="stylesheet" href="{{ asset('css/invoices/invoice-pdf.css') }}">
</head>
<body>
<table class="main-table">
    <tr>
        <td class="app-logo">
            <img src="{{ $settings['logo'] }}">
        </td>
        <td class="text-right invoice-number">
            <h2 class="text-uppercase">{{ __('messages.contracts') }}</h2>
            <p>{{ html_entity_decode($contract->subject) }}</p>
        </td>
    </tr>
    <tr>
        <td class="invoice-customer-detail">
            <p class="font-weight-bold m-0">{{ html_entity_decode($contract->type->name) }}</p>
            <div class="invoice-address">
                <div class="w-75 customer-addresses mb-2">
                </div>
            </div>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td>
                        <div class="text-right">
                            <table class="invoice-date-table">
                                <tr>
                                    <td class="text-right font-weight-bold">{{ __('messages.contract.start_date').':' }}</td>
                                    <td>{{ !empty($contract->start_date) ? Carbon\Carbon::parse($contract->start_date)->format('jS M, Y')                                                        : __('messages.common.n/a')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right font-weight-bold">{{ __('messages.contract.end_date').': ' }}</td>
                                    <td>{{ !empty($contract->end_date) ? Carbon\Carbon::parse($contract->end_date)->format('jS M, Y') :                                                              __('messages.common.n/a')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right font-weight-bold">{{ __('messages.contract.customer_id').': ' }}</td>
                                    <td>{{ !empty($contract->customer_id) ? html_entity_decode($contract->customer->company_name) : __('messages.common.n/a') }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>{!! !empty($contract->description) ? html_entity_decode($contract->description) : __('messages.common.n/a') !!}</td>
    </tr>
    <tr>
        <td colspan="2">
            <p class="mt-2">{{ __('messages.contract.authorized_signature').' _________________' }}</p>
        </td>
    </tr>
</table>
</body>
</html>

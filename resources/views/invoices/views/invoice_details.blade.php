@extends('invoices.show')
@section('section')
    <hr>
    <div class="my-3 d-flex justify-content-between">
        <div>
            <a href="#"
               class="btn text-white mx-1 status-{{ \Illuminate\Support\Str::slug(\App\Models\Invoice::PAYMENT_STATUS[($invoice->payment_status)]) }}">
                {{ \App\Models\Invoice::PAYMENT_STATUS[$invoice->payment_status] }}
            </a>
        </div>
        <div>
            <div class="dropdown d-inline mx-1">
                <button class="btn btn-warning dropdown-toggle mx-1" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    {{ __('messages.invoice.more') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('invoice.pdf', ['invoice' => $invoice->id]) }}"
                       class="dropdown-item">{{ __('messages.common.download_as_pdf') }}
                    </a>
                    <a href="{{ route('invoice.view-as-customer',$invoice->id) }}"
                       class="dropdown-item text-content-wrap"
                       data-toggle="tooltip"
                       data-placement="bottom" title="{{ __('messages.invoice.view_invoice_as_customer') }}"
                       data-delay='{"show":"500", "hide":"50"}'>
                        {{ __('messages.invoice.view_invoice_as_customer') }}</a>
                    @if($invoice->payment_status != \App\Models\Invoice::STATUS_DRAFT && $invoice->payment_status != \App\Models\Invoice::STATUS_UNPAID)
                        <a id="markAsSent" class="dropdown-item text-content-wrap" href="#"
                           data-status="1" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.invoice.mark_as_sent') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.invoice.mark_as_sent') }}</a>
                    @elseif($invoice->payment_status == \App\Models\Invoice::STATUS_DRAFT)
                        <a id="markAsCancelled" class="dropdown-item text-content-wrap" href="#"
                           data-status="4" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.invoice.mark_as_cancelled') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.invoice.mark_as_cancelled') }}</a>
                    @endif
                    @if($invoice->payment_status == \App\Models\Invoice::STATUS_UNPAID)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsCancelled"
                           data-status="4" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.invoice.mark_as_cancelled') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.invoice.mark_as_cancelled') }}</a>
                    @elseif($invoice->payment_status == \App\Models\Invoice::STATUS_CANCELLED )
                        <a class="dropdown-item text-content-wrap" href="#" id="unmarkAsCancelled"
                           data-status="1" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.invoice.unmark_as_cancelled') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.invoice.unmark_as_cancelled') }}</a>
                    @endif
                </div>
            </div>
            @if($invoice->payment_status != \App\Models\Invoice::STATUS_CANCELLED)
                <div class="dropdown d-inline mx-1">
                    <a href="#" class="btn btn-primary mx-1  {{ $invoice->payment_status != 2 ? '' : 'disabled' }}"
                       data-toggle="modal" id="addPayment"
                       data-target="#addPaymentModa" data-id= {{ $invoice->id }}><i
                                class="fas fa-plus"></i> {{ __('messages.invoice.payments') }}</a>
                </div>
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-4 col-12">
            {{ Form::label('title', __('messages.invoice.title').':') }}
            <p>{{ html_entity_decode($invoice->title) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('invoice_number', __('messages.invoice.invoice_number').':') }}
            <p>{{ $invoice->invoice_number }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('customer', __('messages.invoice.customer').':') }}
            <p><a href="{{ url('admin/customers/'.$invoice->customer->id) }}"
                  class="anchor-underline">{{ html_entity_decode($invoice->customer->company_name) }}</a></p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('invoice_date', __('messages.invoice.invoice_date').':') }}
            <p>{{ Carbon\Carbon::parse($invoice->invoice_date)->format('jS M, Y') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('due_date', __('messages.invoice.due_date').':') }}
            <p>{{ isset($invoice->due_date) ? (Carbon\Carbon::parse($invoice->due_date)->format('jS M, Y')) : __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('sales_agent_id', __('messages.invoice.sale_agent').':') }}
            <p>
                @if(!empty($invoice->sales_agent_id))
                    <a href="{{ url('admin/members/'.$invoice->sales_agent_id) }}" class="anchor-underline">
                        {{ html_entity_decode($invoice->user->full_name) }}
                    </a>
                @else
                    {{ __('messages.common.n/a') }}
                @endif
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('currency', __('messages.invoice.currency').':') }}
            <p>{{ $invoice->getCurrencyText($invoice->currency) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('discount_type', __('messages.invoice.discount_type').':') }}
            <p>{{ $invoice->getDiscountTypeText($invoice->discount_type) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('tags', __('messages.tags').':') }}
            <p>
                @forelse($invoice->tags as $tag)
                    <span class="badge border border-secondary">{{ html_entity_decode($tag->name) }}</span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('payment_modes', __('messages.payment_modes').':') }}
            <p>
                @forelse($invoice->paymentModes as $paymentMode)
                    <span class="badge badge-light mb-1">{{ html_entity_decode($paymentMode->name) }} </span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($invoice->created_at)) }}">{{ $invoice->created_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($invoice->updated_at)) }}">{{ $invoice->updated_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('admin_text', __('messages.invoice.admin_note').':') }}<br>
            {!! !empty($invoice->admin_text) ? html_entity_decode($invoice->admin_text) :  __('messages.common.n/a')  !!}
        </div>
        <div class="col-12">
            <div class="row">
                @foreach($invoice->invoiceAddresses as $address)
                    @if($address->type == 1)
                        <div class="form-group col-md-4 col-12">
                            {{ Form::label('bill_to', __('messages.invoice.bill_to').':') }}
                            <div>{{ html_entity_decode($address->street) }},</div>
                            <div>{{ $address->city }},</div>
                            <div>{{ $address->state }},</div>
                            <div>{{ $address->country }},</div>
                            <div>{{ $address->zip_code }}</div>
                        </div>
                    @else
                        <div class="form-group col-md-4 col-12">
                            {{ Form::label('bill_to', __('messages.invoice.ship_to').':') }}
                            <div>{{ html_entity_decode($address->street) }},</div>
                            <div>{{ $address->city }},</div>
                            <div>{{ $address->state }},</div>
                            <div>{{ $address->country }},</div>
                            <div>{{ $address->zip_code }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-bordered">
            <thead>
            <tr>
                <th>{{ __('messages.invoice.item') }}</th>
                <th>{{ __('messages.common.description') }}</th>
                @if($invoice->unit == 1)
                    <th class="text-right">{{ __('messages.invoice.qty') }}</th>
                @elseif($invoice->unit == 2)
                    <th class="text-right">{{ __('messages.invoice.hours') }}</th>
                @else
                    <th class="text-right">{{ __('messages.invoice.qty/hours') }}</th>
                @endif
                <th class="text-right itemRate">{{ __('messages.item.rate') }}(<i
                            class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i>)
                </th>
                <th class="text-right itemTax">{{ __('messages.invoice.taxes') }}(<i class="fas fa-percentage"></i>)
                </th>
                <th class="text-right itemTotal">{{ __('messages.invoice.total') }}(<i
                            class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i>)
                </th>
            </tr>
            </thead>
            @foreach($invoice->salesItems as $item)
                <tr>
                    <td>{{ html_entity_decode($item->item) }}</td>
                    <td class="table-data">{!!  !empty($item->description) ? $item->description : __('messages.common.n/a') !!}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right"><i class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i>
                        {{ formatNumber($item->rate) }}</td>
                    <td class="text-right show-taxes-list">
                        @forelse($item->taxes as $tax)
                            <span class="badge badge-light">{{ $tax->tax_rate }}%</span>
                        @empty
                            {{ __('messages.common.n/a') }}
                        @endforelse
                    </td>
                    <td class="text-right"><i
                                class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i> {{ number_format($item->total, 2) }}
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="invoice-footer d-flex w-100 justify-content-end">
            <table class="table float-right col-sm-6 text-right">
                <tr>
                    <td class="font-weight-bold">{{ __('messages.invoice.sub_total').':' }}</td>
                    <td class="amountData"><i
                                class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i> {{ number_format($invoice->sub_total, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">{{ __('messages.invoice.discount').':' }}</td>
                    <td>{{ formatNumber($invoice->discount) }}{{ isset($invoice->discount_symbol) && $invoice->discount_symbol == 1 ? '%' : '' }}
                    </td>
                </tr>
                @foreach($invoice->salesTaxes as $commonTax)
                    <tr>
                        <td class="font-weight-bold">{{ __('messages.item.tax') }} {{ $commonTax->tax }}<i
                                    class="fas fa-percentage"></i></td>
                        <td>
                            <i class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i> {{ number_format($commonTax->amount, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="font-weight-bold">{{ __('messages.invoice.adjustment').':' }}</td>
                    <td>
                        <i class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i> {{ number_format($invoice->adjustment, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">{{ __('messages.invoice.total').':' }}</td>
                    <td class="amountData"><i
                                class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i> {{ number_format($invoice->total_amount, 2) }}
                    </td>
                </tr>

            </table>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    {{ Form::label('client_note', __('messages.invoice.client_note').':') }}
                    <br>{!! !empty($invoice->client_note) ? html_entity_decode($invoice->client_note) :  __('messages.common.n/a')  !!}
                </div>
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    {{ Form::label('terms_conditions', __('messages.invoice.terms_conditions').':') }}
                    <br>{!! !empty($invoice->term_conditions) ? html_entity_decode($invoice->term_conditions) :  __('messages.common.n/a')  !!}
                </div>
            </div>
        </div>
    </div>
@endsection

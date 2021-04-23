<ul class="nav nav-pills" id="creditNoteTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="creditNoteDetails-tab" data-toggle="tab" href="#creditNoteDetails" role="tab"
           aria-controls="home" aria-selected="true">{{ __('messages.credit_note.credit_note_details') }}</a>
    </li>
</ul>
<hr>
<div class="my-3 d-flex justify-content-between">
    <div>
        <a href="#"
           class="btn text-white mx-1 status-{{ \App\Models\CreditNote::PAYMENT_STATUS[$creditNote->payment_status] }}">
            {{ \App\Models\CreditNote::PAYMENT_STATUS[$creditNote->payment_status] }}
        </a>
    </div>
    <div>
        <div class="dropdown d-inline mx-1">
            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                {{ __('messages.invoice.more') }}
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('credit-note.pdf', ['creditNote' => $creditNote->id]) }}" class="dropdown-item">
                    {{ __('messages.common.download_as_pdf') }}
                </a>
                <a href="{{ route('credit-note.view-as-customer',$creditNote->id) }}"
                   class="dropdown-item text-content-wrap" data-toggle="tooltip"
                   data-placement="bottom" title="{{ __('messages.credit_note.view_credit_note_as_customer') }}"
                   data-delay='{"show":"500", "hide":"50"}'>
                    {{ __('messages.credit_note.view_credit_note_as_customer') }}</a>
                @if($creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_DRAFT &&
                    $creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_OPEN &&
                    $creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_VOID &&
                    $creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_CLOSED)
                    <a class="dropdown-item text-content-wrap" href="#" id="markAsDraft"
                       data-status="0" data-toggle="tooltip"
                       data-placement="bottom" title="{{ __('messages.credit_note.mark_as_draft') }}"
                       data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.credit_note.mark_as_draft') }}</a>
                @endif
                @if($creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_OPEN &&
                    $creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_DRAFT)
                    <a class="dropdown-item text-content-wrap" href="#" id="markAsOpen"
                       data-status="1" data-toggle="tooltip"
                       data-placement="bottom" title="{{ __('messages.credit_note.mark_as_open') }}"
                       data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.credit_note.mark_as_open') }}</a>
                @endif
                @if($creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_VOID &&
                    $creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_DRAFT)
                    <a class="dropdown-item text-content-wrap" href="#" id="markAsVoid"
                       data-status="2" data-toggle="tooltip"
                       data-placement="bottom" title="{{ __('messages.credit_note.mark_as_void') }}"
                       data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.credit_note.mark_as_void') }}</a>
                @endif
                @if($creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_CLOSED &&
                    $creditNote->payment_status != \App\Models\CreditNote::PAYMENT_STATUS_DRAFT)
                    <a class="dropdown-item text-content-wrap" href="#" id="markAsClosed"
                       data-status="3" data-toggle="tooltip"
                       data-placement="bottom" title="{{ __('messages.credit_note.mark_as_closed') }}"
                       data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.credit_note.mark_as_closed') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
<hr>
<div class="tab-content" id="myTabContent2">
    <div class="tab-pane fade show active" id="creditNoteDetails" role="tabpanel"
         aria-labelledby="creditNoteDetails-tab">
        <div class="row">
            <div class="form-group col-md-4 col-12">
                {{ Form::label('title', __('messages.credit_note.title').':') }}
                <p>{{ html_entity_decode($creditNote->title) }}</p>
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('credit_note_number', __('messages.credit_note.credit_note_number').':') }}
                <p>{{ $creditNote->credit_note_number }}</p>
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('customer', __('messages.invoice.customer').':') }}
                <p><a href="{{ url('admin/customers/'.$creditNote->customer->id) }}"
                      class="anchor-underline">{{ html_entity_decode($creditNote->customer->company_name) }}</a></p>
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('invoice_date', __('messages.credit_note.credit_note_date').':') }}
                <p>{{ Carbon\Carbon::parse($creditNote->credit_note_date)->format('jS M, Y H:i A') }}</p>
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('currency', __('messages.invoice.currency').':') }}
                <p>{{ isset($creditNote->currency) ? $creditNote->getCurrencyText($creditNote->currency) : __('messages.common.n/a') }}</p>
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('discount_type', __('messages.invoice.discount_type').':') }}
                <p>{{ isset($creditNote->discount_type) ? $creditNote->getDiscountTypeText($creditNote->discount_type) : __('messages.common.n/a') }}</p>
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('reference', __('messages.credit_note.reference').':') }}
                <p>{{ !empty($creditNote->reference) ? html_entity_decode($creditNote->reference) : __('messages.common.n/a') }}</p>
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('created_at', __('messages.common.created_on').':') }}
                <p><span data-toggle="tooltip" data-placement="right"
                         title="{{ date('jS M, Y', strtotime($creditNote->created_at)) }}">{{ $creditNote->created_at->diffForHumans() }}</span>
                </p>
            </div>
            <div class="form-group col-md-4 col-12">
                {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
                <p><span data-toggle="tooltip" data-placement="right"
                         title="{{ date('jS M, Y', strtotime($creditNote->updated_at)) }}">{{ $creditNote->updated_at->diffForHumans() }}</span>
                </p>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('admin_text', __('messages.invoice.admin_note').':') }}
                        <br>{!! !empty($creditNote->admin_text) ? html_entity_decode($creditNote->admin_text) :  __('messages.common.n/a')  !!}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    @foreach($creditNote->creditNoteAddresses as $address)
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
                    @if($creditNote->unit == 1)
                        <th class="text-right">{{ __('messages.invoice.qty') }}</th>
                    @elseif($creditNote->unit == 2)
                        <th class="text-right">{{ __('messages.invoice.hours') }}</th>
                    @else
                        <th class="text-right">{{ __('messages.invoice.qty/hours') }}</th>
                    @endif
                    <th class="text-right itemRate">{{ __('messages.item.rate') }}(<i
                                class="{{ getCurrencyClassFromIndex($creditNote->currency) }}"></i>)
                    </th>
                    <th class="text-right itemTax">{{ __('messages.invoice.taxes') }}(<i class="fas fa-percentage"></i>)
                    </th>
                    <th class="text-right itemTotal">{{ __('messages.invoice.total') }}(<i
                                class="{{ getCurrencyClassFromIndex($creditNote->currency) }}"></i>)
                    </th>
                </tr>
                </thead>
                @foreach($creditNote->salesItems as $item)
                    <tr>
                        <td>{{ html_entity_decode($item->item) }}</td>
                        <td class="table-data">{!!  !empty($item->description) ? $item->description : __('messages.common.n/a') !!}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right"><i
                                    class="{{ getCurrencyClassFromIndex($creditNote->currency) }}"></i> {{ formatNumber($item->rate) }}
                        </td>
                        <td class="text-right show-taxes-list">
                            @forelse($item->taxes as $tax)
                                <span class="badge badge-light">{{ $tax->tax_rate }}%</span>
                            @empty
                                {{ __('messages.common.n/a') }}
                            @endforelse
                        </td>
                        <td class="text-right"><i
                                    class="{{ getCurrencyClassFromIndex($creditNote->currency) }}"></i> {{ number_format($item->total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="items-container-footer d-flex w-100 justify-content-end">
                <table class="table float-right col-4 text-right">
                    <tr>
                        <td class="font-weight-bold">{{ __('messages.invoice.sub_total').':' }}</td>
                        <td class="amountData"><i
                                    class="{{ getCurrencyClassFromIndex($creditNote->currency) }}"></i> {{ number_format($creditNote->sub_total, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">{{ __('messages.invoice.discount').':' }}</td>
                        <td>{{ formatNumber($creditNote->discount) }}{{ isset($creditNote->discount_symbol) && $creditNote->discount_symbol == 1 ? '%' : '' }}</td>
                    </tr>
                    @foreach($creditNote->salesTaxes as $commonTax)
                        <tr>
                            <td class="font-weight-bold">{{ __('messages.item.tax') }} {{ $commonTax->tax }}<i
                                        class="fas fa-percentage"></i></td>
                            <td class="itemRate"><i
                                        class="{{ getCurrencyClassFromIndex($creditNote->currency) }}"></i> {{ number_format($commonTax->amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="font-weight-bold">{{ __('messages.invoice.adjustment').':' }}</td>
                        <td class="itemRate"><i
                                    class="{{ getCurrencyClassFromIndex($creditNote->currency) }}"></i> {{ number_format($creditNote->adjustment, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">{{ __('messages.invoice.total').':' }}</td>
                        <td class="amountData"><i
                                    class="{{ getCurrencyClassFromIndex($creditNote->currency) }}"></i> {{ number_format($creditNote->total_amount, 2) }}
                        </td>
                    </tr>

                </table>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        {{ Form::label('client_note', __('messages.invoice.client_note').':') }}
                        <br>{!! !empty($creditNote->client_note) ? html_entity_decode($creditNote->client_note) :  __('messages.common.n/a')  !!}
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        {{ Form::label('terms_conditions', __('messages.invoice.terms_conditions').':') }}
                        <br>{!! !empty($creditNote->term_conditions) ? html_entity_decode($creditNote->term_conditions) :  __('messages.common.n/a')  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

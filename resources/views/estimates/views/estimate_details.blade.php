@extends('estimates.show')
@section('section')
    <hr>
    <div class="my-3 d-flex justify-content-between">
        <div>
            <a href="#"
               class="btn text-white mx-1 status-{{ \App\Models\Estimate::STATUS[$estimate->status] }}">
                {{ \App\Models\Estimate::STATUS[$estimate->status] }}
            </a>
        </div>
        <div>
            <div class="dropdown d-inline mx-1">
                <button class="btn btn-warning dropdown-toggle mx-1" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    {{ __('messages.estimate.more') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('estimate.pdf', ['estimate' => $estimate->id]) }}" class="dropdown-item">
                        {{ __('messages.common.download_as_pdf') }}
                    </a>
                    <a href="{{ route('estimate.view-as-customer',$estimate->id) }}"
                       class="dropdown-item text-content-wrap"
                       data-toggle="tooltip"
                       data-placement="bottom" title="{{ __('messages.estimate.view_estimate_as_customer') }}"
                       data-delay='{"show":"500", "hide":"50"}'>
                        {{ __('messages.estimate.view_estimate_as_customer') }}</a>
                    @if($estimate->status != \App\Models\Estimate::STATUS_DRAFT &&
                        $estimate->status != \App\Models\Estimate::STATUS_SEND &&
                        $estimate->status != \App\Models\Estimate::STATUS_EXPIRED &&
                        $estimate->status != \App\Models\Estimate::STATUS_DECLINED &&
                        $estimate->status != \App\Models\Estimate::STATUS_ACCEPTED)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsDraft"
                           data-status="0" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.estimate.mark_as_draft') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.estimate.mark_as_draft') }}</a>
                    @endif
                    @if($estimate->status != \App\Models\Estimate::STATUS_SEND && 
                        $estimate->status != \App\Models\Estimate::STATUS_DRAFT)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsSend"
                           data-status="1" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.estimate.mark_as_send') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.estimate.mark_as_send') }}</a>
                    @endif
                    @if($estimate->status != \App\Models\Estimate::STATUS_EXPIRED && 
                        $estimate->status != \App\Models\Estimate::STATUS_DRAFT)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsExpired"
                           data-status="2" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.estimate.mark_as_expired') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.estimate.mark_as_expired') }}</a>
                    @endif
                    @if($estimate->status != \App\Models\Estimate::STATUS_DECLINED && 
                        $estimate->status != \App\Models\Estimate::STATUS_DRAFT)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsDeclined"
                           data-status="3" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.estimate.mark_as_declined') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.estimate.mark_as_declined') }}</a>
                    @endif
                    @if($estimate->status != \App\Models\Estimate::STATUS_ACCEPTED && 
                        $estimate->status != \App\Models\Estimate::STATUS_DRAFT)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsAccepted"
                           data-status="4" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.estimate.mark_as_accepted') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.estimate.mark_as_accepted') }}</a>
                    @endif
                </div>
            </div>
            <div class="dropdown d-inline mx-1">
                <button class="btn btn-primary dropdown-toggle mx-1" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">{{ __('messages.estimate.convert_estimate') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item" id="convertToInvoice">{{ __('messages.invoice.invoice') }}</a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-4 col-12">
            {{ Form::label('title', __('messages.estimate.title').':') }}
            <p>{{ html_entity_decode($estimate->title) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('customer', __('messages.invoice.customer').':') }}
            <p><a href="{{ url('admin/customers/'.$estimate->customer->id) }}"
                  class="anchor-underline">{{ html_entity_decode($estimate->customer->company_name) }}</a></p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('estimate_number', __('messages.estimate.estimate_number').':') }}
            <p>{{ $estimate->estimate_number }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('tags', __('messages.tags').':') }}
            <p>
                @forelse($estimate->tags as $tag)
                    <span class="badge border border-secondary">{{ html_entity_decode($tag->name) }} </span>
                @empty
                    {{  __('messages.common.n/a')  }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('estimate_date', __('messages.estimate.estimate_date').':') }}
            <p>{{ Carbon\Carbon::parse($estimate->estimate_date)->format('jS M, Y H:i A') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('expiry_date', __('messages.estimate.expiry_date').':') }}
            <p>{{ isset($estimate->estimate_expiry_date) ? Carbon\Carbon::parse($estimate->estimate_expiry_date)->format('jS M, Y H:i A') : __('messages.common.n/a')}}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('sales_agent_id', __('messages.invoice.sale_agent').':') }}
            <p>
                @if(!empty($estimate->sales_agent_id))
                    <a href="{{ url('admin/members/'.$estimate->sales_agent_id) }}" class="anchor-underline">
                        {{ html_entity_decode($estimate->user->full_name) }}
                    </a>
                @else
                    {{ __('messages.common.n/a') }}
                @endif
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('currency', __('messages.invoice.currency').':') }}
            <p>{{ isset($estimate->currency) ? $estimate->getCurrencyText($estimate->currency) : __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('discount_type', __('messages.invoice.discount_type').':') }}
            <p>{{ isset($estimate->discount_type) ? $estimate->getDiscountTypeText($estimate->discount_type) : __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('reference', __('messages.credit_note.reference').':') }}
            <p>{{ !empty($estimate->reference) ? html_entity_decode($estimate->reference) : __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($estimate->created_at)) }}">{{ $estimate->created_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($estimate->updated_at)) }}">{{ $estimate->updated_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('admin_note', __('messages.invoice.admin_note').':') }}
            <br>{!!  !empty($estimate->admin_note) ? html_entity_decode($estimate->admin_note) :  __('messages.common.n/a')   !!}
        </div>
        <div class="col-12">
            <div class="row">
                @foreach($estimate->estimateAddresses as $address)
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
                <th>{{ __('messages.estimate.item') }}</th>
                <th>{{ __('messages.common.description') }}</th>
                @if($estimate->unit == 1)
                    <th class="text-right">{{ __('messages.invoice.qty') }}</th>
                @elseif($estimate->unit == 2)
                    <th class="text-right">{{ __('messages.invoice.hours') }}</th>
                @else
                    <th class="text-right">{{ __('messages.invoice.qty/hours') }}</th>
                @endif
                <th class="text-right itemRate">{{ __('messages.estimate.rate') }}(<i
                            class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i>)
                </th>
                <th class="text-right itemTax">{{ __('messages.estimate.taxes') }}(<i class="fas fa-percentage"></i>)
                </th>
                <th class="text-right itemTotal">{{ __('messages.estimate.total') }}(<i
                            class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i>)
                </th>
            </tr>
            </thead>
            @foreach($estimate->salesItems as $item)
                <tr>
                    <td>{{ html_entity_decode($item->item) }}</td>
                    <td class="table-data">{!! !empty($item->description) ? $item->description : __('messages.common.n/a')!!}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right"><i
                                class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i> {{ formatNumber($item->rate) }}
                    </td>
                    <td class="text-right show-taxes-list">
                        @forelse($item->taxes as $tax)
                            <span class="badge badge-light">{{ $tax->tax_rate }}%</span>
                        @empty
                            {{  __('messages.common.n/a')  }}
                        @endforelse
                    </td>
                    <td class="text-right"><i
                                class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i> {{ number_format($item->total, 2) }}
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="items-container-footer d-flex w-100 justify-content-end">
            <table class="table float-right col-4 text-right">
                <tr>
                    <td class="font-weight-bold">{{ __('messages.estimate.sub_total').':' }}</td>
                    <td class="amountData"><i
                                class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i> {{ number_format($estimate->sub_total, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">{{ __('messages.estimate.discount').':' }}</td>
                    <td>{{ formatNumber($estimate->discount) }}{{ isset($estimate->discount_symbol) && $estimate->discount_symbol == 1 ? '%' : '' }}</td>
                </tr>
                @foreach($estimate->salesTaxes as $commonTax)
                    <tr>
                        <td class="font-weight-bold">{{ __('messages.item.tax') }} {{ $commonTax->tax }}<i
                                    class="fas fa-percentage"></i></td>
                        <td class="itemRate"><i
                                    class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i> {{ number_format($commonTax->amount, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="font-weight-bold">{{ __('messages.estimate.adjustment').':' }}</td>
                    <td class="itemRate"><i
                                class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i> {{ number_format($estimate->adjustment, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">{{ __('messages.estimate.total').':' }}</td>
                    <td class="amountData"><i
                                class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i> {{ number_format($estimate->total_amount, 2) }}
                    </td>
                </tr>

            </table>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    {{ Form::label('client_note', __('messages.estimate.client_note').':') }}
                    <br>{!! !empty($estimate->client_note) ? html_entity_decode($estimate->client_note) :  __('messages.common.n/a')  !!}
                </div>
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    {{ Form::label('terms_conditions', __('messages.estimate.terms_conditions').':') }}
                    <br>{!! !empty($estimate->term_conditions) ? html_entity_decode($estimate->term_conditions) :  __('messages.common.n/a')  !!}
                </div>
            </div>
        </div>
    </div>
@endsection

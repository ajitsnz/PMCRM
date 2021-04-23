@extends('proposals.show')
@section('section')
    <hr>
    <div class="my-3 d-flex justify-content-between">
        <div>
            <a href="#"
               class="btn text-white mx-1 status-{{ \App\Models\Proposal::STATUS[$proposal->status] }}">
                {{ \App\Models\Proposal::STATUS[$proposal->status] }}
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
                    <a href="{{ route('proposal.pdf', ['proposal' => $proposal->id]) }}" class="dropdown-item">
                        {{ __('messages.common.download_as_pdf') }}
                    </a>
                    <a href="{{ route('proposal.view-as-customer',$proposal->id) }}"
                       class="dropdown-item text-content-wrap"
                       data-toggle="tooltip"
                       data-placement="bottom" title="{{ __('messages.proposal.view_proposal_as_customer') }}"
                       data-delay='{"show":"500", "hide":"50"}'>
                        {{ __('messages.proposal.view_proposal_as_customer') }}</a>
                    @if($proposal->status != \App\Models\Proposal::STATUS_DRAFT &&
                        $proposal->status != \App\Models\Proposal::STATUS_REVISED &&
                        $proposal->status != \App\Models\Proposal::STATUS_OPEN &&
                        $proposal->status != \App\Models\Proposal::STATUS_DECLINED &&
                        $proposal->status != \App\Models\Proposal::STATUS_ACCEPTED)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsDraft"
                           data-status="1" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.proposal.mark_as_draft') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.proposal.mark_as_draft') }}</a>
                    @endif
                    @if($proposal->status != \App\Models\Proposal::STATUS_OPEN && 
                        $proposal->status != \App\Models\Proposal::STATUS_DRAFT)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsOpen"
                           data-status="2" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.proposal.mark_as_open') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.proposal.mark_as_open') }}</a>
                    @endif
                    @if($proposal->status != \App\Models\Proposal::STATUS_REVISED &&
                        $proposal->status != \App\Models\Proposal::STATUS_DRAFT)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsRevised"
                           data-status="3" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.proposal.mark_as_revised') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.proposal.mark_as_revised') }}</a>
                    @endif
                    @if($proposal->status != \App\Models\Proposal::STATUS_DECLINED &&
                        $proposal->status != \App\Models\Proposal::STATUS_DRAFT)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsDeclined"
                           data-status="4" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.proposal.mark_as_declined') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.proposal.mark_as_declined') }}</a>
                    @endif
                    @if($proposal->status != \App\Models\Proposal::STATUS_ACCEPTED &&
                        $proposal->status != \App\Models\Proposal::STATUS_DRAFT)
                        <a class="dropdown-item text-content-wrap" href="#" id="markAsAccepted"
                           data-status="5" data-toggle="tooltip"
                           data-placement="bottom" title="{{ __('messages.proposal.mark_as_accepted') }}"
                           data-delay='{"show":"500", "hide":"50"}'>{{ __('messages.proposal.mark_as_accepted') }}</a>
                    @endif
                </div>
            </div>
            <div class="dropdown d-inline mx-1">
                <button class="btn btn-primary dropdown-toggle mx-1" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">{{ __('messages.proposal.convert_proposal') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item" id="convertToInvoice">{{ __('messages.invoice.invoice') }}</a>
                    <a href="#" class="dropdown-item" id="convertToEstimate">{{ __('messages.estimate.estimate') }}</a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-4 col-12">
            {{ Form::label('title', __('messages.proposal.title').':') }}
            <p>{{ html_entity_decode($proposal->title) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('proposal_number',__('messages.proposal.proposal_number').':') }}
            <p>{{ $proposal->proposal_number }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('related', __('messages.proposal.related').':') }}
            <p>{{ !empty($proposal->related_to) ? $proposal->getRelatedText($proposal->related_to) : __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            @if($proposal->owner_type === \App\Models\Lead::class)
                {{ Form::label('owner_id',__('messages.proposal.lead').':') }}
                <p><a href="{{ url('admin/leads/'.$proposal->owner_id) }}"
                      class="anchor-underline">{{ html_entity_decode($proposal->lead->name) }}</a></p>
            @else
                {{ Form::label('owner_id',__('messages.invoice.customer').':') }}
                <p><a href="{{ url('admin/customers/'.$proposal->owner_id) }}"
                      class="anchor-underline">{{ html_entity_decode($proposal->customer->company_name) }}</a></p>
            @endif
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('date', __('messages.proposal.date').':') }}
            <p>{{ Carbon\Carbon::parse($proposal->date)->format('jS M, Y H:i A') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('open_till', __('messages.proposal.open_till').':') }}
            <p>{{ !empty($proposal->open_till) ? Carbon\Carbon::parse($proposal->open_till)->format('jS M, Y H:i A') : __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('currency', __('messages.invoice.currency').':') }}
            <p>{{ $proposal->getCurrencyText($proposal->currency) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('discount_type', __('messages.invoice.discount_type').':') }}
            <p>{{ !empty($proposal->discount_type) ? $proposal->getDiscountTypeText($proposal->discount_type) : __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('assigned', __('messages.proposal.member').':') }}
            <p>
                @if(!empty($proposal->assigned_user_id))
                    <a href="{{ url('admin/members',$proposal->assigned_user_id) }}"
                       class="anchor-underline">{{ html_entity_decode($proposal->user->full_name) }}</a>
                @else
                    {{ __('messages.common.n/a') }}
                @endif
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('phone', __('messages.member.phone').':') }}
            <p>{{ !empty($proposal->phone) ? $proposal->phone :  __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('tags', __('messages.tags').':') }}
            <p>
                @forelse($proposal->tags as $tag)
                    <span class="badge border border-secondary">{{ html_entity_decode($tag->name) }}</span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($proposal->created_at)) }}">{{ $proposal->created_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($proposal->updated_at)) }}">{{ $proposal->updated_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="col-12">
            <div class="row">
                @foreach($proposal->proposalAddresses as $address)
                    @if($address->type == 1)
                        <div class="form-group col-md-4 col-12">
                            {{ Form::label('bill_to', __('messages.invoice.bill_to').':') }}
                            <div>{!! nl2br(e($address->street)) !!},</div>
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
                @if($proposal->unit == 1)
                    <th class="text-right">{{ __('messages.invoice.qty') }}</th>
                @elseif($proposal->unit == 2)
                    <th class="text-right">{{ __('messages.invoice.hours') }}</th>
                @else
                    <th class="text-right">{{ __('messages.invoice.qty/hours') }}</th>
                @endif
                <th class="text-right itemRate">{{ __('messages.item.rate') }}(<i
                            class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i>)
                </th>
                <th class="text-right itemTax">{{ __('messages.invoice.taxes') }}(<i class="fas fa-percentage"></i>)
                </th>
                <th class="text-right itemTotal">{{ __('messages.invoice.total') }}(<i
                            class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i>)
                </th>
            </tr>
            </thead>
            @foreach($proposal->salesItems as $item)
                <tr>
                    <td>{{ html_entity_decode($item->item) }}</td>
                    <td class="table-data">{!! !empty($item->description) ? $item->description : __('messages.common.n/a')!!}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right"><i class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i>
                        {{ number_format($item->rate) }}</td>
                    <td class="text-right show-taxes-list">
                        @forelse($item->taxes as $tax)
                            <span class="badge badge-light">{{ $tax->tax_rate }}%</span>
                        @empty
                            {{ __('messages.common.n/a') }}
                        @endforelse
                    </td>
                    <td class="text-right"><i
                                class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i> {{ number_format($item->total, 2) }}
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="proposal-footer d-flex w-100 justify-content-end">
            <table class="table float-right col-4 text-right">
                <tr>
                    <td class="font-weight-bold">{{ __('messages.invoice.sub_total').':' }}</td>
                    <td class="amountData"><i
                                class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i> {{ number_format($proposal->sub_total, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">{{ __('messages.invoice.discount').':' }}</td>
                    <td>{{ formatNumber($proposal->discount) }}{{ isset($proposal->discount_symbol) && $proposal->discount_symbol == 1 ? '%' : '' }}</td>
                </tr>
                @foreach($proposal->salesTaxes as $commonTax)
                    <tr>
                        <td class="font-weight-bold">{{ __('messages.item.tax') }} {{ $commonTax->tax }}<i
                                    class="fas fa-percentage"></i></td>
                        <td class="itemRate"><i
                                    class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i> {{ number_format($commonTax->amount, 2) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="font-weight-bold">{{ __('messages.invoice.adjustment').':' }}</td>
                    <td class="itemRate"><i
                                class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i> {{ number_format($proposal->adjustment, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">{{ __('messages.invoice.total').':' }}</td>
                    <td class="amountData"><i
                                class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i> {{ number_format($proposal->total_amount, 2) }}
                    </td>
                </tr>

            </table>
        </div>
    </div>
@endsection

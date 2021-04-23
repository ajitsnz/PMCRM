<div>
    <div class="row">
        <div class="mt-0 mb-3 col-12 d-flex justify-content-end search-display-block">
            @if(!empty($customer))
                <div class="mt-2">
                    {{ Form::select('payment_status',$invoiceStatus,null,['id' => 'invoicePaymentStatus','class' => 'form-control','placeholder' => 'Select Status']) }}
                </div>
            @endif
            <div class="p-2">
                <input wire:model.debounce.100ms="search" type="search" class="form-control" placeholder="Search"
                       id="search">
            </div>
        </div>
        <div class="col-md-12">
            <div wire:loading id="live-wire-screen-lock">
                <div class="live-wire-infy-loader">
                    @include('loader')
                </div>
            </div>
        </div>
        @if(empty($customer))
            <div class="col-md-12">
                <div class="row justify-content-md-center text-center mb-4">
                    <div class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="ticket-statistics mx-auto bg-danger">
                                <p>{{ $statusCount->cancelled }}</p>
                            </div>
                            <h5 class="my-0 mt-1">{{ __('messages.invoice.cancelled') }}</h5>
                        </div>
                        <div class="item">
                            <div class="ticket-statistics mx-auto bg-warning">
                                <p>{{ $statusCount->drafted }}</p>
                            </div>
                            <h5 class="my-0 mt-1">{{ __('messages.invoice.drafted') }}</h5>
                        </div>
                        <div class="item">
                            <div class="ticket-statistics mx-auto bg-primary">
                                <p>{{ $statusCount->unpaid }}</p>
                            </div>
                            <h5 class="my-0 mt-1">{{ __('messages.invoice.unpaid') }}</h5>
                        </div>
                        <div class="item">
                            <div class="ticket-statistics mx-auto bg-info">
                                <p>{{ $statusCount->partially_paid }}</p>
                            </div>
                            <h5 class="my-0 mt-1">{{ __('messages.invoice.partially_paid') }}</h5>
                        </div>
                        <div class="item">
                            <div class="ticket-statistics mx-auto bg-success">
                                <p>{{ $statusCount->paid }}</p>
                            </div>
                            <h5 class="my-0 mt-1">{{ __('messages.invoice.paid') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @forelse($invoices as $invoice)
            <div class="col-12 col-md-4 col-lg-4 col-xl-3">
                <div class="livewire-card card card-{{ \App\Models\Invoice::STATUS_COLOR[$invoice->payment_status] }} shadow mb-5 rounded hover-card card-height">
                    <div class="card-header d-flex justify-content-between align-items-center itemCon p-3 invoice-card-height">
                        <div class="d-flex">
                            <a href="{{ url('admin/invoices', $invoice->id) }}"
                               class="d-flex flex-wrap text-decoration-none">
                                <h4 class="text-primary invoice-clients invoice_title pl-2">
                                    {{ Str::limit(html_entity_decode($invoice->title), 15, '...') }}
                                </h4>
                                (<small class="text-primary">{{ $invoice->invoice_number }}</small>)
                            </a>
                        </div>
                        <div class="invoice-action-btn d-none">
                            @if($invoice->payment_status == \App\Models\Invoice::STATUS_DRAFT || $invoice->payment_status == \App\Models\Invoice::STATUS_UNPAID)
                                <a title="Edit" href="{{ route('invoices.edit',$invoice->id) }}"><i
                                            class="fa fa-edit text-warning mr-1"></i></a>
                            @endif
                            @if($invoice->payment_status != \App\Models\Invoice::STATUS_PAID && $invoice->payment_status != \App\Models\Invoice::STATUS_PARTIALLY_PAID)
                                <a title="Delete" class="text-danger action-btn delete-btn tickets-delete"
                                   data-id="{{ $invoice->id }}" href="#">
                                    <i class="fa fa-trash"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body d-flex justify-content-between pt-1 px-3">
                        <div class="d-table w-100">
                            <div>
                                <i class="fas fa-street-view"></i><span
                                        class="text-decoration-none"> {{ html_entity_decode($invoice->customer->company_name) }}</span>
                            </div>
                            <span class="d-table-row w-100">
                            <big class="d-table-cell w-100">
                                <i class="{{ getCurrencyClassFromIndex($invoice->currency) }}"></i> {{ number_format( $invoice->total_amount, 2) }}
                            </big>
                            <span class="badge text-uppercase status-{{ \Illuminate\Support\Str::slug(\App\Models\Invoice::PAYMENT_STATUS[($invoice->payment_status)]) }}">
                                {{  App\Models\Invoice::PAYMENT_STATUS[$invoice->payment_status] }}
                            </span>
                            </span>
                            @if(!empty($invoice->due_date))
                                <span class="d-table-row w-100 {{ now() > Carbon\Carbon::parse($invoice->due_date)  ? 'text-danger' : '' }}">
                                {{Carbon\Carbon::parse($invoice->due_date)->format('jS M, Y')}}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="mt-0 mb-5 col-12 d-flex justify-content-center  mb-5 rounded">
                <div class="p-2">
                    @if(empty($search))
                        <p class="text-dark">{{ __('messages.invoice.no_invoice_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.invoice.invoice_not_found') }}</p>
                    @endif
                </div>
            </div>
        @endforelse

        <div class="mt-0 mb-5 col-12">
            <div class="row paginatorRow">
                <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }}
                    <span class="font-weight-bold ml-1 mr-1">{{ $invoices->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $invoices->lastItem() }}</span> {{ __('messages.common.of') }} 
                    <span class="font-weight-bold ml-1">{{ $invoices->total() }}</span>
                </span>
                </div>
                <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

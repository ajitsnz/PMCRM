<div class="row">
    <div class="mt-0 mb-3 col-12 d-flex justify-content-end">
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
    @forelse($estimates as $estimate)
        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
            <div class="estimate-card card card-{{ \App\Models\Estimate::STATUS_COLOR[$estimate->status] }} shadow mb-5 rounded hover-card estimate-card-border">
                <div class="card-header d-flex justify-content-between align-items-center itemCon p-3 invoice-card-height">
                    <div class="d-flex">
                        <a href="{{ route('clients.estimates.view-as-customer', $estimate->id) }}"
                           class="d-flex flex-wrap text-decoration-none">
                            <h4 class="invoice-clients invoice_title"> {{ Str::limit(html_entity_decode($estimate->title), 25, '...') }}</h4>
                            (<small>{{ $estimate->estimate_number }}</small>)
                        </a>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-between pt-1 px-3">
                    <div class="d-table w-100">
                        <div>
                            <span class="text-decoration-none">{{ html_entity_decode($estimate->customer->company_name) }}</span>
                        </div>
                        <span class="d-table-row w-100">
                            <big class="d-table-cell w-100">
                                <i class="{{ getCurrencyClassFromIndex($estimate->currency) }}"></i> {{ number_format( $estimate->total_amount, 2) }}
                            </big>
                            <span class="badge-{{ App\Models\Estimate::STATUS_COLOR[$estimate->status] }} badge text-uppercase">{{  App\Models\Estimate::STATUS[$estimate->status] }}</span>
                        </span>
                        @if(!empty($estimate->estimate_expiry_date))
                            <span class="d-table-row w-100 {{ now() > Carbon\Carbon::parse($estimate->estimate_expiry_date)  ? 'text-danger' : '' }}">
                                {{Carbon\Carbon::parse($estimate->estimate_expiry_date)->format('jS M, Y')}}
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
                    <p class="text-dark">{{ __('messages.estimate.no_estimate_available').'.' }}</p>
                @else
                    <p class="text-dark">{{ __('messages.estimate.estimate_not_found').'.' }}</p>
                @endif
            </div>
        </div>
    @endforelse

    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }} 
                    <span class="font-weight-bold ml-1 mr-1">{{ $estimates->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $estimates->lastItem() }}</span> of 
                    <span class="font-weight-bold ml-1">{{ $estimates->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $estimates->links() }}
            </div>
        </div>
    </div>
</div>

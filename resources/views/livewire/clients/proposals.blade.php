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
    @forelse($proposals as $proposal)
        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
            <div class="livewire-card card card-{{ \App\Models\Proposal::STATUS_COLOR[$proposal->status] }} shadow mb-5 rounded hover-card client-in-card">
                <div class="card-header d-flex justify-content-between align-items-center itemCon p-3 invoice-card-height">
                    <div class="d-flex">
                        <a href="{{ route('clients.proposals.view-as-customer', $proposal->id) }}"
                           class="d-flex flex-wrap text-decoration-none">
                            <h4 class="invoice-clients invoice_title">
                                {{ Str::limit(html_entity_decode($proposal->title), 25, '...') }}
                            </h4>
                            (<small>{{ $proposal->proposal_number }}</small>)
                        </a>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-between pt-1 px-3">
                    <div class="d-table w-100">
                        @if($proposal->owner_type === \App\Models\Customer::class)
                            <div>
                                <span data-toggle="tooltip" title="Customer"> {{ !empty($proposal->customer) ? html_entity_decode($proposal->customer->company_name) : '' }}
                                </span>
                            </div>
                        @endif
                        <span class="d-table-row w-100">
                            <span class="d-table-cell w-100">
                                <i class="{{ getCurrencyClassFromIndex($proposal->currency) }}"></i> {{ number_format( $proposal->total_amount, 2) }}
                            </span>
                            <span class="badge-{{App\Models\Proposal::STATUS_COLOR[$proposal->status]}} badge text-uppercase">{{  App\Models\Proposal::STATUS[$proposal->status] }}</span>
                        </span>
                        @if(!empty($proposal->open_till))
                            <span class="d-table-row w-100 {{ now() > Carbon\Carbon::parse($proposal->open_till)  ? 'text-danger' : '' }}">
                                {{Carbon\Carbon::parse($proposal->open_till)->format('jS M, Y')}}
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
                    <p class="text-dark">{{ __('messages.proposal.no_proposal_available') }}</p>
                @else
                    <p class="text-dark">{{ __('messages.proposal.no_proposal_found') }}</p>
                @endif
            </div>
        </div>
    @endforelse

    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }} 
                    <span class="font-weight-bold ml-1 mr-1">{{ $proposals->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $proposals->lastItem() }}</span> {{ __('messages.common.of') }} 
                    <span class="font-weight-bold ml-1">{{ $proposals->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $proposals->links() }}
            </div>
        </div>
    </div>
</div>

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

    <?php
    $border = 'border-left: 2px solid ';
    ?>
    @forelse($contracts as $contract)
        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
            <div class="hover-effect-category position-relative mb-4 category-card-hover-border"
                 style="{{ $border }}{{ $loop->odd ? '#6777ef' : '#191d21'}}">
                <div class="category-listing-details">
                    <div class="d-flex category-listing-description">
                        <div class="category-data">
                            <h3 class="category-listing-title mb-2">
                                <a href="{{ route('clients.contracts.view-as-customer',$contract->id) }}"
                                   class="text-decoration-none">{{ Str::limit(html_entity_decode($contract->subject), 30, '...') }}</a>
                            </h3>
                            <h3 class="category-listing-title">
                                <span data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title="Customer"><i class="fas fa-street-view fa_fa_20px"></i>
                                &nbsp;{{ html_entity_decode($contract->customer->company_name) }}
                                </span>
                            </h3>
                            <h3 class="category-listing-title">
                                <span data-toggle="tooltip" data-placement="top" title="Contract type"><i
                                            class="fas fa-file-contract fa_fa_20px"></i>
                                &nbsp;{{ html_entity_decode($contract->type->name) }}
                                </span>
                            </h3>
                            @if(!empty($contract->contract_value))
                                <h3 class="category-listing-title">
                                    <span data-toggle="tooltip" title="Contract Value"><i
                                                class="fas fa-rupee-sign fa_fa_20px"></i>
                                    &nbsp;{{ number_format($contract->contract_value, 2) }}
                                    </span>
                                </h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="mt-0 mb-5 col-12 d-flex justify-content-center mb-5 rounded">
            <div class="p-2">
                @if(empty($search))
                    <p class="text-dark">{{ __('messages.contract.no_contract_available').'.' }}</p>
                @else
                    <p class="text-dark">{{ __('messages.contract.contract_not_found').'.' }}</p>
                @endif
            </div>
        </div>
    @endforelse

    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }}  
                    <span class="font-weight-bold ml-1 mr-1">{{ $contracts->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $contracts->lastItem() }}</span> {{ __('messages.common.of') }}
                    <span class="font-weight-bold ml-1">{{ $contracts->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $contracts->links() }}
            </div>
        </div>
    </div>
</div>

<div>
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
    <div class="row">
        @forelse($contracts as $contract)
            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                <div class="livewire-card hover-effect-contract position-relative mb-4 contract-card-hover-border contract-card-height"
                     style="{{ $border }}{{ $loop->odd ? '#6777ef' : '#191d21'}}">
                    <div class="float-right contract-action-btn">
                        <a class="dropdown dropdown-list-toggle">
                            <a href="#" data-toggle="dropdown"
                               class="notification-toggle action-dropdown d-none position-xs-bottom">
                                <i class="fas fa-ellipsis-v action-toggle-mr"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-list-content dropdown-list-icons">
                                    <a href="{{ route('contracts.edit',$contract->id) }}"
                                       class="dropdown-item dropdown-item-desc edit-btn"
                                       data-id="{{ $contract->id }}"><i
                                                class="fas fa-edit mr-2 card-edit-icon"></i> {{ __('messages.common.edit') }}
                                    </a>
                                    <a href="#" class="dropdown-item dropdown-item-desc delete-btn"
                                       data-id="{{ $contract->id }}"><i
                                                class="fas fa-trash mr-2 card-delete-icon"></i>{{ __('messages.common.delete') }}
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="contract-listing-details">
                        <div class="d-flex contract-listing-description">
                            <div class="contract-data">
                                <h3 class="contract-listing-title mb-2">
                                    <a href="{{ url('admin/contracts',$contract->id) }}"
                                       class="text-decoration-none">{{ Str::limit(html_entity_decode($contract->subject), 15, '...') }}</a>
                                </h3>
                                <h3 class="contract-listing-title">
                                    <span data-toggle="tooltip" title="" data-original-title="Customer"><i
                                                class="fas fa-street-view fa_fa_20px"></i>
                                    &nbsp;{{ html_entity_decode($contract->customer->company_name) }}
                                    </span>
                                </h3>
                                <h3 class="contract-listing-title">
                                    <span data-toggle="tooltip" title="" data-original-title="Contract Type"><i
                                                class="fas fa-file-contract fa_fa_20px"></i>  {{ html_entity_decode($contract->type->name) }}
                                    </span>
                                </h3>
                                @if(!empty($contract->contract_value))
                                    <h3 class="contract-listing-title">
                                        <span data-toggle="tooltip" title="" data-original-title="Contract Value"><i
                                                    class="fas fa-rupee-sign fa_fa_20px"></i>  {{ number_format($contract->contract_value, 2) }}
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
    </div>
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

<div>
    <div class="row">
        <div class="col-md-12">
            <div wire:loading id="overlay-screen-lock">
                <div class="live-wire-infy-loader">
                    @include('loader')
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="row mb-3 justify-content-end flex-wrap">
                <div>
                    <div class="selectgroup mr-3">
                        <input wire:model.debounce.100ms="search" type="search" autocomplete="off"
                               id="search" placeholder="{{ __('messages.common.search') }}"
                               class="form-control">
                    </div>
                </div>
            </div>
            @if(count($taxRates) > 0)
                <div class="content">
                    <div class="row position-relative">
                        @foreach($taxRates as $taxRate)
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="hover-effect-tax-rate position-relative mb-4 tax-rate-card-hover-border">
                                    <div class="tax-rate-listing-details">
                                        <div class="d-flex tax-rate-listing-description">
                                            <div class="tax-rate-data">
                                                <h3 class="tax-rate-listing-title mb-1">
                                                    <a href="#"
                                                       class="text-dark text-decoration-none tax-rates-listing-text show-btn"
                                                       data-id="{{ $taxRate->id }}" data-toggle="tooltip"
                                                       title="{{ html_entity_decode($taxRate->name) }}">
                                                        {{ Str::limit(html_entity_decode($taxRate->name), 20, '...') }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tax-rate-margin">
                                        <span><b>{{ __('messages.tax_rate.tax_rate').'(%)' }}</b> : {{ $taxRate->tax_rate }}</span>
                                    </div>
                                    <div class="tax-rate-action-btn mt-2">
                                        <a title="Edit"
                                           class="btn action-btn edit-btn tax-rate-edit"
                                           data-id="{{ $taxRate->id }}"
                                           href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete"
                                           class="btn action-btn delete-btn tax-rate-delete"
                                           data-id="{{ $taxRate->id }}"
                                           href="#">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-0 mb-5 col-12">
                        <div class="row paginatorRow">
                            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                                <span class="d-inline-flex">
                                    {{ __('messages.common.showing') }}
                                    <span class="font-weight-bold ml-1 mr-1">{{ $taxRates->firstItem() }}</span> -
                                    <span class="font-weight-bold ml-1 mr-1">{{ $taxRates->lastItem() }}</span> {{ __('messages.common.of') }}
                                    <span class="font-weight-bold ml-1">{{ $taxRates->total() }}</span>
                                </span>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                @if($taxRates->count() > 0)
                                    {{ $taxRates->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                    @if(empty($search))
                        <p class="text-dark">{{ __('messages.tax_rate.no_tax_rate_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.tax_rate.tax_rate_not_found') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

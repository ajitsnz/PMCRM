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
            @if(count($paymentModes) > 0)
                <div class="content">
                    <div class="row position-relative">
                        @foreach($paymentModes as $paymentMode)
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="hover-effect-payment-mode position-relative mb-4 payment-mode-card-hover-border">
                                    <div class="payment-mode-listing-details">
                                        <div class="d-flex payment-mode-listing-description">
                                            <div class="payment-mode-data">
                                                <h3 class="payment-mode-listing-title mb-1">
                                                    <a href="#"
                                                       class="text-dark text-decoration-none tags-listing-text show-btn"
                                                       data-id="{{ $paymentMode->id }}">
                                                        {{ Str::limit(html_entity_decode($paymentMode->name), 20, '...') }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-mode-status">
                                        <label class="custom-switch pl-0" data-placement="bottom"
                                               title="{{ $paymentMode->active ? __('messages.common.active') : __('messages.common.deactive') }}">
                                            <input type="checkbox" name="active" class="custom-switch-input isActive"
                                                   data-id="{{ $paymentMode->id }}" value="1"
                                                   data-class="active" {{ $paymentMode->active ? 'checked' : '' }}>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="payment-mode-action-btn mt-1">
                                        <a title="Edit"
                                           class="btn action-btn edit-btn payment-mode-edit"
                                           data-id="{{ $paymentMode->id }}"
                                           href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete"
                                           class="btn action-btn delete-btn payment-mode-delete"
                                           data-id="{{ $paymentMode->id }}"
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
                                    <span class="font-weight-bold ml-1 mr-1">{{ $paymentModes->firstItem() }}</span> -
                                    <span class="font-weight-bold ml-1 mr-1">{{ $paymentModes->lastItem() }}</span> {{ __('messages.common.of') }}
                                    <span class="font-weight-bold ml-1">{{ $paymentModes->total() }}</span>
                                </span>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                @if($paymentModes->count() > 0)
                                    {{ $paymentModes->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                    @if(empty($search))
                        <p class="text-dark">{{ __('messages.payment_mode.no_payment_mode_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.payment_mode.payment_mode_not_found') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

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
            @if(count($leadSources) > 0)
                <div class="content">
                    <div class="row position-relative">
                        @foreach($leadSources as $lead)
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="hover-effect-lead-source position-relative mb-4 lead-source-card-hover-border">
                                    <div class="lead-source-listing-details">
                                        <div class="d-flex lead-source-listing-description">
                                            <div class="lead-source-data">
                                                <h3 class="lead-source-listing-title mb-1">
                                                    <a href="#"
                                                       class="text-dark text-decoration-none lead-sources-listing-text show-btn"
                                                       data-toggle="tooltip"
                                                       title="{{ html_entity_decode($lead->name) }}"
                                                       data-id="{{ $lead->id }}">
                                                        {{ Str::limit(html_entity_decode($lead->name), 20, '...') }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center badge badge-success font-weight-bold lead-count"
                                         data-toggle="tooltip" data-placement="top" title=""
                                         data-original-title="Leads">{{ $lead->used_lead_source_count }}</div>
                                    <div class="lead-source-action-btn">
                                        <a title="Edit"
                                           class="btn action-btn edit-btn lead-source-edit"
                                           data-id="{{ $lead->id }}"
                                           href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete"
                                           class="btn action-btn delete-btn lead-source-delete"
                                           data-id="{{ $lead->id }}"
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
                                    <span class="font-weight-bold ml-1 mr-1">{{ $leadSources->firstItem() }}</span> -
                                    <span class="font-weight-bold ml-1 mr-1">{{ $leadSources->lastItem() }}</span> {{ __('messages.common.of') }}
                                    <span class="font-weight-bold ml-1">{{ $leadSources->total() }}</span>
                                </span>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                @if($leadSources->count() > 0)
                                    {{ $leadSources->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                    @if(empty($search))
                        <p class="text-dark">{{ __('messages.lead_source.no_lead_source_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.lead_source.lead_source_not_found') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

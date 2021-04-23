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
            @if(count($ticketPriorities) > 0)
                <div class="content">
                    <div class="row position-relative">
                        @foreach($ticketPriorities as $ticketPriority)
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="hover-effect-ticket-priority position-relative mb-4 ticket-priority-card-hover-border">
                                    <div class="ticket-priority-listing-details">
                                        <div class="d-flex ticket-priority-listing-description">
                                            <div class="ticket-priority-data">
                                                <h3 class="ticket-priority-listing-title mb-1">
                                                    <a href="#"
                                                       class="text-dark text-decoration-none ticket-prioritys-listing-text show-btn"
                                                       data-toggle="tooltip" title="{{ $ticketPriority->name }}">
                                                        {{ Str::limit(html_entity_decode($ticketPriority->name), 20, '...') }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="text-center badge badge-success font-weight-bold lead-count"
                                             data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Tickets">{{ $ticketPriority->tickets_count }}
                                        </div>
                                        <div class="ml-3 mt-2">
                                            <label class="custom-switch pl-0" data-placement="bottom"
                                                   title="{{ $ticketPriority->status ? __('messages.common.active') : __('messages.common.deactive') }}">
                                                <input type="checkbox" name="status" class="custom-switch-input status"
                                                       data-id="{{ $ticketPriority->id }}" value="1"
                                                       data-class="status" {{ $ticketPriority->status ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="ticket-priority-action-btn">
                                        <a title="Edit"
                                           class="btn action-btn edit-btn ticket-priority-edit"
                                           data-id="{{ $ticketPriority->id }}"
                                           href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete"
                                           class="btn action-btn delete-btn ticket-priority-delete"
                                           data-id="{{ $ticketPriority->id }}"
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
                                    <span class="font-weight-bold ml-1 mr-1">{{ $ticketPriorities->firstItem() }}</span> -
                                    <span class="font-weight-bold ml-1 mr-1">{{ $ticketPriorities->lastItem() }}</span> {{ __('messages.common.of') }}
                                    <span class="font-weight-bold ml-1">{{ $ticketPriorities->total() }}</span>
                                </span>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                @if($ticketPriorities->count() > 0)
                                    {{ $ticketPriorities->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                    @if(empty($search))
                        <p class="text-dark">{{ __('messages.ticket_priority.no_ticket_priority_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.ticket_priority.ticket_priority_not_found') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

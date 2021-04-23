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
            @if(count($predefinedReplies) > 0)
                <div class="content">
                    <div class="row position-relative">
                        @foreach($predefinedReplies as $predefinedReply)
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="hover-effect-predefined-reply position-relative mb-4 predefined-reply-card-hover-border">
                                    <div class="predefined-reply-listing-details">
                                        <div class="d-flex predefined-reply-listing-description">
                                            <div class="predefined-reply-data">
                                                <h3 class="predefined-reply-listing-title mb-1">
                                                    <a href="#"
                                                       class="text-dark text-decoration-none tags-listing-text show-btn"
                                                       data-id="{{ $predefinedReply->id }}">
                                                        {{ Str::limit(html_entity_decode($predefinedReply->reply_name), 20, '...') }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="predefined-reply-action-btn">
                                        <a title="Edit"
                                           class="btn action-btn edit-btn predefined-reply-edit"
                                           data-id="{{ $predefinedReply->id }}"
                                           href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete"
                                           class="btn action-btn delete-btn predefined-reply-delete"
                                           data-id="{{ $predefinedReply->id }}"
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
                                    <span class="font-weight-bold ml-1 mr-1">{{ $predefinedReplies->firstItem() }}</span> -
                                    <span class="font-weight-bold ml-1 mr-1">{{ $predefinedReplies->lastItem() }}</span> {{ __('messages.common.of') }}
                                    <span class="font-weight-bold ml-1">{{ $predefinedReplies->total() }}</span>
                                </span>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                @if($predefinedReplies->count() > 0)
                                    {{ $predefinedReplies->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                    @if(empty($search))
                        <p class="text-dark">{{ __('messages.predefined_reply.no_predefined_reply_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.predefined_reply.predefined_reply_not_found') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

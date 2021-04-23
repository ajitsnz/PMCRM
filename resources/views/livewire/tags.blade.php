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
                        <input wire:model.debounce.100ms="searchByTag" type="search" autocomplete="off"
                               id="searchByTag" placeholder="{{ __('messages.common.search') }}"
                               class="form-control">
                    </div>
                </div>
            </div>
            @if(count($tags) > 0)
                <div class="content">
                    <div class="row position-relative">
                        @foreach($tags as $tag)
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="hover-effect-tag position-relative mb-4 tag-card-hover-border">
                                    <div class="tag-listing-details">
                                        <div class="d-flex tag-listing-description">
                                            <div class="tag-data">
                                                <h3 class="tag-listing-title mb-1">
                                                    <a href="#"
                                                       class="text-dark text-decoration-none tags-listing-text show-btn"
                                                       data-id="{{ $tag->id }}">
                                                        {{ Str::limit(html_entity_decode($tag->name), 20, '...') }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tag-action-btn">
                                        <a title="Edit"
                                           class="btn action-btn edit-btn tag-edit"
                                           data-id="{{ $tag->id }}"
                                           href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete"
                                           class="btn action-btn delete-btn tag-delete"
                                           data-id="{{ $tag->id }}"
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
                                    <span class="font-weight-bold ml-1 mr-1">{{ $tags->firstItem() }}</span> -
                                    <span class="font-weight-bold ml-1 mr-1">{{ $tags->lastItem() }}</span> {{ __('messages.common.of') }}
                                    <span class="font-weight-bold ml-1">{{ $tags->total() }}</span>
                                </span>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                @if($tags->count() > 0)
                                    {{ $tags->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                    @if(empty($searchByTag))
                        <p class="text-dark">{{ __('messages.tag.no_tag_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.tag.no_tag_found') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="mt-0 mb-3 col-12 d-flex justify-content-end">
        <div class="p-2">
            <input wire:model.debounce.100ms="search" type="search" class="form-control"
                   placeholder="Search"
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
    $border = 'border-top: 2px solid ';
    ?>
    @forelse($announcements as $announcement)
        <div class="col-12 mb-3">
            <div class="hover-effect-announcement position-relative mb-4 announcement-height"
                 style="{{ $border }}{{ $loop->odd ? '#6777ef' : '#191d21'}}">
                <div class="announcement-listing-details">
                    <div class="d-flex category-listing-description">
                        <div class="category-data">
                            <a href="{{ route('clients.announcements.show',$announcement->id) }}"
                               class="text-decoration-none">
                                <big class="announcement-listing-title mb-5">
                                    <b>{{ html_entity_decode($announcement->subject) }}</b>
                                </big>
                            </a>
                        </div>
                    </div>
                    <div class="ml-2">
                        <span>{!! Str::limit($announcement->message, $limit = 150, $end = '...') !!}</span>
                    </div>
                    <div class="announcement-date-time">
                    <span data-toggle="tooltip" data-placement="right"
                          title="{{ date('jS M, Y ', strtotime($announcement->date)) }}">{{ $announcement->date->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="mt-0 mb-5 col-12 d-flex justify-content-center mb-5 rounded">
            <div class="p-2">
                @if(empty($search))
                    <p class="text-dark">{{ __('messages.announcement.no_announcement_available') }}</p>
                @else
                    <p class="text-dark">{{ __('messages.announcement.announcement_not_found') }}</p>
                @endif
            </div>
        </div>
    @endforelse

    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }}  
                    <span class="font-weight-bold ml-1 mr-1">{{ $announcements->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $announcements->lastItem() }}</span> {{ __('messages.common.of') }}
                    <span class="font-weight-bold ml-1">{{ $announcements->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</div>

<div>
    <div class="row">
        <div class="mt-0 mb-3 col-12 d-flex justify-content-end">
            <div class="p-2">
                <input wire:model.debounce.100ms="search" type="search" class="form-control"
                       placeholder="Search"
                       id="search">
            </div>
        </div>
        @php
            $border = 'border-top: 2px solid ';
        @endphp
        @forelse($announcements as $announcement)
            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="hover-effect-announcement announcement-card position-relative mb-4 announcement-height"
                     style="{{ $border }}{{ $loop->odd ? '#6777ef' : '#191d21'}}">
                    <div class="announcement-listing-details">
                        <div class="d-flex category-listing-description">
                            <div class="category-data">
                                <a href="{{ route('announcements.show',$announcement->id) }}"
                                   class="text-decoration-none">
                                    <big class="announcement-listing-title mb-5">
                                        <b>{{ Str::limit(html_entity_decode($announcement->subject), 15, '...') }}</b>
                                    </big>
                                </a>
                            </div>
                            <div class="float-right ml-auto">
                                <a class="dropdown dropdown-list-toggle">
                                    <a href="#" data-toggle="dropdown"
                                       class="notification-toggle action-dropdown d-none position-xs-bottom">
                                        <i class="fas fa-ellipsis-v action-toggle-mr"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-list-content dropdown-list-icons">
                                            <a href="#" class="dropdown-item dropdown-item-desc edit-btn"
                                               data-id="{{ $announcement->id }}"><i
                                                        class="fas fa-edit mr-2 card-edit-icon"></i> {{ __('messages.common.edit') }}
                                            </a>
                                            <a href="#" class="dropdown-item dropdown-item-desc delete-btn"
                                               data-id="{{ $announcement->id }}"><i
                                                        class="fas fa-trash mr-2 card-delete-icon"></i>{{ __('messages.common.delete') }}
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="custom-switch pl-0" data-placement="bottom" title="Show to client">
                                <input type="checkbox" name="show_to_clients" value="1"
                                       data-id="{{ $announcement->id }}" class="custom-switch-input"
                                       id="showToClients" {{ !empty($announcement->show_to_clients) ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="text-right status-margin mb-2">
                            <label class="custom-switch pl-0" data-placement="bottom" title="Status">
                                <input type="checkbox" name="status" value="1" data-id="{{ $announcement->id }}"
                                       class="custom-switch-input"
                                       id="announcementStatus" {{ !empty($announcement->status) ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                            </label>
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
</div>

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
                        <input wire:model.debounce.100ms="searchByDepartment" type="search" autocomplete="off"
                               id="searchByDepartment" placeholder="{{ __('messages.common.search') }}"
                               class="form-control">
                    </div>
                </div>
            </div>
            @if(count($departments) > 0)
                <div class="content">
                    <div class="row position-relative">
                        @foreach($departments as $department)
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 mb-3">
                                <div class="hover-effect-department position-relative mb-4 department-card-hover-border">
                                    <div class="department-listing-details">
                                        <div class="d-flex department-listing-description">
                                            <div class="department-data">
                                                <h3 class="department-listing-title mb-1">
                                                    <a href="#"
                                                       class="text-dark text-decoration-none departments-listing-text show-btn"
                                                       data-id="{{ $department->id }}" data-toggle="tooltip"
                                                       title="{{ html_entity_decode($department->name) }}">
                                                        {{ Str::limit(html_entity_decode($department->name), 20, '...') }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="department-action-btn">
                                        <a title="Edit"
                                           class="btn action-btn edit-btn department-edit"
                                           data-id="{{ $department->id }}"
                                           href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete"
                                           class="btn action-btn delete-btn department-delete"
                                           data-id="{{ $department->id }}"
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
                                    <span class="font-weight-bold ml-1 mr-1">{{ $departments->firstItem() }}</span> -
                                    <span class="font-weight-bold ml-1 mr-1">{{ $departments->lastItem() }}</span> {{ __('messages.common.of') }}
                                    <span class="font-weight-bold ml-1">{{ $departments->total() }}</span>
                                </span>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                @if($departments->count() > 0)
                                    {{ $departments->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                    @if(empty($searchByDepartment))
                        <p class="text-dark">{{ __('messages.department.no_department_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.department.department_not_found') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

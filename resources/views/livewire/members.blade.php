<div class="row">
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
    @forelse($members as $member)
        <div class="col-12 col-md-6 col-lg-4 col-xl-4 extra-large">
            <div class="livewire-card card {{ $loop->odd ? 'card-primary' : 'card-dark'}} shadow mb-5 rounded user-card-view">
                <div class="card-header d-flex align-items-center user-card-index d-sm-flex-wrap-0">
                    <div class="author-box-left pl-0 mb-auto">
                        <img alt="image" width="50" src="{{ $member->image_url }}"
                             class="rounded-circle user-avatar-image uAvatar">
                    </div>
                    <div class="ml-2 w-100 mb-auto">
                        <div class="justify-content-between d-flex">
                            <div class="user-card-name pb-1">
                                <a href="{{ url('admin/members/'.$member->id) }}" class="anchor-underline">
                                    <h4>{{ Str::limit(html_entity_decode($member->first_name), 12, '...') }}</h4></a>
                            </div>
                            <a class="dropdown dropdown-list-toggle">
                                <a href="#" data-toggle="dropdown"
                                   class="notification-toggle action-dropdown d-none position-xs-bottom">
                                    <i class="fas fa-ellipsis-v action-toggle-mr"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-list-content dropdown-list-icons">
                                        <a href="{{ route('members.edit',$member->id) }}"
                                           class="dropdown-item dropdown-item-desc edit-btn"
                                           data-id="{{ $member->id }}"><i
                                                    class="fas fa-edit mr-2 card-edit-icon"></i> {{ __('messages.common.edit') }}
                                        </a>
                                        <a href="#" class="dropdown-item dropdown-item-desc delete-btn"
                                           data-id="{{ $member->id }}"><i
                                                    class="fas fa-trash mr-2 card-delete-icon"></i>{{ __('messages.common.delete') }}
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @if(!empty($member->role_names))
                            <div class="card-member-role">
                                {{ $member->role_names }}
                            </div>
                        @endif
                        <div class="card-user-email pt-1 mb-1">
                            {{ $member->email }}
                            @if(!empty($member->email_verified_at))
                                <span data-toggle="tooltip" title="{{ __('messages.member.email_is_verified') }}"><i
                                            class="fas fa-check-circle email-verified"></i></span>
                            @else
                                <span data-toggle="tooltip" title="{{ __('messages.member.email_is_not_verified') }}"><i
                                            class="fas fa-times-circle email-not-verified"></i></span>
                            @endif
                        </div>
                        <span>{{ $member->phone }}</span>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center pt-0 pl-3 ml-2">
                    <div class="mr-3 mt-2">
                        <span class="badge badge-primary">{{ $member->projects_count }}</span> {{ __('messages.projects') }}
                    </div>
                    @if($member->id != getLoggedInUserId())
                        <div class="mt-2 member-card-toggle">
                            <label class="custom-switch pl-0" data-placement="bottom"
                                   title="{{ $member->is_enable ? __('messages.common.active') : __('messages.common.deactive') }}">
                                <input type="checkbox" name="is_enable" class="custom-switch-input is-administrator"
                                       data-id="{{ $member->id }}" value="1"
                                       data-class="is_enable" {{ $member->is_enable ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    @endif
                    @if(empty($member->email_verified_at))
                        <div class="ml-auto mt-1 member-card-toggle">
                            <button class="btn btn-primary btn-sm p-0 pl-1 pr-1 email-btn" data-id="{{ $member->id }}"
                                    data-toggle="tooltip" title="Resend Email Verification"><i
                                        class="fas fa-sync font-size-12px"></i></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="mt-0 mb-5 col-12 d-flex justify-content-center mb-5 rounded">
            <div class="p-2">
                @if(empty($search))
                    <p class="text-dark">{{ __('messages.member.no_member_available') }}</p>
                @else
                    <p class="text-dark">{{ __('messages.member.member_not_found') }}</p>
                @endif
            </div>
        </div>
    @endforelse

    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }} 
                    <span class="font-weight-bold ml-1 mr-1">{{ $members->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $members->lastItem() }}</span> {{ __('messages.common.of') }} 
                    <span class="font-weight-bold ml-1">{{ $members->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</div>

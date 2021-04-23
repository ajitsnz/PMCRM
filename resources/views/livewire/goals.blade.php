<div>
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
        @forelse($goals as $goal)
            @php
                $inStyle = 'style';
                $color = '#E59100';
                $bgColor = 'background-color';
            @endphp
            <div class="col-12 col-md-6 col-lg-4 col-xl-4 extra-large">
                <div class="livewire-card card {{ $loop->odd ? 'card-primary' : 'card-dark'}} shadow mb-5 rounded user-card-view hover-effect-goal">
                    <div class="p-2 pb-0">
                        <div class="progress progress-bar-mini height-25 mt-2 goal-progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                 aria-valuenow="" aria-valuemin="0" aria-valuemax="100" {{$inStyle}}="
                        width:{{$goal->goal_progress_count}}% ; {{$bgColor}}: {{ $color }}">
                        </div>
                        <p class="goal-progress-width-text {{ ($goal->goal_progress_count > 55) ? 'text-white' : 'text-dark' }}">{{number_format($goal->goal_progress_count,2)}}
                            %</p>
                    </div>
                </div>
                <div class="card-header d-flex align-items-center user-card-index d-sm-flex-wrap-0">
                    <div class="ml-2 w-100 mb-auto">
                        <div class="justify-content-between d-flex">
                            <div class="d-inline-block goal-card-name">
                                <a href="{{  url('admin/goals/'.$goal->id)}}" class="anchor-underline">
                                    <span class="text-primary">{{ \Illuminate\Support\Str::limit(html_entity_decode($goal->subject), 20 , '...') }}</span>
                                </a>
                            </div>
                            <a class="dropdown dropdown-list-toggle">
                                <a href="#" data-toggle="dropdown"
                                   class="notification-toggle action-dropdown d-none position-xs-bottom">
                                    <i class="fas fa-ellipsis-v action-toggle-mr"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-list-content dropdown-list-icons">
                                        <a href="{{ route('goals.edit',$goal->id) }}"
                                           class="dropdown-item dropdown-item-desc edit-btn"
                                           data-id="{{ $goal->id }}"><i
                                                    class="fas fa-edit mr-2 card-edit-icon"></i> {{ __('messages.common.edit') }}
                                        </a>
                                        <a href="#" class="dropdown-item dropdown-item-desc delete-btn"
                                           data-id="{{ $goal->id }}"><i
                                                    class="fas fa-trash mr-2 card-delete-icon"></i>{{ __('messages.common.delete') }}
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card-body pt-1 pl-0 pb-0 pr-0">
                            <div class="line-height-20px">
                                <label class="font-weight-bold">{{__('messages.goal.goal_type')}}: </label>
                                <span>{{\App\Models\Goal::GOAL_TYPE[$goal->goal_type]}}</span>
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-start align-items-center pt-0 pb-2 pl-0 pr-0">
                            <div class="mt-2 d-Class">
                                @foreach($goal->goalMembers as $counter => $member)
                                    @if($counter < 5)
                                        <img class="goal-avatar-image p-0"
                                             src="{{ $member->image_url }}"
                                             title="{{ html_entity_decode($member->full_name) }}">
                                    @elseif($counter == (count($goal->goalMembers) - 1))
                                        <span class="goal_remaining_user mt-1"><b> + {{ (count($goal->goalMembers) - 5) }}</b></span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @empty
        <div class="mt-0 mb-5 col-12 d-flex justify-content-center mb-5 rounded">
            <div class="p-2">
                @if(empty($search))
                    <p class="text-dark">{{ __('messages.goal.no_goal_available') }}</p>
                @else
                    <p class="text-dark">{{ __('messages.goal.no_goal_found') }}</p>
                @endif
            </div>
        </div>
    @endforelse

    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }} 
                    <span class="font-weight-bold ml-1 mr-1">{{ $goals->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $goals->lastItem() }}</span> {{ __('messages.common.of') }} 
                    <span class="font-weight-bold ml-1">{{ $goals->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $goals->links() }}
            </div>
        </div>
    </div>
</div>

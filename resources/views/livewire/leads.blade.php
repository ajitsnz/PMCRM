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
    @php
        $inStyle = 'style';
        $bgColor = 'background-color:';
    @endphp
    <div class="col-md-12">
        <div class="row justify-content-md-center text-center mb-4">
            <div class="owl-carousel owl-theme">
                @foreach($data as $status)
                    <div class="item">
                        <div class="ticket-statistics mx-auto" {{$inStyle}}="{{$bgColor}} {{ $status->color }}">
                        <p>{{ $status->leads_count }}</p>
                    </div>
                    <h5 class="my-0 mt-1">{{ html_entity_decode($status->name) }}</h5>
            </div>
            @endforeach
        </div>
    </div>
</div>

<?php
$border = 'border-top: 2px solid ';
?>
@forelse($leads as $lead)
    <div class="col-12 col-md-6 col-lg-4 col-xl-4 extra-large mb-5">
        <div class="livewire-card card shadow rounded user-card-view hover-effect-lead lead-card-height"
             style="{{ $border .$lead->leadStatus->color}}">
            <div class="card-header d-flex align-items-center user-card-index d-sm-flex-wrap-0">
                <div class="ml-2 w-100 mb-auto">
                    <div class="justify-content-between d-flex">
                        <div class="d-inline-block lead-card-name">
                            <a href="{{  url('admin/leads/'.$lead->id)}}" class="anchor-underline">
                                <span>{{ Str::limit(html_entity_decode($lead->name), 10, '...') }}  </span>
                                <span class="text-grey">({{ html_entity_decode($lead->company_name) }})</span>
                            </a>
                        </div>
                        <a class="dropdown dropdown-list-toggle">
                            <a href="#" data-toggle="dropdown"
                               class="notification-toggle action-dropdown d-none position-xs-bottom">
                                <i class="fas fa-ellipsis-v action-toggle-mr"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-list-content dropdown-list-icons">
                                    <a href="{{ route('leads.edit',$lead->id) }}"
                                       class="dropdown-item dropdown-item-desc edit-btn"
                                       data-id="{{ $lead->id }}"><i
                                                class="fas fa-edit mr-2 card-edit-icon"></i> {{ __('messages.common.edit') }}
                                    </a>
                                    <a href="#" class="dropdown-item dropdown-item-desc delete-btn"
                                       data-id="{{ $lead->id }}"><i
                                                class="fas fa-trash mr-2 card-delete-icon"></i>{{ __('messages.common.delete') }}
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body pt-1 pl-0 pb-0">
                        <div class="line-height-20px">
                            <label class="font-weight-bold">{{__('messages.lead.source')}}: </label>
                            <span>{{ html_entity_decode($lead->leadSource->name) }}</span>
                        </div>
                    </div>
                    <div class="card-body pt-0 pl-0 pb-0">
                        @if(!empty($lead->estimate_budget))
                            <div class="line-height-20px">
                                <label class="font-weight-bold">{{__('messages.lead.estimate_budget')}}: </label>
                                <span><i class="{{ getCurrencyClass() }}"></i> {{ number_format($lead->estimate_budget, 2) }}</span>
                            </div>
                        @endif
                    </div>
                    @php
                        $inStyle = 'style';
                        $bgColor = 'background-color';
                    @endphp
                    <div class="card-body pt-0 pl-0 pb-3 d-flex pr-0">
                        <div class="pt-2">
                            <span class="badge text-uppercase text-white" {{$inStyle}}="{{$bgColor}}
                            :{{$lead->leadStatus->color}}">{{ html_entity_decode($lead->leadStatus->name) }}</span>
                        </div>
                        <div class="author-box-left pl-0 ml-auto">
                            @if(!empty($lead->assignedTo->image_url))
                                <img alt="image" width="50" src="{{ $lead->assignedTo->image_url }}"
                                     class="rounded-circle lead-avatar-image uAvatar"
                                     title="{{ html_entity_decode($lead->assignedTo->full_name) }}">
                            @endif
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
                <p class="text-dark">{{ __('messages.lead.no_lead_available') }}</p>
            @else
                <p class="text-dark">{{ __('messages.lead.no_lead_found') }}</p>
            @endif
        </div>
    </div>
@endforelse

<div class="mt-0 mb-5 col-12">
    <div class="row paginatorRow">
        <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }} 
                    <span class="font-weight-bold ml-1 mr-1">{{ $leads->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $leads->lastItem() }}</span> {{ __('messages.common.of') }} 
                    <span class="font-weight-bold ml-1">{{ $leads->total() }}</span>
                </span>
        </div>
        <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
            {{ $leads->links() }}
        </div>
    </div>
</div>
</div>

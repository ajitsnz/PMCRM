<div>
    <div class="row">
        <div class="col-md-12">
            <div wire:loading id="overlay-screen-lock">
                <div class="live-wire-infy-loader">
                    @include('loader')
                </div>
            </div>
        </div>
        <div class="mt-0 mb-3 col-12 d-flex justify-content-end search-display-block">
            @if(!empty($customer))
                <div class="mt-2">
                    {{Form::select('status', $ticketStatusArr, null, ['id' => 'customerTicketStatus', 'class' => 'form-control status-filter', 'placeholder' => 'Select Status']) }}
                </div>
            @endif
            <div class="p-2">
                <input wire:model.debounce.100ms="search" type="search" class="form-control" placeholder="Search"
                       id="search">
            </div>
        </div>
        @php
            $inStyle = 'style';
            $style = 'background-color:';
        @endphp
        <div class="col-md-12">
            <div class="row justify-content-md-center text-center mb-4">
                <div class="owl-carousel owl-theme">
                    @foreach($statusCounts as $status)
                        <div class="item">
                            <div class="ticket-statistics mx-auto" {{$inStyle}}="{{$style}} {{ $status->pick_color }}">
                            <p>{{ $status->tickets_count }}</p>
                        </div>
                        <h5 class="my-0 mt-1">{{ html_entity_decode($status->name) }}</h5>
                </div>
                @endforeach
            </div>
        </div>
        <?php
        $border = 'border-top: 2px solid ';
        ?>
        <div class="col-lg-12 col-md-12">
            @if(count($tickets) > 0)
                <div class="content">
                    <div class="row position-relative">
                        @foreach($tickets as $ticket)
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="livewire-card card shadow mb-5 rounded hover-card card-height"
                                     style="{{ $border .$ticket->ticketStatus->pick_color}}">
                                    <div class="ribbon float-right tickets-ribbon ribbon-success">
                                        <span class="badge ticket-status text-white" {{$inStyle}}=
                                        "{{$style}} {{ $ticket->ticketStatus->pick_color }}"
                                        >{{ html_entity_decode($ticket->ticketStatus->name) }}</span>
                                    </div>
                                    <div class="tickets-listing-details agent-tickets-listing-details">
                                        <div class="d-flex tickets-listing-description">
                                            <div class="tickets-data">
                                                <h3 class="tickets-listing-title mb-1">
                                                    <a href="{{ url('admin/tickets',$ticket->id) }}"
                                                       class="text-primary text-decoration-none letter-space-1">{{ \Illuminate\Support\Str::limit(html_entity_decode($ticket->subject), 15 ,'...') }}</a>
                                                </h3>
                                                @if(!empty($ticket->user))
                                                    <h3 class="tickets-listing-title mt-2">
                                                        <span data-toggle="tooltip" title=""
                                                              data-original-title="{{ html_entity_decode($ticket->user->full_name) }}"><i
                                                                    class="fas fa-user text-pick"></i>
                                                        &nbsp;{{ Str::limit(html_entity_decode($ticket->user->full_name), 25, '...') }}
                                                        </span>
                                                    </h3>
                                                @endif
                                                @php
                                                    $inStyle = 'style';
                                                    $styleBackground = 'color: ';
                                                @endphp
                                                @if(!empty($ticket->department))
                                                    <h3 class="tickets-listing-title">
                                                        <span data-toggle="tooltip" title=""
                                                              data-original-title="{{ html_entity_decode($ticket->department->name) }}"><i
                                                                    class="fas fa-columns"></i>
                                                        {{ Str::limit(html_entity_decode($ticket->department->name), 25, '...') }}
                                                        </span>
                                                    </h3>
                                                @endif
                                                <h3 class="tickets-listing-title">
                                                    <i class="far fa-clock  text-lightgreen"></i>
                                                    &nbsp;{{ $ticket->created_at->diffForHumans() }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right ticket-action-btn d-none">
                                        <a title="Edit" class="action-btn edit-btn tickets-edit"
                                           href="{{ route('ticket.edit',$ticket->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a title="Delete" class="text-danger action-btn delete-btn tickets-delete"
                                           data-id="{{ $ticket->id }}" href="#">
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
                                    <span class="font-weight-bold ml-1 mr-1">{{ $tickets->firstItem() }}</span> -
                                    <span class="font-weight-bold ml-1 mr-1">{{ $tickets->lastItem() }}</span> {{ __('messages.common.of') }}
                                    <span class="font-weight-bold ml-1">{{ $tickets->total() }}</span>
                                </span>
                            </div>
                            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                                @if($tickets->count() > 0)
                                    {{ $tickets->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 d-flex justify-content-center">
                    @if(empty($search))
                        <p class="text-dark">{{ __('messages.ticket.no_ticket_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.ticket.ticket_not_found') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

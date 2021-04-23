<div class="row col-12 d-flex flex-nowrap pb-3">
    @foreach ($ticketStatus as $index => $statusText)
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="card board">
                <div class="card-header bg-light border-0">
                    <h4 class="text-primary">{{ html_entity_decode($statusText->name) }}</h4>
                </div>
                <div class="card-body p-2 bg-light">
                    <div class="infy-loader overlay-screen-lock" style="display: none">
                        @include('loader')
                    </div>
                    <div class="board-{{ $index }}" data-board-status="{{ $statusText->id }}">
                        @php $statusTickets = (isset($tickets[$statusText->id])) ? $tickets[$statusText->id] : [] @endphp
                        @foreach ($statusTickets as $ticketRecord)
                            @if($ticketRecord->ticket_status_id != $statusText->id)
                                @continue;
                            @endif
                            <div class="card mb-3 " data-id="{{ $ticketRecord->id }}"
                                 data-status="{{ $statusText->name }}"
                                 data-task-status="{{ $ticketRecord->ticket_status_id }}">
                                <div class="card-body p-3 no-touch">
                                    <a href="{{ url('admin/tickets/'.$ticketRecord->id) }}"
                                       class="mb-0 text-primary text-decoration-none"
                                       data-id="{{ $ticketRecord->id }}">{{ html_entity_decode($ticketRecord->subject) }}</a>
                                    <div class="col-xs-12 ml-1 mt-1 w-100">
                                        <div class="d-flex justify-content-between">
                                            @if(isset($ticketRecord->department))
                                                <div>
                                                    <b>{{ __('messages.ticket.department').':' }}</b> {{ html_entity_decode($ticketRecord->department->name) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 ml-1 mt-1 w-100">
                                        @if(isset($ticketRecord->cc))
                                            <b>{{ __('messages.ticket.cc').':' }}</b> {{ $ticketRecord->cc }}
                                        @endif
                                    </div>
                                    <div class="task-footer d-flex align-items-center justify-content-between row mt-2">
                                        <div class="avatar-container col-xs-12 ml-3">
                                            @if($ticketRecord->user != null)
                                                <figure class="avatar avatar-sm" data-toggle="tooltip"
                                                        title="{{ $ticketRecord->user->full_name }}">
                                                    <img src="{{ $ticketRecord->user->image_url }}">
                                                </figure>
                                            @endif
                                        </div>
                                        <div class="mt-1 mr-3">
                                            <div class="text-right">
                                                @if(isset($ticketRecord->ticketPriority))
                                                    <span class="badge badge-primary badge-padding"
                                                          data-toggle="tooltip"
                                                          title="{{ __('messages.ticket.priority').' Is ' .html_entity_decode($ticketRecord->ticketPriority->name) }}">{{ html_entity_decode($ticketRecord->ticketPriority->name) }}</span>
                                                @endif
                                                @if(isset($ticketRecord->service))
                                                    <span class="badge badge-success badge-padding"
                                                          data-toggle="tooltip"
                                                          title="{{ __('messages.ticket.service').' Is ' .html_entity_decode($ticketRecord->service->name) }}">{{ html_entity_decode($ticketRecord->service->name) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

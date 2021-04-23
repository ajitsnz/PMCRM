<div class="row col-12 d-flex flex-nowrap pb-3">
    @foreach ($leadStatus as $index => $statusText)
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
                        @php $statusLeads = (isset($leads[$statusText->id])) ? $leads[$statusText->id] : [] @endphp
                        @foreach ($statusLeads as $leadRecord)
                            @if($leadRecord->status_id != $statusText->id)
                                @continue;
                            @endif
                            <div class="card mb-3 " data-id="{{ $leadRecord->id }}"
                                 data-status="{{ $statusText->name }}"
                                 data-task-status="{{ $leadRecord->status_id }}">
                                <div class="card-body p-3 no-touch">
                                    <a href="{{ url('admin/leads/'.$leadRecord->id) }}"
                                       class="mb-0 text-primary text-decoration-none"
                                       data-id="{{ $leadRecord->id }}">
                                        {{ Str::limit(html_entity_decode($leadRecord->name), 20, '..') }}
                                    </a>
                                    <div class="col-xs-12 ml-1 mt-1 w-100">
                                        <div class="d-flex justify-content-between">
                                            <div class="ml-1">
                                                <i class="fas fa-street-view"></i>
                                                {{ html_entity_decode($leadRecord->company_name) }}
                                            </div>
                                            <div class="tracked-time text-right mr-2">
                                                <i class="{{ getCurrencyClass() }}"></i>
                                                {{ (isset($leadRecord->estimate_budget)) ? $leadRecord->estimate_budget : 0 }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="task-footer d-flex align-items-center justify-content-between row">
                                        <div class="avatar-container col-xs-12 mt-2 ml-3">
                                            @if($leadRecord->assignedTo != null)
                                                <figure class="avatar avatar-sm" data-toggle="tooltip"
                                                        title="{{ html_entity_decode($leadRecord->assignedTo->full_name) }}">
                                                    <img src="{{ $leadRecord->assignedTo->image_url }}">
                                                </figure>
                                            @endif
                                        </div>
                                        <div class="mt-1 mr-3">
                                            <div class="text-right">
                                                @if(isset($leadRecord->position))
                                                    <span class="badge badge-primary badge-padding"
                                                          data-toggle="tooltip"
                                                          title="{{ __('messages.contact.position').' Is ' .$leadRecord->position }}">{{ $leadRecord->position }}
                                                </span>
                                                @endif
                                                <span class="badge badge-success badge-padding" data-toggle="tooltip"
                                                      title="{{ __('messages.lead.source').' Is ' .html_entity_decode($leadRecord->leadSource->name) }}">{{ html_entity_decode($leadRecord->leadSource->name) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 ml-1 mt-2">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <i class="font-size-medium {{(isset($leadRecord->public) && $leadRecord->public == 1) == 1? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger'}}">
                                                </i> {{__('messages.task.public')}}
                                            </div>
                                            <div class="due-date mr-2">
                                                {{ $leadRecord->created_at->diffForHumans() }}
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

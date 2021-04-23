<div class="row col-12 d-flex flex-nowrap pb-3">
    @foreach ($taskStatus as $status => $statusText)
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="card board">
                <div class="card-header bg-light border-0">
                    <h4 class="text-primary">{{ html_entity_decode($statusText) }}</h4>
                </div>
                <div class="card-body p-2 bg-light">
                    <div class="infy-loader overlay-screen-lock" style="display: none">
                        @include('loader')
                    </div>
                    <div class="board-{{$status - 1}}" data-board-status="{{ $status}}">
                        @php $statusTasks = (isset($tasks[$status])) ? $tasks[$status] : [] @endphp
                        @foreach ($statusTasks as $taskRecord)
                            @if($taskRecord->status != $status)
                                @continue;
                            @endif
                            <div class="card mb-3 " data-id="{{ $taskRecord->id }}" data-status="{{ $statusText }}"
                                 data-task-status="{{ $taskRecord->status }}">
                                <div class="card-body p-3 no-touch">
                                    <a href="{{ url('admin/tasks/'.$taskRecord->id) }}"
                                       class="mb-0 text-primary text-decoration-none"
                                       data-id="{{ $taskRecord->id }}">{{ html_entity_decode($taskRecord->subject) }}</a>
                                    <div class="col-xs-12 ml-1 mt-1 w-100">
                                        <div class="d-flex justify-content-between">
                                            @if(isset($taskRecord->start_date))
                                                <div class="due-date">
                                                    <b>{{ __('messages.task.start_date').':' }}</b> {{ \Carbon\Carbon::parse($taskRecord->start_date)->format('d/m/y') }}
                                                </div>
                                            @endif
                                            @if(isset($taskRecord->due_date))
                                                <div class="due-date">
                                                    <b>{{ __('messages.task.due_date').':' }}</b> {{ \Carbon\Carbon::parse($taskRecord->due_date)->format('d/m/y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="task-footer d-flex align-items-center justify-content-between row mt-2">
                                        <div class="avatar-container col-xs-12 ml-3">
                                            @if($taskRecord->user != null)
                                                <figure class="avatar avatar-sm" data-toggle="tooltip"
                                                        title="{{ $taskRecord->user->full_name }}">
                                                    <img src="{{ $taskRecord->user->image_url }}">
                                                </figure>
                                            @endif
                                        </div>
                                        <div class="mt-1 mr-3">
                                            <div class="text-right">
                                                @if(isset($taskRecord->related_to))
                                                    <span class="badge badge-success badge-padding"
                                                          data-toggle="tooltip"
                                                          title="{{ __('messages.task.related_to').' Is ' .(isset($taskRecord->related_to)?\App\Models\Task::RELATED_TO_array[$taskRecord->related_to]: __('messages.common.n/a')) }}">{{ isset($taskRecord->related_to)?\App\Models\Task::RELATED_TO_array[$taskRecord->related_to]: __('messages.common.n/a') }}
                                                    </span>
                                                @endif
                                                <span class="badge badge-primary badge-padding" data-toggle="tooltip"
                                                      title="{{ __('messages.task.priority').' Is ' .\App\Models\Task::PRIORITY[$taskRecord->priority] }}">
                                                    {{ \App\Models\Task::PRIORITY[$taskRecord->priority] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div class="ml-1">
                                            <i class="font-size-medium {{(isset($taskRecord->billable) && $taskRecord->billable == 1) == 1? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger'}}"></i> {{__('messages.task.billable')}}
                                        </div>
                                        <div class="left-margin-label">
                                            <i class="font-size-medium {{((isset($taskRecord->public) && $taskRecord->public == 1) == 1) == 1? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger'}}"></i> {{__('messages.task.public')}}
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

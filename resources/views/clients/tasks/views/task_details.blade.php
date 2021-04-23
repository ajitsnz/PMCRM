@extends('clients.tasks.show')
@section('section')
    <div class="row">
        @if(!empty($task->public))
            <div class="form-group col-6 col-sm-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           id="customCheck"
                           name="public" value="1"
                           {{ (isset($task) && $task->public == 1) ? 'checked' : '' }} disabled>
                    <label class="custom-control-label"
                           for="customCheck">{{__('messages.task.public')}}</label>
                </div>
            </div>
        @endif
        @if(!empty($task->billable))
            <div class="form-group col-6 col-sm-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           id="customCheck1"
                           name="billable" value="1"
                           {{ (isset($task) && $task->billable == 1) ? 'checked' : '' }} disabled>
                    <label class="custom-control-label"
                           for="customCheck1">{{__('messages.task.billable')}}</label>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('subject', __('messages.task.subject').':') }}
            <p>{{ html_entity_decode($task->subject) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('hourly_rate', __('messages.task.hourly_rate').':') }}
            @if(isset($task->hourly_rate))
                <p><i class="{{getCurrencyClass()}}"></i> {{$task->hourly_rate}}</p>
            @else
                <p>{{ __('messages.common.n/a') }}</p>
            @endif
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('start_date', __('messages.task.start_date').':') }}
            <p>
                <span>{{ isset($task->start_date) ? date('jS M, Y H:i A', strtotime($task->start_date)) : __('messages.common.n/a')}}</span>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('due_date', __('messages.task.due_date').':') }}
            @if(isset($task->due_date))
                <p><span>{{ date('jS M, Y H:i A', strtotime($task->due_date)) }}</span>
                </p>
            @else
                <p>{{ __('messages.common.n/a') }}</p>
            @endif
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('priority', __('messages.task.priority').':') }}
            <p>{{ isset($task->priority)?\App\Models\Task::PRIORITY[$task->priority]:'N/A' }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('status', __('messages.task.status').':') }}
            <p>{{ isset($task->status)?\App\Models\Task::STATUS[$task->status]:'N/A' }}</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('assignee', __('messages.common.assignee').':') }}
            <p>{{ isset($task->user) ? html_entity_decode($task->user->full_name) : 'N/A' }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('tags', __('messages.tags').':') }}
            @forelse($task->tags as $tag)
                <p><span class="badge border border-secondary">{{ html_entity_decode($tag->name) }}</span></p>
            @empty
                <p>{{ __('messages.common.n/a') }}</p>
            @endforelse
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('related_to', __('messages.task.related_to').':') }}
            <p>{{ isset($task->related_to)?\App\Models\Task::RELATED_TO_array[$task->related_to]:'N/A' }}</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($task->created_at)) }}">{{ $task->created_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($task->updated_at)) }}">{{ $task->updated_at->diffForHumans() }}</span>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            {{ Form::label('description', __('messages.common.description').':') }}
            <br>
            {!! $task->description!=null ? html_entity_decode($task->description) : __('messages.common.n/a') !!}
        </div>
    </div>
@endsection

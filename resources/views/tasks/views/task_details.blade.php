@extends('tasks.show')
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
            <p>{{ isset($task->start_date) ? (date('jS M, Y H:i A', strtotime($task->start_date))) : __('messages.common.n/a') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('due_date', __('messages.task.due_date').':') }}
            @if(isset($task->due_date))
                <p>{{ date('jS M, Y H:i A', strtotime($task->due_date)) }}</p>
            @else
                <p>{{ __('messages.common.n/a') }}</p>
            @endif
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('priority', __('messages.task.priority').':') }}
            <p>{{ isset($task->priority)?\App\Models\Task::PRIORITY[$task->priority]: __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('status', __('messages.task.status').':') }}
            <p>{{ isset($task->status)?\App\Models\Task::STATUS[$task->status]: __('messages.common.n/a') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4">
            {{ Form::label('tags', __('messages.tags').':') }}
            <p>
                @forelse($task->tags as $tag)
                    <span class="badge border border-secondary">{{ html_entity_decode($tag->name) }}</span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('related_to', __('messages.task.related_to').':') }}
            <p>{{ isset($task->related_to)?\App\Models\Task::RELATED_TO_array[$task->related_to]: __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-sm-4">
            @if($task->owner_type == \App\Models\Invoice::class)
                {{ Form::label('owner_type', __('messages.contact.invoice').':') }}
                <p>
                    <a href="{{ url('admin/invoices/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'title')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Customer::class)
                {{ Form::label('owner_type', __('messages.invoice.customer').':') }}
                <p>
                    <a href="{{ url('admin/customers/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'company_name')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Ticket::class)
                {{ Form::label('owner_type', __('messages.task.ticket').':') }}
                <p>
                    <a href="{{ url('admin/tickets/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'subject')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Project::class)
                {{ Form::label('owner_type', __('messages.contact.project').':') }}
                <p>
                    <a href="{{ url('admin/projects/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'project_name')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Proposal::class)
                {{ Form::label('owner_type', __('messages.proposal.proposal').':') }}
                <p>
                    <a href="{{ url('admin/proposals/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'title')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Estimate::class)
                {{ Form::label('owner_type', __('messages.estimate.estimate').':') }}
                <p>
                    <a href="{{ url('admin/estimates/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'title')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Lead::class)
                {{ Form::label('owner_type', __('messages.proposal.lead').':') }}
                <p>
                    <a href="{{ url('admin/leads/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'name')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @elseif($task->owner_type == \App\Models\Contract::class)
                {{ Form::label('owner_type', __('messages.contact.contract').':') }}
                <p>
                    <a href="{{ url('admin/contracts/'.$task->owner_id) }}" class="anchor-underline">
                        {{ isset($task->owner_id) ? html_entity_decode($task->getRelatedTo($task->owner_type, 'subject')) : __('messages.common.n/a') }}
                    </a>
                </p>
            @endif
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('member_id', __('messages.common.assignee').':') }}
            <p>
                @if(!empty($task->member_id))
                    <a href="{{ url('admin/members',$task->member_id) }}"
                       class="anchor-underline">{{ html_entity_decode($task->user->full_name) }}</a>
                @else
                    {{ __('messages.common.n/a') }}
                @endif
            </p>
        </div>
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
        <div class="form-group col-sm-12">
            {{ Form::label('description', __('messages.common.description').':') }}
            <br>
            {!! $task->description!=null ? html_entity_decode($task->description) : __('messages.common.n/a') !!}
        </div>
    </div>
@endsection

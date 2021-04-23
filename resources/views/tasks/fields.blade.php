<div class="row">
    <div class="form-group col-6 col-sm-3">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="customCheck"
                   name="public" value="1"
                    {{ (isset($task) && $task->public == 1) ? 'checked' : '' }}>
            <label class="custom-control-label"
                   for="customCheck">{{__('messages.task.public')}}</label>
        </div>
    </div>
    <div class="form-group col-6 col-sm-4">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="customCheck1"
                   name="billable" value="1"
                    {{ (isset($task) && $task->billable == 1) ? 'checked' : '' }}>
            <label class="custom-control-label"
                   for="customCheck1">{{__('messages.task.billable')}}</label>
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('subject', __('messages.task.subject').':') }}<span class="required">*</span>
        {{ Form::text('subject', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('hourly_rate', __('messages.task.hourly_rate').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="{{ getCurrencyClass() }}"></i>
                </div>
            </div>
            {{ Form::text('hourly_rate', null, ['class' => 'form-control price-input','autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('start_date', __('messages.task.start_date').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('start_date', null, ['class' => 'form-control','id' => 'startDate','autocomplete' => 'off']) }}
        </div>
    </div>
    @if(!isset($task))
        <input type="hidden" name="status" value="{{ \App\Models\Task::NOT_STARTED_STATUS }}" hidden>
    @endif
    <div class="form-group col-sm-6">
        {{ Form::label('due_date', __('messages.task.due_date').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('due_date', null, ['class' => 'form-control','id' => 'dueDate','autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('priority', __('messages.task.priority').':') }}<span class="required">*</span>
        {{ Form::select('priority', $data['priority'],null, ['id'=>'priorityId','class' => 'form-control','placeholder' => 'Select Priority', 'required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('member_id', __('messages.common.assignee').':') }}
        {{ Form::select('member_id', $data['users'],isset($task->member_id)?$task->member_id:null, ['id'=>'memberId','class' => 'form-control','placeholder' => 'Select Assignee']) }}
    </div>
    @if(isset($task))
        <div class="form-group col-sm-6">
            {{ Form::label('status', __('messages.task.status').':') }}<span class="required">*</span>
            {{ Form::select('status', $data['status'],null, ['id'=>'statusId','class' => 'form-control','placeholder' => 'Select Status','required']) }}
        </div>
    @endif
    <div class="form-group col-sm-6">
        {{ Form::label('related_to', __('messages.task.related_to').':') }}
        {{ Form::select('related_to', $data['relatedTo'], isset($relatedTo) ? array_search($relatedTo, $data['relatedTo']) : null, ['id'=>'relatedToId','class' => 'form-control','placeholder' => 'Select Option']) }}
    </div>
    <div class="form-group col-sm-6 display-none" id="relatedToForm">
        {{ Form::label('owner_label', null,['id' => 'ownerLabel']) }}
        {{ Form::select('owner_id', (isset($owner)?$owner:[]),null, ['id'=>'ownerId','class' => 'form-control owner','placeholder' => 'Select Option']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('tags', __('messages.tags').':') }}
        {{ Form::select('tags[]', $data['tags'],isset($task->tags)?$task->tags:null, ['id'=>'tagId','class' => 'form-control','multiple']) }}
    </div>
    <div class="form-group col-sm-12 mb-0">
        {{ Form::label('description', __('messages.common.description').':') }}
        {{ Form::textarea('description', null, ['class' => 'form-control','id' => 'taskDescription']) }}
    </div>
</div>
<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ url()->previous() }}" class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

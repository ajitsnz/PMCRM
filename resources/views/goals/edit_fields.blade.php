<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('subject', __('messages.goal.subject').':') }}<span class="required">*</span>
        {{ Form::text('subject', null, ['class' => 'form-control','required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('goal_type', __('messages.goal.goal_type').':') }}
        {{ Form::select('goal_type', $goalTypes, !empty($goal->goal_type) ? $goal->goal_type : null, ['class' => 'form-control','required','placeholder' => 'Select Goal Type', 'id' => 'editGoalTypeId']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('user_id', __('messages.members').':') }}<span class="required">*</span>
        {{ Form::select('users[]',$members, isset($goalMembers) && (count($goalMembers) >0) ? $goalMembers:null, ['class' => 'form-control staffMember','required','id' => 'staffMember','multiple' => true]) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('achievement',__('messages.goal.achievement').':') }}<span class="required">*</span>
        {{ Form::number('achievement', null, ['class' => 'form-control','required']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12 col-lg-6 col-md-12">
        {{ Form::label('start_date', __('messages.goal.start_date').':') }} <span class="required">*</span>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('start_date', isset($goal->start_date) ? $goal->start_date : null, ['class' => 'form-control startDatepicker', 'required','autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="form-group col-sm-12 col-lg-6 col-md-12">
        {{ Form::label('end_date', __('messages.goal.end_date').':') }} <span class="required">*</span>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('end_date', isset($goal->end_date) ? $goal->end_date : null, ['class' => 'form-control endDatepicker', 'required','autocomplete' => 'off']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12 mb-0">
        {{ Form::label('description',__('messages.goal.description').':') }}
        {{ Form::textarea('description', null, ['class' => 'form-control summernote-simple', 'id' => 'goalDescription']) }}
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="isNotify"
                   name="is_notify" value="1"
                    {{$goal->is_notify == 1? 'checked' : ''}}>
            <label class="custom-control-label"
                   for="isNotify"> {{ __('messages.goal.is_notify') }}</label>
        </div>
    </div>
    <div class="form-group col-12">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="isNotNotify"
                   name="is_not_notify" value="1"
                    {{$goal->is_not_notify == 1? 'checked' : ''}}>
            <label class="custom-control-label"
                   for="isNotNotify"> {{ __('messages.goal.is_not_notify') }}</label>
        </div>
    </div>
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ route('goals.index') }}"
           class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>


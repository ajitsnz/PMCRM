<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('subject', __('messages.goal.subject').':') }}<span class="required">*</span>
        {{ Form::text('subject', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('goal_type', __('messages.goal.goal_type').':') }}<span class="required">*</span>
        {{ Form::select('goal_type', $goalTypes, null, ['class' => 'form-control','required','placeholder' => 'Select Goal Type', 'id' => 'goalTypeId']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('user_id', __('messages.members').':') }}<span class="required">*</span>
        {{ Form::select('users[]',$members, null, ['class' => 'form-control staffMember','required','multiple' => true]) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('achievement',__('messages.goal.achievement').':') }}<span class="required">*</span>
        {{ Form::number('achievement', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
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
    <div class="col-sm-12">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   name="is_notify" id="isNotify">
            <label class="custom-control-label" for="isNotify">{{ __('messages.goal.is_notify') }}
            </label>
        </div>
    </div>
    <div class="form-group col-sm-12">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   name="is_not_notify" id="isNotNotify">
            <label class="custom-control-label" for="isNotNotify">{{ __('messages.goal.is_not_notify') }}
            </label>
        </div>
    </div>
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ route('goals.index') }}"
           class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>


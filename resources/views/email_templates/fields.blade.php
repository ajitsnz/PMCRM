<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group col-sm-12 font-weight-bold">
            <h5>{{ $emailTemplate->template_name }}</h5>
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('template_name', __('messages.email_template.template_name').':') }}<span
                    class="required">*</span>
            {{ Form::text('template_name', $emailTemplate->template_name, ['class' => 'form-control','readonly','required']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('subject', __('messages.email_template.subject').':') }}
            {{ Form::text('subject', $emailTemplate->subject, ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('from_name', __('messages.email_template.from_name').':') }}<span class="required">*</span>
            {{ Form::text('from_name', $emailTemplate->from_name, ['class' => 'form-control','required']) }}
        </div>
        <div class="form-group col-sm-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input"
                       id="check1"
                       name="send_plain_text" value="1"
                        {{ $emailTemplate->send_plain_text == 0 ? '' : 'checked' }}>
                <label class="custom-control-label"
                       for="check1">{{__('messages.email_template.send_plain_text') }}</label>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input"
                       id="check2"
                       name="disabled" value="1"
                        {{ $emailTemplate->disabled == 0 ? 'checked' : '' }}>
                <label class="custom-control-label"
                       for="check2">{{__('messages.email_template.disabled') }}</label>
            </div>
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('email_message', __('messages.email_template.email_message').':') }}
            {{ Form::textarea('email_message', $emailTemplate->email_message, ['class' => 'form-control','id' => 'emailMessage']) }}
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group col-sm-12 font-weight-bold">
            <h5>{{__('messages.email_template.available_merge_fields')}}</h5>
        </div>
        <div class="form-group row col-sm-12">
            @foreach($mergeFields as $key => $fields)
                <div class="col-md-6 col-sm-12">
                    <h6 class="mt-3">{{ $key }}</h6>
                    @foreach($fields as $key => $value)
                        <span class="text-left mr-3 mx-1">{{ $value }}</span>
                        <span class="remove-underline">
                        <a class="text-primary fieldText float-right" href="#">{{ '{'.$key.'}' }}</a>
                        </span>
                        <br>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {{ Form::submit('Save', ['class' => 'btn btn-primary' , 'id' => 'btnEditSave']) }}
        <a href="{{ route('email-templates.index') }}"
           class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

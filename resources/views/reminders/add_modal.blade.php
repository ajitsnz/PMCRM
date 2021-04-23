<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.reminder.new_reminder') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'addNewForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <input type="hidden" name="module_id" value="{{ $data['moduleId'] }}" id="moduleId">
                <input type="hidden" name="owner_id" value="{{ $data['ownerId'] }}" id="ownerId">
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('notified_date',__('messages.reminder.notified_date').':') }}<span
                                class="required">*</span>
                        {{ Form::text('notified_date', null, ['class' => 'form-control','id' => 'notifiedDate','required','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('reminder_to', __('messages.reminder.reminder_to').':') }}<span
                                class="required">*</span>
                        {{ Form::select('reminder_to', $data['reminderTo'],null, ['id'=>'reminderTo','class' => 'form-control select2Selector','placeholder' => 'Select Reminder To','required']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('description',__('messages.reminder.description').':') }}<span
                                class="required">*</span>
                        {{ Form::textarea('description', null, ['class' => 'form-control summernote-simple', 'id' => 'reminderDescription']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="custom-switch pl-0">
                            <input type="checkbox" name="is_notified" value="1" class="custom-switch-input" checked="">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">{{ __('messages.reminder.send_email_reminder') }}</span>
                        </label>
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnCreateSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

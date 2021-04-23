<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.reminder.edit_reminder') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'editForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox"></div>
                {{ Form::hidden('reminderId',null,['id'=>'reminderId']) }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('notified_date',__('messages.reminder.notified_date').':') }}<span
                                class="required">*</span>
                        {{ Form::text('notified_date', null, ['class' => 'form-control','id' => 'editNotifiedDate','required','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('reminder_to', __('messages.reminder.reminder_to').':') }}<span
                                class="required">*</span>
                        {{ Form::select('reminder_to', $data['reminderTo'],null, ['id'=>'editReminderTo','class' => 'form-control select2Selector','placeholder' => 'Select Reminder To','required']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('description',__('messages.reminder.description').':') }}<span
                                class="required">*</span>
                        {{ Form::textarea('description', null, ['class' => 'form-control summernote-simple','id' => 'editReminderDescription']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('send_email_reminder',__('messages.reminder.send_email_reminder').':') }}<br>
                        <label class="custom-switch pl-0">
                            <input type="checkbox" name="is_notified" value="1" class="custom-switch-input"
                                   id="editIsNotified">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('edit',__('messages.common.status').':') }}<br>
                        <label class="custom-switch pl-0">
                            <input type="checkbox" name="status" value="1" class="custom-switch-input"
                                   id="editStatus">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnEditSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnEditCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

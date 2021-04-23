<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.announcement.edit_announcement') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'editForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox"></div>
                {{ Form::hidden('announcementId',null,['id'=>'announcementId']) }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('subject',__('messages.announcement.subject').':') }}<span
                                class="required">*</span>
                        {{ Form::text('subject', null, ['class' => 'form-control','required','id' => 'editSubject','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('date',__('messages.announcement.announcement_date').':') }}<span
                                class="required">*</span>
                        {{ Form::text('date',null,['class' => 'form-control','id' => 'editAnnouncementDate','required','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-12 mb-0">
                        {{ Form::label('message',__('messages.announcement.message').':') }}
                        {{ Form::textarea('message', null, ['class' => 'form-control summernote-simple','id' => 'editMessage']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('editShowToClients',__('messages.announcement.show_to_clients').':') }}<br>
                        <label class="custom-switch pl-0">
                            <input type="checkbox" name="show_to_clients" value="1" class="custom-switch-input"
                                   id="editShowToClients">
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
                <div class="text-right mt-4">
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

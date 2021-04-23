<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.announcement.new_announcement') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id'=>'addNewForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('subject',__('messages.announcement.subject').':') }}<span
                                class="required">*</span>
                        {{ Form::text('subject', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('date',__('messages.announcement.announcement_date').':') }}<span
                                class="required">*</span>
                        {{ Form::text('date',null,['class' => 'form-control','id' => 'announcementDate','required','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-12 mb-0">
                        {{ Form::label('message',__('messages.announcement.message').':') }}
                        {{ Form::textarea('message', null, ['class' => 'form-control summernote-simple', 'id' => 'createMessage']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('showToClients',__('messages.announcement.show_to_clients').':') }}<br>
                        <label class="custom-switch pl-0">
                            <input type="checkbox" name="show_to_clients" value="1" class="custom-switch-input"
                                   id="showToClients"
                                   checked="">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                </div>
                <div class="text-right mt-4">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

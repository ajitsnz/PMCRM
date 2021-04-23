<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.ticket_status.edit_ticket_status') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'editForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox"></div>
                {{ Form::hidden('ticketStatusId',null,['id'=>'ticketStatusId']) }}
                <div class="row">
                    <div class="form-group col-sm-10">
                        {{ Form::label('name',__('messages.ticket_status.name').':') }}<span class="required">*</span>
                        {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'editName', 'required','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-2">
                        {{ Form::label('pick_color', __('messages.lead_status.color').':') }}<span
                                class="required">*</span>
                        <div class="color-wrapper"></div>
                        {{ Form::text('pick_color', '', ['id' => 'edit_color', 'hidden', 'class' => 'form-control color']) }}
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

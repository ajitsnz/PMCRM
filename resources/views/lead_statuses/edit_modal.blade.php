<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.lead_status.edit_lead_status') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'editForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox"></div>
                {{ Form::hidden('leadStatusId',null,['id'=>'leadStatusId']) }}
                <div class="row">
                    <div class="form-group col-sm-10">
                        {{ Form::label('name',__('messages.lead_status.name').':') }}<span class="required">*</span>
                        {{ Form::text('name', null, ['class' => 'form-control','required','id' => 'editName','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-2">
                        {{ Form::label('color', __('messages.lead_status.color').':') }}<span class="required">*</span>
                        <div class="color-wrapper"></div>
                        {{ Form::text('color', '', ['id' => 'edit_color', 'hidden', 'class' => 'form-control color']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('order',__('messages.lead_status.order').':') }}<span class="required">*</span>
                        {{ Form::number('order', null, ['class' => 'form-control','required','id' => 'editOrder', 'min' => 0, 'max' => 100 ]) }}
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

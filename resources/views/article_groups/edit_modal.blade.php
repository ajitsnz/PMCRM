<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.article_group.edit_article_group') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'editForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox"></div>
                {{ Form::hidden('articleGroupId', null, ['id'=>'articleGroupId']) }}
                <div class="row">
                    <div class="form-group col-sm-10">
                        {{ Form::label('group_name', __('messages.article.group').':') }}<span
                                class="required">*</span>
                        {{ Form::text('group_name', null, ['class' => 'form-control','required','id' => 'editGroupName','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-2">
                        {{ Form::label('color', __('messages.lead_status.color').':') }}<span class="required">*</span>
                        <div class="color-wrapper"></div>
                        {{ Form::text('color', '', ['id' => 'edit_color', 'hidden', 'class' => 'form-control color']) }}
                    </div>
                    <div class="form-group col-sm-12 mb-0">
                        {{ Form::label('description', __('messages.common.description').':') }}
                        {{  Form::textarea('description', null, ['class' => 'form-control summernote-simple', 'id' => 'editDescription']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('order', __('messages.article_group.order').':') }}<span
                                class="required">*</span>
                        {{ Form::number('order', null, ['class' => 'form-control', 'id' => 'editOrder', 'min' => 0, 'max' => 100, 'required']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit', 'class' => 'btn btn-primary','id'=>'btnEditSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnEditCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

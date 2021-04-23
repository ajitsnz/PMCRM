<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.item.new_item') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id' => 'addNewForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('title', __('messages.item.title').':') }}<span class="required">*</span>
                        {{ Form::text('title', null, ['class' => 'form-control', 'required','autocomplete' => 'off']) }}
                    </div>
                    <div class="form-group col-sm-12 mb-0">
                        {{ Form::label('description', __('messages.common.description').':') }}
                        {{ Form::textarea('description', null, ['class' => 'form-control textarea-sizing', 'id' => 'itemDescription']) }}
                    </div>
                    <div class="form-group col-sm-12 col-lg-6 col-md-12">
                        {{ Form::label('rate ', __('messages.item.rate').':') }}<span class="required">*</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="{{getCurrencyClass()}}"></i>
                                </div>
                            </div>
                            {{ Form::text('rate', null, ['class' => 'form-control price-input', 'required','autocomplete' => 'off']) }}
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-lg-6 col-md-12">
                        {{ Form::label('item_group ', __('messages.item.item_group').':') }}<span
                                class="required">*</span>
                        {{ Form::select('item_group_id', $data['itemGroups'], null, ['class' => 'form-control select2Selector', 'id' => 'itemGroup', 'required','placeholder' => 'Select Product Group']) }}
                    </div>
                    <div class="form-group col-sm-12 col-lg-6 col-md-12">
                        {{ Form::label('tax_1 ', __('messages.item.tax').' 1:') }}
                        {{ Form::select('tax_1_id', $data['taxes'], null, ['class' => 'form-control', 'id' => 'taxSelectOne', 'placeholder' => 'Select Tax 1']) }}
                    </div>
                    <div class="form-group col-sm-12 col-lg-6 col-md-12">
                        {{ Form::label('tax_2 ', __('messages.item.tax').' 2:') }}
                        {{ Form::select('tax_2_id', $data['taxes'], null, ['class' => 'form-control', 'id' => 'taxSelectTwo', 'placeholder' => 'Select Tax 2']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div id="addPaymentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.payment.new_payment') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id' => 'addNewPaymentForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                {{ Form::hidden('owner_id', null, ['id' => 'paymentOwnerId']) }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('amount_received', __('messages.payment.amount_received').':') }}<span
                                class="required">*</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="{{ getCurrencyClass() }}"></i>
                                </div>
                            </div>
                            {{ Form::text('amount_received', null, ['class' => 'form-control price-input', 'required', 'id' => 'paymentAmount']) }}
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('payment_date', __('messages.payment.payment_date').':') }}<span
                                class="required">*</span>
                        {{ Form::text('payment_date', null, ['class' => 'form-control', 'required', 'id' => 'paymentDate']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('payment_mode', __('messages.payment.payment_mode').':') }}<span
                                class="required">*</span>
                        {{ Form::select('payment_mode', $paymentModes, null, ['class' => 'form-control', 'required', 'id' => 'paymentMode', 'placeholder' => 'Select Payment Mode']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('transaction_id', __('messages.payment.transaction_id').':') }}
                        {{ Form::text('transaction_id', null, ['class' => 'form-control', 'minLength' => '10', 'maxLength' => '30']) }}
                    </div>
                    <div class="form-group col-sm-12 mb-2">
                        {{ Form::label('note', __('messages.payment.note').':') }}
                        {{ Form::textarea('note', null, ['class' => 'form-control summernote-simple', 'id' => 'note']) }}
                    </div>
                    <div class="form-group col-sm-12 mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   id="customCheck"
                                   name="send_mail_to_customer_contacts" value="1">
                            <label class="custom-control-label"
                                   for="customCheck">{{__('messages.payment.send_mail_to_customer_contacts')}}</label>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-2">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnPaymentSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnPaymentCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

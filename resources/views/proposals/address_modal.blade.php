<div id="addModal" class="modal fade address-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <div class="row" id="addressForm">
                    <div class="form-group col-sm-12">
                        {{ Form::label('street',__('messages.address.street').':') }} <span class="required">*</span>
                        {{ Form::textarea('street', !empty($proposal->proposalAddresses[0]->street) ? nl2br(e($proposal->proposalAddresses[0]->street)) : null,     ['class' => 'form-control street billingShippingTextarea', 'id' => 'addressStreet', 'data-err-msg' => 'Billing Street field required']) }}
                    </div>
                    <div class="form-group col-sm-12 col-lg-6">
                        {{ Form::label('city',__('messages.address.city').':') }}
                        {{ Form::text('city', !empty($proposal->proposalAddresses[0]->city) ? $proposal->proposalAddresses[0]->city : null, ['class' => 'form-control city', 'id' => 'addressCity']) }}
                    </div>
                    <div class="form-group col-sm-12 col-lg-6">
                        {{ Form::label('state',__('messages.address.state').':') }}
                        {{ Form::text('state', !empty($proposal->proposalAddresses[0]->state) ? $proposal->proposalAddresses[0]->state : null, ['class' => 'form-control state', 'id' => 'addressState']) }}
                    </div>
                    <div class="form-group col-sm-12 col-lg-6">
                        {{ Form::label('zip_code',__('messages.address.zip_code').':') }}
                        {{ Form::text('zip_code', !empty($proposal->proposalAddresses[0]->zip_code) ? $proposal->proposalAddresses[0]->zip_code : null, ['class' => 'form-control zip-code','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'addressZipCode','maxLength' => '6','minLength' => '6']) }}
                    </div>
                    <div class="form-group col-sm-12 col-lg-6">
                        {{ Form::label('country',__('messages.address.country').':') }}
                        {{ Form::text('country',!empty($proposal->proposalAddresses[0]->country) ? $proposal->proposalAddresses[0]->country : null, ['class' => 'form-control country', 'id' => 'addressCountry']) }}
                    </div>
                </div>
                <br>
                <div class="text-right">
                    <button type="button" id="btnSaveAddress"
                            class="btn btn-primary ml-1">{{ __('messages.common.save') }}</button>
                    <button type="button" class="btn btn-secondary text-dark" id="btnCancel"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

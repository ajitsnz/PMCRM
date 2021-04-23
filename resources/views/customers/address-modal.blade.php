<div id="addModal" class="modal fade address-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.customer.add_address_details') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                {{ Form::open(['id'=>'addressForm']) }}
                <input type="hidden" id="customer_id" name="customer_id" value="{{$customer->id}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-header">
                            <h6 class="text-black-50 font-weight-bold">{{__('messages.customer.billing_address')}}</h6>
                        </div>
                        <br>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('street',__('messages.address.street').':') }}
                            {{ Form::text('street[1]', null ,['class' => 'form-control street billingShippingTextarea', 'id' => 'billingStreet']) }}
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('city',__('messages.address.city').':') }}
                            {{ Form::text('city[1]',  null , ['class' => 'form-control city', 'id' => 'billingCity']) }}
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('state',__('messages.address.state').':') }}
                            {{ Form::text('state[1]',  null , ['class' => 'form-control state', 'id' => 'billingState']) }}
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('zip_code',__('messages.address.zip_code').':') }}
                            {{ Form::text('zip[1]',  null , ['class' => 'form-control zip-code', 'id' => 'billingZip','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','maxLength' => '6','minLength' => '6']) }}
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('country',__('messages.address.country').':') }}
                            {{ Form::select('country[1]',$country,null, ['id'=>'billingCountryId','class' => 'form-control','placeholder' => 'Select Country']) }}
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="card-header">
                            <h6 class="text-black-50 font-weight-bold">{{__('messages.customer.shipping_address')}}
                                <a id="copyBillingAddress"
                                   class="text-black-50 text-decoration-none copy-billing-address-label">
                                    <input type="checkbox" id="shippingAddressCheck"
                                           class="mr-1">{{__('messages.customer.copy_billing_address')}}</a>
                            </h6>

                        </div>
                        <br>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('street',__('messages.address.street').':') }}
                            {{ Form::text('street[2]', null ,['class' => 'form-control street billingShippingTextarea', 'id' => 'shippingStreet']) }}
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('city',__('messages.address.city').':') }}
                            {{ Form::text('city[2]',  null , ['class' => 'form-control city', 'id' => 'shippingCity']) }}
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('state',__('messages.address.state').':') }}
                            {{ Form::text('state[2]',  null , ['class' => 'form-control state', 'id' => 'shippingState']) }}
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('zip_code',__('messages.address.zip_code').':') }}
                            {{ Form::text('zip[2]',  null , ['class' => 'form-control zip-code', 'id' => 'shippingZip','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','maxLength' => '6','minLength' => '6']) }}
                        </div>
                        <div class="form-group col-sm-12 col-lg-12">
                            {{ Form::label('country',__('messages.address.country').':') }}
                            {{ Form::select('country[2]',$country,(isset($customer->country) && $customer->country!=null)?$customer->country:null, ['id'=>'shippingCountryId','class' => 'form-control','placeholder' => 'Select Country']) }}
                        </div>

                    </div>
                </div>
                <hr>
                <div class="text-right">
                    <button type="submit" id="btnSaveAddress"
                            class="btn btn-primary ml-1">{{ __('messages.common.save') }}</button>
                    <button type="button" id="btnCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

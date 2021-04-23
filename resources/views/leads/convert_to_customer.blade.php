<div id="convertToCustomer" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.lead.convert_to_customer') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
            </div>
            {{ Form::open(['id' => 'leadConvertToCustomerForm']) }}
            <div class="modal-body">
                <input type="hidden" name="lead_id" id="leadId" value="{{ $lead->id }}">
                <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        {{ Form::label('company_name', __('messages.customer.company_name').':') }}<span
                                class="required">*</span>
                        {{ Form::text('company_name', null, ['class' => 'form-control','required', 'id'=>'companyName']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('website', __('messages.customer.website').':') }}
                        {{ Form::url('website', null, ['class' => 'form-control', 'id' => 'convertWebsite']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('default_language', __('messages.customer.default_language').':') }}
                        {{ Form::select('default_language', $data['languages'],null, ['id'=>'convertLanguageId','class' => 'form-control','placeholder' => 'Select Language']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('country', __('messages.customer.country').':') }}
                        {{ Form::select('country', $data['countries'], null, ['id'=>'convertCountryId','class' => 'form-control','placeholder' => 'Select Country']) }}
                    </div>
                    <div class="form-group col-sm-12">
                        {{ Form::label('groups', __('messages.customer.groups').':') }}
                        {{ Form::select('groups[]', $data['customerGroups'], null, ['id'=>'convertGroupId','class' => 'form-control', 'multiple' => 'multiple']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('email', __('messages.user.email').':') }}<span class="required">*</span>
                        {{ Form::text('email', null, ['id' => 'emailId','class' => 'form-control','required']) }}
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('password', __('messages.user.password').':') }}<span class="required">*</span>
                        <input type="password" name="password" required class="form-control" autocomplete="off"
                               minLength="6" maxLength="10">
                    </div>
                </div>
                <div class="text-right mt-2">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnConvertLeadToCustomer','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

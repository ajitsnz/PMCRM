<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group col-sm-12">
            {{ Form::label('name', __('messages.lead.name').':') }}<span class="required">*</span>
            {{ Form::text('name', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('company_name', __('Company Name').':') }}<span class="required">*</span>
            {{ Form::text('company_name', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('status', __('messages.common.status').':') }}<span class="required">*</span>
            {{ Form::select('status_id', $data['status'],null, ['id'=>'statusId','class' => 'form-control','placeholder' => 'Select Status','required']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('assigned', __('messages.lead.member').':') }}
            {{ Form::select('assign_to', $data['assigned'],null, ['id'=>'memberId','class' => 'form-control','placeholder' => 'Select Member']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('website', __('messages.customer.website').':') }}
            {{ Form::text('website', null, ['class' => 'form-control','id' => 'website','autocomplete' => 'off']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('tags', __('messages.tags').':') }}
            {{ Form::select('tags[]', $data['tags'],isset($lead->tags)?$lead->tags:null, ['id'=>'tagId','class' => 'form-control','multiple']) }}
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group col-sm-12">
            {{ Form::label('source', __('messages.lead.source').':') }}<span class="required">*</span>
            {{ Form::select('source_id', $data['sources'],null, ['id'=>'sourceId','class' => 'form-control','placeholder' => 'Select Source','required']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('position', __('messages.contact.position').':') }}
            {{ Form::text('position', null, ['class' => 'form-control','autocomplete' => 'off']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('estimate_budget', __('messages.lead.estimate_budget').':') }}
            {{ Form::text('estimate_budget', null, ['class' => 'form-control price-input','autocomplete' => 'off']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('phone',__('messages.customer.phone').':') }}<br>
            {{ Form::tel('phone', null, ['class' => 'form-control','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
            {{ Form::hidden('prefix_code',old('prefix_code'),['id'=>'prefix_code']) }}
            <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
            <span id="error-msg" class="hide"></span>

        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('country', __('messages.customer.country').':') }}
            {{ Form::select('country', $data['countries'],(isset($lead->address) && $lead->address->country!=null)?$lead->address->country:null, ['id'=>'countryId','class' => 'form-control','placeholder' => 'Select Country']) }}
        </div>
        <div class="form-group col-sm-12">
            {{ Form::label('default_language', __('messages.customer.default_language').':') }}
            {{ Form::select('default_language', $data['languages'],null, ['id'=>'languageId','class' => 'form-control','placeholder' => 'Select Language']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group col-sm-12">
            {{ Form::label('description', __('messages.common.description').':') }}
            {{ Form::textarea('description', null, ['class' => 'form-control','id' => 'leadDescription']) }}
        </div>
    </div>
</div>
<div class="row ml-2">
    <div class="form-group col-sm-12 display-none" id="contactForm">
        {{ Form::label('date_contacted', __('messages.lead.date_contacted').':') }}
        {{ Form::text('date_contacted',null, ['id'=>'contactDateId','class' => 'form-control','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-2">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="check"
                   name="public" value="1" {{ (isset($lead) && ($lead->public)) ? 'checked' : '' }}>
            <label class="custom-control-label"
                   for="check">{{__('messages.task.public') }}</label>
        </div>
    </div>
    <div class="form-group col-sm-3">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="checkContact"
                   name="contacted_today" value="1"
                    {{isset($lead) ? (isset($lead->contacted_today) ? 'checked' : '' ) : 'checked'}}>
            <label class="custom-control-label"
                   for="checkContact">{{__('messages.lead.contacted_today') }}</label>
        </div>
    </div>
</div>
<div class="row ml-2">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ url()->previous() }}" class="btn btn-secondary text-dark">{{__('messages.common.cancel')}}</a>
    </div>
</div>

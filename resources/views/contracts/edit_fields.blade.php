<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('subject', __('messages.contract.subject').':') }}<span class="required">*</span>
        {{ Form::text('subject', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('contract_type_id', __('messages.contract.contract_type_id').':') }}<span
                class="required">*</span>
        {{ Form::select('contract_type_id',$contractType, null, ['class' => 'form-control','required','id' => 'contractTypeId','placeholder' => 'Select Contract Type']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('customer_id', __('messages.contract.customer_id').':') }}<span class="required">*</span>
        {{ Form::select('customer_id',$customer, null, ['class' => 'form-control','required','id' => 'customer','placeholder' => 'Select Customer']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('contract_value', __('messages.contract.contract_value').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="{{ getCurrencyClass() }}"></i>
                </div>
            </div>
            {{ Form::text('contract_value', null, ['class' => 'form-control price-input','autocomplete' => 'off']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12 col-lg-6 col-md-12">
        {{ Form::label('start_date', __('messages.contract.start_date').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('start_date', isset($contract->start_date) ? date('Y-m-d H:i:s', strtotime($contract->start_date)) : null, ['class' => 'form-control startDate','autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="form-group col-sm-12 col-lg-6 col-md-12">
        {{ Form::label('end_date', __('messages.contract.end_date').':') }}
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            {{ Form::text('end_date', isset($contract->end_date) ? date('Y-m-d H:i:s', strtotime($contract->end_date)) : null, ['class' => 'form-control endDate','autocomplete' => 'off']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12 mb-0">
        {{ Form::label('description',__('messages.contract.description').':') }}
        {{ Form::textarea('description', null, ['class' => 'form-control summernote-simple', 'id' => 'contractDescription']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ route('contracts.index') }}"
           class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>


<div class="row">
    {{ Form::hidden('url',url()->previous()) }}
    <div class="form-group col-sm-6">
        {{ Form::label('first_name', __('messages.contact.first_name').':') }}
        <span class="required">*</span>
        {{ Form::text('first_name', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('last_name', __('messages.contact.last_name').':') }}
        {{ Form::text('last_name', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('customer_name', __('messages.contact.customer_name').':') }}
        <span class="required">*</span>
        {{ Form::select('customer_id', $customers, isset($customerId) ? $customerId : null, ['id'=>'customerId','class' => 'form-control','placeholder' => 'Select Customer','required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('position', __('messages.contact.position').':') }}
        {{ Form::text('position', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('email', __('messages.common.email').':') }}
        <span class="required">*</span>
        {{ Form::text('email', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('phone', __('messages.customer.phone').(':')) }}<br>
        {{ Form::tel('phone', null, ['class' => 'form-control','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
        {{ Form::hidden('prefix_code',old('prefix_code'),['id'=>'prefix_code']) }}
        <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
        <span id="error-msg" class="hide"></span>
    </div>
</div>
<div class="row">
    @if(!isset($contact))
        <div class="form-group col-sm-3">
            {{ Form::label('password', __('messages.contact.password').':') }}<span class="required">*</span>
            <div class="input-group">
                {{ Form::password('password', ['class' => 'form-control','id'=>'password','autocomplete' => 'off','required','min' => '6','max' => '10']) }}
                <div class="input-group-append" id="show_hide_password">
                    <div class="input-group-text">
                        <button class="btn btn-default password-show" type="button"><i class="fa fa-eye-slash"
                                                                                       aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-sm-3">
            {{ Form::label('password', __('messages.member.password_confirmation').':') }}<span
                    class="required">*</span>
            <div class="input-group">
                {{ Form::password('password_confirmation', ['class' => 'form-control','id'=>'cPassword','required','min' => '6','max' => '10','autocomplete' => 'off']) }}
                <div class="input-group-append" id="show_hide_cPassword">
                    <div class="input-group-text">
                        <button class="btn btn-default cPassword-show" type="button"><i class="fa fa-eye-slash"
                                                                                        aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="form-group col-lg-3 col-md-6 col-sm-12">
        <span id="validationErrorsBox" class="text-danger"></span>
        <div class="row no-gutters">
            <div class="col-6"> {{ Form::label('image', __('messages.user.profile').':',['class' => 'profile-label-color']) }}
                <label class="image__file-upload"> {{ __('messages.setting.choose') }}
                    {{ Form::file('image',['id'=>'profileImage','class' => 'd-none']) }}
                </label></div>
            <div class="col-2">
                <div class="col-sm-4 preview-image-video-container pl-0 mt-1">
                    <img id='previewImage' class="img-thumbnail thumbnail-preview tPreview"
                         src="{{ asset('assets/img/infyom-logo.png') }}"/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="check"
                   name="primary_contact" value="1">
            <label class="custom-control-label"
                   for="check">{{__('messages.contact.primary_contact') }}</label>
        </div>
    </div>
    <div class="form-group col-sm-4">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="check1"
                   name="send_welcome_email" value="1">
            <label class="custom-control-label"
                   for="check1">{{__('messages.contact.send_welcome_email') }}</label>
        </div>
    </div>
    <div class="form-group col-sm-4">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="check2"
                   name="send_password_email" value="1">
            <label class="custom-control-label"
                   for="check2">{{__('messages.contact.send_password_email') }}</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        {{ Form::label('permissions', __('messages.contact.permissions').':',['class' => 'section-title']) }}<br>
        <span class="required">{{__('messages.contact.make_sure_to_set_appropriate_permissions_for_this_contact')}}</span>
    </div>
</div>
<div class="row">
    @foreach($permissions as $id => $name)
        <div class="form-group col-sm-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input"
                       id="customCheck{{$id}}"
                       name="permissions[]" value="{{$id}}">
                <label class="custom-control-label"
                       for="customCheck{{$id}}">{{ Illuminate\Support\Str::title(str_replace('_',' ',$name)) }}</label>
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type' => 'submit','id' => 'btnSave','class' => 'btn btn-primary','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ url()->previous() }}" class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

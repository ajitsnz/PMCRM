<div class="row">
    {{ Form::hidden('url',url()->previous()) }}
    <div class="form-group col-sm-6">
        {{ Form::label('first_name', __('messages.contact.first_name').':') }}
        <span class="required">*</span>
        {{ Form::text('first_name', $contact->user->first_name, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('last_name', __('messages.contact.last_name').':') }}
        {{ Form::text('last_name', $contact->user->last_name, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('customer_name', __('messages.contact.customer_name').':') }}
        <span class="required">*</span>
        {{ Form::select('customer_id', $customers,null, ['id'=>'customerId','class' => 'form-control','placeholder' => 'Select Customer','required']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('position', __('messages.contact.position').':') }}
        {{ Form::text('position',null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('email', __('messages.common.email').':') }}
        <span class="required">*</span>
        {{ Form::text('email', $contact->user->email, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('phone', __('messages.customer.phone').(':')) }}<br>
        {{ Form::tel('phone', $contact->user->phone, ['class' => 'form-control','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
        {{ Form::hidden('prefix_code',old('prefix_code'),['id'=>'prefix_code']) }}
        <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
        <span id="error-msg" class="hide"></span>
    </div>
</div>
<div class="row">
    <div class="form-group col-lg-3 col-md-6 col-sm-12">
        <span id="validationErrorsBox" class="text-danger"></span>
        <div class="row no-gutters">
            <div class="col-6"> {{ Form::label('image', __('messages.user.profile').':',['class' => 'profile-label-color']) }}
                <label class="image__file-upload"> {{ __('messages.setting.choose') }}
                    {{ Form::file('image',['id'=>'profileImage','class' => 'd-none']) }}
                </label></div>
            <div class="col-2">
                <div class="col-sm-4 preview-image-video-container pl-0 mt-1">
                    <img id='previewImage' class="img-thumbnail thumbnail-preview"
                         src="{{!empty($contact->user->image) ? $contact->user->media[0]->getFullUrl() : asset('assets/img/infyom-logo.png') }}"/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @if(empty($contact->primary_contact))
        <div class="form-group col-sm-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input"
                       id="check"
                       name="primary_contact" value="1"
                        {{$contact->primary_contact == 1? 'checked' : ''}}>
                <label class="custom-control-label"
                       for="check">{{__('messages.contact.primary_contact') }}</label>
            </div>
        </div>
    @endif
    <div class="form-group col-sm-4">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="check1"
                   name="send_welcome_email" value="1"
                    {{$contact->send_welcome_email == 1 ? 'checked' : ''}}>
            <label class="custom-control-label"
                   for="check1">{{__('messages.contact.send_welcome_email') }}</label>
        </div>
    </div>
    <div class="form-group col-sm-4">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="check2"
                   name="send_password_email" value="1"
                    {{$contact->send_password_email == 1? 'checked' : ''}}>
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
                       name="permissions[]" value="{{$id}}"
                        {{in_array($id, $contactPermissions) ? 'checked' : ''}}>
                <label class="custom-control-label"
                       for="customCheck{{$id}}">{{ Illuminate\Support\Str::title(str_replace('_',' ',$name)) }}</label>
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {{ Form::submit(__('messages.common.save'), ['id' => 'btnSave','class' => 'btn btn-primary']) }}
        <a href="{{ url()->previous() }}" class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

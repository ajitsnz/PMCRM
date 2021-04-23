<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('first_name', __('messages.member.first_name').':') }}<span class="required">*</span>
        {{ Form::text('first_name', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('last_name', __('messages.member.last_name').':') }}
        {{ Form::text('last_name', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('email', __('messages.common.email').':') }}<span class="required">*</span>
        {{ Form::email('email', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('phone', __('messages.member.phone').(':')) }}<span class="required">*</span><br>
        {{ Form::tel('phone', null, ['class' => 'form-control','required','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
        {{ Form::hidden('prefix_code',old('prefix_code'),['id'=>'prefix_code']) }}
        <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
        <span id="error-msg" class="hide"></span>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('facebook', __('messages.member.facebook').':') }}
        {{ Form::text('facebook', null, ['class' => 'form-control','id' => 'facebookUrl','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('linkedin', __('messages.member.linkedin').':') }}
        {{ Form::text('linkedin', null, ['class' => 'form-control','id' => 'linkedInUrl','autocomplete' => 'off']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('skype', __('messages.member.skype').':') }}
        {{ Form::text('skype', null, ['class' => 'form-control','id' => 'skypeUrl','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-6">
        {{ Form::label('default_language', __('messages.member.default_language').':') }}
        {{ Form::select('default_language', $data['languages'],null, ['id'=>'languageId','class' => 'form-control','placeholder' => 'Select Language']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('member_security', __('messages.member.member_security').':') }}
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="isEditStaffMember"
                   name="staff_member" value="1"
                    {{$member->staff_member == 1? 'checked' : ''}}>
            <label class="custom-control-label"
                   for="isEditStaffMember">{{ __('messages.member.staff_member') }}</label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   id="isEditSendWelcomeEmail"
                   name="send_welcome_email" value="1"
                    {{$member->send_welcome_email == 1? 'checked' : ''}}>
            <label class="custom-control-label"
                   for="isEditSendWelcomeEmail"> {{ __('messages.member.send_welcome_email') }}</label>
        </div>
    </div>
    <div class="form-group col-lg-3 col-md-6 col-sm-12">
        <span id="validationErrorsBox" class="text-danger"></span>
        <div class="row">
            <div class="col-6">
                {{ Form::label('logo', __('messages.member.profile').':',['class' => 'profile-label-color']) }}
                <label class="image__file-upload text-white"> {{ __('messages.setting.choose') }}
                    {{ Form::file('image',['id'=>'logo','class' => 'd-none']) }}
                </label>
            </div>
            <div class="col-2 pl-0 mt-1">
                <img id='logoPreview' class="img-thumbnail thumbnail-preview"
                     src="{{ (count($member->media) > 0) ? $member->image_url : asset('assets/img/infyom-logo.png')}}">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        {{ Form::label('permissions',__('messages.member.permissions').':',['class' => 'section-title']) }}
    </div>
</div>
<div class="row">
    @foreach($permissionsArr as $type => $permissions)
        <div class="col-md-6 col-lg-4 col-xl-3 col-sm-4 permission-text">
            <div class="card-body">
                <div class="section-title mt-0">{{$type}}</div>
                @foreach($permissions as $permission)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input"
                               id="customCheck{{$permission['id']}}"
                               name="permissions[]" value="{{$permission['id']}}"
                                {{in_array($permission['id'], $memberPermissions) ? 'checked' : ''}}>
                        <label class="custom-control-label"
                               for="customCheck{{$permission['id']}}">
                            {{$permission['display_name']}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ route('members.index') }}"
           class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-sm-6">
            <h2 class="section-title">{{ $user->full_name }}</h2>
            <p class="section-lead">
                {{__('messages.change_password.change_information_about_yourself_on_this_page')}}
            </p>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="card author-box card-primary">
            <div class="card-body">
                <div class="author-box-left">
                    <img alt="InfyOm" src="{{getLoggedInUser()->image_url??'' }}"
                         class="rounded-circle author-box-picture userProfileAvatar">
                    <div class="clearfix"></div>
                </div>
                <div class="author-box-details">
                    <div class="author-box-name mt-2">
                        <span class="font-weight-bold">{{ html_entity_decode($user->full_name) }}</span>
                    </div>
                    @if($user->facebook != null)
                        <a href="{{ $user->facebook }}" class="btn btn-social-icon facebook-color mr-2" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if($user->skype != null)
                        <a href="{{ $user->skype }}" class="btn btn-social-icon skype-color mr-2" target="_blank">
                            <i class="fab fa-skype"></i>
                        </a>
                    @endif
                    @if($user->linkedin != null)
                        <a href="{{ $user->linkedin }}" class="btn btn-social-icon linkedin-color mr-2" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="card">
            <form method="post" class="needs-validation" novalidate="">
                <div class="card-header">
                    <h4>{{__('messages.change_password.edit_profile')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            {{ Form::label('first_name', __('messages.member.first_name').':') }}<span
                                    class="required">*</span>
                            {{ Form::text('first_name', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
                        </div>
                        <div class="form-group col-md-6 col-12">
                            {{ Form::label('last_name', __('messages.member.last_name').':') }}
                            {{ Form::text('last_name', null, ['class' => 'form-control','autocomplete' => 'off']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            {{ Form::label('email', __('messages.common.email').':') }}<span
                                    class="required">*</span>
                            {{ Form::email('email', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
                        </div>
                        <div class="form-group col-md-6 col-12">
                            {{ Form::label('phone', __('messages.customer.phone').(':')) }}<br>
                            {{ Form::tel('phone', null, ['class' => 'form-control','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"",)']) }}
                            {{ Form::hidden('prefix_code',old('prefix_code'),['id'=>'prefix_code']) }}
                            <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
                            <span id="error-msg" class="hide"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            {{ Form::label('facebook', __('messages.member.facebook').':') }}
                            {{ Form::text('facebook', null, ['class' => 'form-control', 'id' => 'facebookUrl','autocomplete' => 'off']) }}
                        </div>
                        <div class="form-group col-sm-6">
                            {{ Form::label('linkedin', __('messages.member.linkedin').':') }}
                            {{ Form::text('linkedin', null, ['class' => 'form-control', 'id' => 'linkedInUrl','autocomplete' => 'off']) }}
                            </div>
                        </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            {{ Form::label('skype', __('messages.member.skype').':') }}
                            {{ Form::text('skype', null, ['class' => 'form-control', 'id' => 'skypeUrl','autocomplete' => 'off']) }}
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-3">
                            <span id="validationErrorBox" class="text-danger"></span>
                            <div class="row no-gutters">
                                <div class="col-6"> {{ Form::label('image', __('messages.user.profile').':',['class' => 'profile-label-color']) }}
                                    <label class="image__file-upload"> {{ __('messages.setting.choose') }}
                                        {{ Form::file('image',['id'=>'profileImage','class' => 'd-none']) }}
                                    </label></div>
                                <div class="col-2">
                                    <div class="col-sm-4 preview-image-video-container pl-0 mt-1">
                                        <img id='previewImage' class="img-thumbnail thumbnail-preview"
                                             src="{{ getLoggedInUser()->image_url??'' }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    {{ Form::submit(__('messages.common.save'), ['id'=> 'btnSave', 'class' => 'btn btn-primary']) }}
                    <a href="{{ route('dashboard') }}"
                       class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

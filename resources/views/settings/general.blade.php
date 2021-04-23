<div class="row">
    <input type="hidden" name="group" value="{{\App\Models\Setting::GROUP_GENERAL}}">
    <div class="form-group col-sm-6">
        {{ Form::label('company_name', __('messages.setting.application_name').':') }}<span
                class="required">*</span>
        {{ Form::text('company_name', $settings['company_name'], ['class' => 'form-control', 'required']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12 col-lg-12 col-sm-12">
        {{ Form::label('term_and_conditions',__('messages.common.term_and_conditions').':') }}
        {{ Form::textarea('term_and_conditions',$settings['term_and_conditions'],['class' => 'form-control summernote-simple']) }}
    </div>
</div>
<div class="row">
    <!-- Logo Field -->
    <div class="form-group col-md-6 col-sm-12">
        <div class="row">
            <div class="col-6">
                <label class="profile-label-color-upload profile-label-color">{{ __('messages.setting.logo').':' }}<span
                            class="required">*</span></label>
                <label class="image__file-upload"> {{ __('messages.setting.choose') }}
                    {{ Form::file('logo',['id'=>'logo','class' => 'd-none']) }}
                </label>
            </div>
            <div class="col-2 preview-image-video-container pl-0 mt-1">
                <img id='logoPreview' class="img-thumbnail thumbnail-preview tPreview"
                     src="{{($settings['logo']) ?$settings['logo'] : asset('assets/img/infyom-logo.png')}}">
            </div>
        </div>
    </div>
    <div class="form-group col-md-6 col-sm-12">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5 col-7">
                {{ Form::label('favicon', __('messages.setting.favicon').':',['class' => 'profile-label-color']) }}<span
                        class="required">*</span>
                <label class="image__file-upload"> {{ __('messages.setting.choose') }}
                    {{ Form::file('favicon',['id'=>'favicon','class' => 'd-none']) }}
                </label>
            </div>
            <div class="col-2 preview-image-video-container pl-0 mt-1">
                <img id='faviconPreview' class="img-thumbnail thumbnail-preview tPreview faviconPreview"
                     src="{{($settings['favicon']) ?$settings['favicon'] : asset('assets/img/infyom-logo.png')}}">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary']) }}
    </div>
</div>

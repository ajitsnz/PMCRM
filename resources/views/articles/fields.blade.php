<div class="row">
    <div class="form-group col-sm-3">
        {{ Form::label('subject', __('messages.article.subject').':') }}<span class="required">*</span>
        {{ Form::text('subject', null, ['class' => 'form-control','required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('group_id', __('messages.article.group').':') }}<span class="required">*</span>
        {{ Form::select('group_id',$articleGroups, null, ['class' => 'form-control','required','id' => 'groupId','placeholder'=>'Select Group']) }}
    </div>
    <div class="form-group col-6 col-sm-3">
        <div class="control-label">{{ __('messages.article.internal_article').':' }}</div>
        <label class="custom-switch mt-2 pl-0">
            <input type="checkbox" name="internal_article" class="custom-switch-input" checked>
            <span class="custom-switch-indicator"></span>
        </label>
    </div>
    <div class="form-group col-6 col-sm-3">
        <div class="control-label">{{ __('messages.common.status').':' }}</div>
        <label class="custom-switch mt-2 pl-0">
            <input type="checkbox" name="disabled" class="custom-switch-input" checked>
            <span class="custom-switch-indicator"></span>
        </label>
    </div>
    <div class="form-group col-sm-12 mb-0">
        {{ Form::label('description',__('messages.article.description').':') }}
        {{ Form::textarea('description', null, ['class' => 'form-control summernote-simple', 'id' => 'articleDescription']) }}
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <div class="row no-gutters">
            <div class="col-6">
                {{ Form::label('image', __('messages.article.attachment').':',['class' => 'profile-label-color']) }}
                <label class="image__file-upload"> {{ __('messages.setting.choose') }}
                    {{ Form::file('image',['id'=>'attachment','class' => 'd-none','accept' => '.png,.jpg,.jpeg']) }}
                </label>
            </div>
            <div class="col-2">
                <div class="col-sm-4 pl-0 mt-1">
                    <img id='previewImage' class="img-thumbnail thumbnail-preview tPreview"
                         src="{{ asset('img/article/default-img.jpg') }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ route('articles.index') }}"
           class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

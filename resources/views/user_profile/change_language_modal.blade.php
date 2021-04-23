<div id="changeLanguageModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content left-margin">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.user.change_language') }}</h5>
                <button type="button" aria-label="Close" class="close" data-dismiss="modal">×</button>
                {{ csrf_field() }}
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="changeLanguageValidationErrorsBox"></div>
                {{ Form::open(['id' => 'changeLanguageForm']) }}
                <div class="row">
                    <div class="form-group col-12">
                        {{ Form::label('default_language',__('messages.user.language') .':') }}<span
                                class="required">*</span>
                        {{ Form::select('default_language',\App\Models\User::LANGUAGES,getLoggedInUser()->default_language,['id' => 'defaultLanguage', 'class' => 'form-control','required']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'),['type' => 'submit','class' => 'btn btn-primary mr-2', 'id' => 'btnLanguageChange', 
'data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing ..."]) }}
                    <button type="button" class="btn btn-light left-margin"
                            data-dismiss="modal">{{ __('messages.common.cancel') }} </button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

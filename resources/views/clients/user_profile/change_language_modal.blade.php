<div id="changeLanguageModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.user.change_language') }}</h5>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal">x</button>
                {{ csrf_field() }}
            </div>
            <div class="modal-body">
                <div id="alert alert-danger d-none" class="changeLanguageValidationErrorsBox"></div>
                {{ Form::open(['id' => 'changeLanguageForm']) }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        {{ Form::label('default_language',__('messages.user.language').':') }}<span
                                class="required">*</span>
                        {{ Form::select('default_language',\App\Models\User::LANGUAGES,getLoggedInUser()->default_language,['id' => 'defaultLanguage', 'class' => 'form-control', 'required']) }}
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'),['type' => 'submit', 'class' => 'btn btn-primary mr-2', 'id' => 'btnLanguageChange', 'data-loading-text' => "<span class='spinner-border spinner-border-sm'></span>  Processing ..."]) }}
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

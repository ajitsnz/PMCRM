<div class="modal fade" tabindex="-1" role="dialog" id="changePasswordModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.user.change_password') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'changePasswordForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editValidationErrorsBox"></div>
                <div class="form-group col-sm-12">
                    {{ Form::label('current password', __('messages.change_password.current_password').':') }}<span
                            class="required">*</span>
                    <div class="input-group">
                        <input class="form-control input-group__addon" id="pfCurrentPassword" type="password"
                               name="password_current" required>
                        <div class="input-group-append input-group__icon">
                            <span class="input-group-text changeType">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    {{ Form::label('password', __('messages.change_password.new_password').':') }}<span
                            class="required">*</span>
                    <div class="input-group">
                        <input class="form-control input-group__addon" id="pfNewPassword" type="password"
                               name="password" required>
                        <div class="input-group-append input-group__icon">
                            <span class="input-group-text changeType">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    {{ Form::label('password_confirmation', __('messages.change_password.confirm_password').':') }}<span
                            class="required">*</span>
                    <div class="input-group">
                        <input class="form-control input-group__addon" id="pfNewConfirmPassword" type="password"
                               name="password_confirmation" required>
                        <div class="input-group-append input-group__icon">
                            <span class="input-group-text changeType">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary','id'=>'btnEditSavePassword','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" id="btnEditCancel" class="btn btn-light ml-1"
                            data-dismiss="modal">{{ __('messages.common.cancel') }}
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

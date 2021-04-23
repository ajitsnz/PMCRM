<div class="modal fade" tabindex="-1" role="dialog" id="showModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.payment_mode.payment_mode_details') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row details-page">
                    <div class="form-group col-sm-12">
                        {{ Form::label('name',__('messages.common.name').':') }}<br>
                        <span id="showName"></span>
                    </div>
                    <div class="form-group col-sm-12 faqs-description">
                        {{ Form::label('description',__('messages.common.description').':') }}<br>
                        <span id="showDescription"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

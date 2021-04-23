<div class="row">
    <div class="form-group col-sm-3">
        {{ Form::label('subject', __('messages.ticket.subject').':') }}<span class="required">*</span>
        {{ Form::text('subject', null, ['class' => 'form-control', 'required','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-3" id="contactCol">
        {{ Form::label('contact_id', __('messages.ticket.contact').':') }}
        {{ Form::select('contact_id', $data['contacts'],null, ['id'=>'contactId','class' => 'form-control','placeholder' => 'Select Contact']) }}
    </div>
    <div class="form-group col-sm-3 d-none" id="nameCol">
        {{ Form::label('name', __('messages.ticket.name').':') }}
        {{ Form::text('name', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('email', __('messages.ticket.email').':') }}
        {{ Form::email('email', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('department_id', __('messages.ticket.department').':') }}
        {{ Form::select('department_id', $data['departments'],null, ['id'=>'departmentId','class' => 'form-control','placeholder' => 'Select Department']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('cc', __('messages.ticket.cc').':') }}
        {{ Form::email('cc', null, ['class' => 'form-control','autocomplete' => 'off']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('assign_to', __('messages.ticket.assign_to').':') }}
        {{ Form::select('assign_to', $data['assignTo'],null, ['id'=>'assignToId','class' => 'form-control','placeholder' => 'Select Member']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('priority_id', __('messages.ticket.priority').':') }}
        {{ Form::select('priority_id', $data['priority'],null, ['id'=>'priorityId','class' => 'form-control','placeholder' => 'Select Priority']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('service_id', __('messages.ticket.service').':') }}
        {{ Form::select('service_id', $data['services'],null, ['id'=>'serviceId','class' => 'form-control','placeholder' => 'Select Service']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('tags', __('messages.ticket.tags').':') }}
        {{ Form::select('tags[]', $data['tags'],null, ['id'=>'tagId','class' => 'form-control', 'multiple' => 'multiple']) }}
    </div>
    <div class="form-group col-sm-3">
        {{ Form::label('ticket_status_id', __('messages.common.status').':') }}<span class="required">*</span>
        {{ Form::select('ticket_status_id', $data['ticketStatus'],null, ['id'=>'ticketStatusId','class' => 'form-control','required','placeholder' => 'Select Status']) }}
    </div>
    <div class="form-group col-md-3">
        {{ Form::label('predefined_reply_id', __('messages.ticket.predefined_reply').':') }}
        {{ Form::select('predefined_reply_id', $data['predefinedReplies'],null, ['id'=>'predefinedReplyId','class' => 'form-control','placeholder' => 'Select Predefined Reply']) }}
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('body', __('messages.common.description').':') }}
        {{ Form::textarea('body', null, ['class' => 'form-control ticketBody', 'id' => 'ticketBody']) }}
    </div>
    <div class="form-group col-sm-12 col-md-12 col-xl-12">
        {{ Form::label('attachments', __('messages.ticket.attachments').':',['class' => 'profile-label-color']) }} <span
                data-toggle="tooltip" data-title="You can add multiples images and files"><i
                    class="fas fa-question-circle"></i></span>
        <div class="d-flex mb-3">
            <label class="image__file-upload text-white mb-4"> {{ __('messages.setting.choose') }}
                {{ Form::file('attachments[]',['id'=>'attachment','class' => 'd-none', 'multiple']) }}
            </label>
            <div id="attachmentFileSection" class="attachment__create"></div>
            @if(count($ticket->media) > 0)
                <div class="col-xl-12 col-sm-12 col-lg-12 pl-0">
                    <div class="gallery gallery-md">
                        @foreach($ticket->media as $media)
                            <div class="gallery-item ticket-attachment"
                                 data-image="{{ mediaUrlEndsWith($media->getFullUrl()) }}"
                                 data-title="{{ $media->name }}"
                                 href="{{ mediaUrlEndsWith($media->getFullUrl()) }}" title="{{ $media->name }}">
                                <div class="ticket-attachment__icon d-none">
                                    <a href="{{ $media->getFullUrl() }}" target="_blank"
                                       class="text-decoration-none text-primary" data-toggle="tooltip"
                                       data-placement="top"
                                       title="{{ __('messages.common.view') }}"><i class="fas fa-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                       class="text-danger text-decoration-none attachment-delete"
                                       data-id="{{ $media->id }}" data-toggle="tooltip" data-placement="top"
                                       title="{{ __('messages.common.delete') }}"><i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-12">
        {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
        <a href="{{ url()->previous() }}"
           class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

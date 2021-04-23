@extends('tickets.show')
@section('section')
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('subject', __('messages.ticket.subject').':') }}
                <p>{{ html_entity_decode($ticket->subject) }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('contact_id', __('messages.ticket.contact').':') }}
                <p>
                    @if(isset($ticket->contact_id))
                        <a href="{{ route('contacts.show',$ticket->contact_id) }}"
                           class="anchor-underline">{{ html_entity_decode($ticket->contact->user->full_name) }}</a>
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('name', __('messages.ticket.name').':') }}
                <p>{{ !empty($ticket->name) ? html_entity_decode($ticket->name) : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('email', __('messages.ticket.email').':') }}
                <p>{{ (!empty($ticket->email)) ? $ticket->email : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('department_id', __('messages.ticket.department').':') }}
                <p>{{ (isset($ticket->department_id)) ? html_entity_decode($ticket->department->name) : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('cc', __('messages.ticket.cc').':') }}
                <p>{{ (!empty($ticket->cc)) ? $ticket->cc : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('assign_to', __('messages.ticket.assign_to').':') }}
                <p>
                    @if(isset($ticket->assign_to))
                        <a href="{{ url('admin/members',$ticket->assign_to) }}"
                           class="anchor-underline">{{ html_entity_decode($ticket->user->full_name) }}</a>
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('priority_id', __('messages.ticket.priority').':') }}
                <p>{{ (isset($ticket->priority_id)) ? html_entity_decode($ticket->ticketPriority->name) : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('service_id', __('messages.ticket.service').':') }}
                <p>{{ (isset($ticket->service_id)) ? html_entity_decode($ticket->service->name) : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('tag_id', __('messages.ticket.tags').':') }}<br>
                @forelse($ticket->tags as $ticketTag)
                    <span class="badge border border-secondary">{{ html_entity_decode($ticketTag->name) }}</span>
                @empty
                    <p>{{ __('messages.common.n/a') }}</p>
                @endforelse
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('predefined_reply_id', __('messages.ticket.predefined_reply').':') }}
                <p>{{ (isset($ticket->predefined_reply_id)) ? html_entity_decode($ticket->predefinedReply->reply_name)   :  __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('status', __('messages.common.status').':') }}
                <p>{{ (isset($ticket->ticket_status_id)) ? $ticket->ticketStatus->name : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('created_at', __('messages.common.created_on').':') }}<br>
                <span data-toggle="tooltip" data-placement="right"
                      title="{{ date('jS M, Y', strtotime($ticket->created_at)) }}">{{ $ticket->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('created_at', __('messages.common.last_updated').':') }}<br>
                <span data-toggle="tooltip" data-placement="right"
                      title="{{ date('jS M, Y', strtotime($ticket->updated_at)) }}">{{ $ticket->updated_at->diffForHumans() }}</span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('attachments', __('messages.ticket.attachments').':') }}<br>
                @if(count($ticket->media) != 0)
                    <div class="gallery gallery-md attachment__section">
                        @foreach($ticket->media as $media)
                            <div class="gallery-item ticket-attachment"
                                 data-image="{{ mediaUrlEndsWith($media->getFullUrl()) }}"
                                 data-title="{{ $media->name }}"
                                 href="{{ mediaUrlEndsWith($media->getFullUrl()) }}"
                                 title="{{ $media->name }}">
                                <div class="ticket-attachment__icon d-none">
                                    <a href="{{ $media->getFullUrl() }}" target="_blank"
                                       class="text-decoration-none text-primary"
                                       title="{{ __('messages.common.view') }}"><i
                                                class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('admin/download-media',$media) }}"
                                       download="{{ $media->name }}"
                                       class="text-primary text-decoration-none"
                                       data-id="{{ $media->id }}"
                                       title="{{ __('messages.common.download') }}"><i
                                                class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>{{ __('messages.common.n/a') }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('body', __('messages.common.description').':') }}
                <br>
                {!! !empty($ticket->body) ? html_entity_decode($ticket->body) : __('messages.common.n/a') !!}
            </div>
        </div>
    </div>
@endsection

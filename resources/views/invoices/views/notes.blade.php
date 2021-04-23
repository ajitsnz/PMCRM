@extends('invoices.show')
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                    <div class="row">
                        <input type="hidden" name="module_id" value="{{ $data['moduleId'] }}" id="moduleId">
                        <input type="hidden" name="owner_id" value="{{ $data['ownerId'] }}" id="ownerId">
                        <div class="form-group col-lg-6">
                            <strong>{{ Form::label('add_note', __('messages.note.add_note')) }}</strong>
                            <div id="noteContainer" class="quill-editor-container"></div>
                            <div class="text-left mt-3">
                                {{ Form::button(__('messages.common.save'), ['type'=>'button','class' => 'btn btn-primary','id'=>'btnNote','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                                <button type="reset" id="btnCancel" class="btn btn-light ml-1">
                                    {{ __('messages.common.cancel') }}
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-6 note-scroll">
                            <div class="notes">
                                <div>
                                    <div class="mb-3 d-flex">
                                        <span class="flex-1 ml-5 no_notes text-center @if(!($notes->isEmpty())) d-none @endif">{{ __('messages.note.no_notes_added_yet') }}</span>
                                    </div>
                                </div>
                                <div class="activities">
                                    @foreach($notes as $note)
                                        <div class="activity clearfix notes__information"
                                             id="{{ 'note__'.$note->id }}">
                                            <div class="activity-icon">
                                                <img class="user__img profile" width="50"
                                                     height="50"
                                                     src=" {{ $note->user->image_url }}"
                                                     alt="User Image">
                                                <span class="user__username">
                                                            </span>
                                            </div>
                                            <div class="activity-detail col-xl-11 col-lg-10 pt-1 mb-3">
                                                <div
                                                        class="mb-0 d-flex justify-content-between flex-wrap">
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        @php
                                                            $deletedUser = (isset($note->user->deleted_at)) ? "<span class='user__deleted-user'>(deactivated user)</span>" : ''
                                                        @endphp
                                                        <span
                                                                class="font-weight-bold lead">{{ isset($note->user->full_name) ? $note->user->full_name . ' ' . $deletedUser : '' }}</span>
                                                        <span
                                                                class="text-job text-dark user__description ml-2">{{timeElapsedString($note->created_at)}}</span>
                                                    </div>
                                                    <div>
                                                        @if($note->added_by == getLoggedInUserId())
                                                            <a class="user__icons del-note d-none task-comment-delete"
                                                               data-id="{{$note->id}}"><i
                                                                        class="fas fa-trash ml-0 card-delete-icon"></i></a>
                                                            <a class="user__icons edit-note d-none task-comment-edit"
                                                               data-id="{{$note->id}}"><i
                                                                        class="fas fa-edit mr-2 card-edit-icon"></i>&nbsp;</a>
                                                            <a class="user__icons save-note {{'comment-save-icon-'.$note->id}} d-none task-comment-check"
                                                               data-id="{{$note->id}}"><i
                                                                        class="far fa-check-circle text-success font-weight-bold hand-cursor card-save-icon"></i>&nbsp;&nbsp;</a>
                                                            <a class="user__icons cancel-note {{'comment-cancel-icon-'.$note->id}} d-none task-comment-cancel"
                                                               data-id="{{$note->id}}"><i
                                                                        class="fas fa-times hand-cursor card-cancel-icon"></i>&nbsp;&nbsp;</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div
                                                        class="user__comment mt-2 @if($note->added_by == getLoggedInUserId()) note-display @endif {{'comment-display-'.$note->id}}"
                                                        data-id="{{$note->id}}">
                                                    {!! html_entity_decode($note->note) !!}
                                                </div>
                                                @if($note->added_by == getLoggedInUserId())
                                                    <div
                                                            class="user__comment d-none note-edit {{'comment-edit-'.$note->id}}">
                                                        <div id="noteEditContainer{{$note->id}}"
                                                             class="quill-editor-container"></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <div id="noteContainer" class="quill-editor-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
@endsection


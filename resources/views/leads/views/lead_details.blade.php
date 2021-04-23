@extends('leads.show')
@section('section')
    <div class="row">
        @if(!empty($lead->public))
            <div class="form-group col-sm-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           id="check"
                           name="public" value="1"
                           {{ (isset($lead->public) && $lead->public == 1) ? 'checked' : '' }} disabled>
                    <label class="custom-control-label"
                           for="check">{{__('messages.task.public') }}</label>
                </div>
            </div>
        @endif
        <div class="form-group col-sm-4">
            {{ Form::label('name', __('messages.lead.name').':') }}
            <p class="leadName">{{ html_entity_decode($lead->name) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('name', __('messages.customer.company_name').':') }}
            <p class="companyName">{{ html_entity_decode($lead->company_name) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('status', __('messages.common.status').':') }}
            <p>{{ html_entity_decode($lead->leadStatus->name) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('source', __('messages.lead.source').':') }}
            <p>{{ html_entity_decode($lead->leadSource->name) }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('estimate_budget', __('messages.lead.estimate_budget').':') }}
            <p>
                <i class="{{ isset($lead->estimate_budget) ? getCurrencyClass() : ''}}"></i> {{ isset($lead->estimate_budget) ? number_format($lead->estimate_budget, 2) : __('messages.common.n/a') }}
            </p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('assigned', __('messages.lead.member').':') }}
            <p>
                @if(isset($lead->assignedTo))
                    <a href="{{ url('admin/members',$lead->assign_to) }}"
                       class="anchor-underline">{{ html_entity_decode($lead->assignedTo->full_name) }}</a>
                @else
                    {{ __('messages.common.n/a') }}
                @endif
            </p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('tags', __('messages.tags').':') }}
            <p>
                @forelse($lead->tags as $tag)
                    <span class="badge border border-secondary">{{ html_entity_decode($tag->name) }}</span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('position', __('messages.contact.position').':') }}
            <p>{{ isset($lead->position) ? html_entity_decode($lead->position) : __('messages.common.n/a') }}</p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('website', __('messages.customer.website').':') }}
            <p>
                @if(!empty($lead->website))
                    <a href="{{ $lead->website }}" class="anchor-underline">{{ $lead->website }}</a>
                @else
                    {{ __('messages.common.n/a') }}
                @endif
            </p>
            <input type="hidden" class="leadWebsite" value="{{ !empty($lead->website)?$lead->website:null }}" hidden>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('phone', __('messages.customer.phone').':') }}
            <p>{{ !empty($lead->phone) ? $lead->phone : __('messages.common.n/a') }}</p>
            <input type="hidden" class="LeadPhone" value="{{ !empty($lead->phone)?$lead->phone:null }}" hidden>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('country', __('messages.customer.country').':') }}
            <p>{{ !empty($lead->country) ? \App\Models\Lead::COUNTRIES[$lead->country] : __('messages.common.n/a') }}</p>
            <input type="hidden" class="countryId"
                   value="{{ (!empty($lead->address) && $lead->address->country!=null)?$lead->address->country:null }}"
                   hidden>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('default_language', __('messages.customer.default_language').':') }}
            <p>{{ !empty($lead->default_language) ? \App\Models\Lead::LANGUAGES[$lead->default_language] : __('messages.common.n/a') }}</p>
            <input type="hidden" class="defaultLanguage" hidden
                   value="{{ !empty($lead->default_language)?$lead->default_language:null }}">
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('date_contacted', __('messages.lead.date_contacted').':') }}
            @if(isset($lead->date_contacted))
                <p>{{ date('jS M, Y H:i A', strtotime($lead->date_contacted)) }}</p>
            @else
                <p>{{ __('messages.common.n/a') }}</p>
            @endif
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($lead->created_at)) }}">{{ $lead->created_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-sm-4">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($lead->updated_at)) }}">{{ $lead->updated_at->diffForHumans() }}</span>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            {{ Form::label('description', __('messages.common.description').':') }}
            <br>
            {!! !empty($lead->description) ? nl2br($lead->description) : __('messages.common.n/a') !!}
        </div>
    </div>
@endsection

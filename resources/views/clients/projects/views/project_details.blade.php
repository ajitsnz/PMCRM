@extends('clients.projects.show')
@section('section')
    <div class="row">
        <div class="form-group col-md-4 col-12">
            {{ Form::label('project_name', __('messages.project.project_name').':') }}
            <p>{{ html_entity_decode($project->project_name) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('customer', __('messages.invoice.customer').':') }}
            <p>{{ html_entity_decode($project->customer->company_name) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('contacts', __('messages.contacts').':') }}
            <p>
                @forelse($project->projectContacts as $contact)
                    <span class="badge badge-light">{{ html_entity_decode($contact->user->full_name) }} </span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('members', __('messages.members').':') }}
            <p>
                @forelse($project->members as $member)
                    <span class="badge badge-light">{{ html_entity_decode($member->user->full_name) }} </span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('progress', __('messages.project.progress').':') }}
            <p>{{ $project->progress }} %</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('billing_type', __('messages.project.billing_type').':') }}
            <p>{{ $project->getBillingTypeText($project->billing_type) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('status', __('messages.project.status').':') }}
            <p>{{ $project->getStatusText($project->status) }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('estimated_hours', __('messages.project.estimated_hours').':') }}
            <p>{{ isset($project->estimated_hours) ? $project->estimated_hours : 0 }} {{ __('messages.invoice.hours') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('start_date', __('messages.project.start_date').':') }}
            <p>{{ Carbon\Carbon::parse($project->start_date)->format('jS M, Y H:i A') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('deadline', __('messages.project.deadline').':') }}
            <p>{{ Carbon\Carbon::parse($project->deadline)->format('jS M, Y H:i A') }}</p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('tags', __('messages.tags').':') }}
            <p>
                @forelse($project->tags as $tag)
                    <span class="badge badge-light">{{ html_entity_decode($tag->name) }} </span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($project->created_at)) }}">{{ $project->created_at->diffForHumans() }}</span>
            </p>
        </div>
        <div class="form-group col-md-4 col-12">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <p><span data-toggle="tooltip" data-placement="right"
                     title="{{ date('jS M, Y', strtotime($project->updated_at)) }}">{{ $project->updated_at->diffForHumans() }}</span>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4 col-12">
            {{ Form::label('description', __('messages.common.description').':') }}
            <br>
            {!! !empty($project->description) ? html_entity_decode($project->description) : __('messages.common.n/a') !!}
        </div>
    </div>
@endsection

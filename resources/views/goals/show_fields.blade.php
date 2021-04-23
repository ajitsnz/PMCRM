<div class="row">
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('subject',__('messages.goal.subject').':') }}
            <p>{{ html_entity_decode($goal->subject) }}</p>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('user_id', __('messages.members').':') }}
            <p>
                @forelse($goal->goalMembers as $members)
                    <span class="badge border border-secondary mt-1">
                        <a href="{{ url('admin/members',$members->id) }}"
                           class="anchor-underline">{{ html_entity_decode($members->full_name) }}</a>
                    </span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </p>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('goal_type', __('messages.goal.goal_type').':') }}
            <p>{{ \App\Models\Goal::GOAL_TYPE[$goal->goal_type] }}</p>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('achievement', __('messages.goal.achievement').':') }}
            <p>{{ $goal->achievement }}</p>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('is_notify', __('messages.goal.is_notify').':') }}
            <p>{{ (isset($goal->is_notify) && $goal->is_notify)  ? __('messages.common.yes') : __('messages.common.no') }}</p>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('is_not_notify',__('messages.goal.is_not_notify').':') }}
            <p>{{ (isset($goal->is_not_notify) && $goal->is_not_notify) ? __('messages.common.yes') : __('messages.common.no') }}</p>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('start_date', __('messages.goal.start_date').':') }}
            <p>{{ Carbon\Carbon::parse($goal->start_date)->format('jS M, Y H:i A') }}</p>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('end_date', __('messages.goal.end_date').':') }}
            <p>{{ Carbon\Carbon::parse($goal->end_date)->format('jS M, Y H:i A') }}</p>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}<br>
            <span data-toggle="tooltip" data-placement="right"
                  title="{{ date('jS M, Y', strtotime($goal->created_at)) }}">{{ $goal->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="form-group">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <br>
            <span data-toggle="tooltip" data-placement="right"
                  title="{{ date('jS M, Y', strtotime($goal->updated_at)) }}">{{ $goal->updated_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('description', __('messages.goal.description').':') }}
            <br>
            {!! !empty($goal->description) ? html_entity_decode($goal->description) : __('messages.common.n/a') !!}
        </div>
    </div>
</div>

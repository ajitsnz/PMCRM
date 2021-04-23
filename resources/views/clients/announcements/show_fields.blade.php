<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('subject',  __('messages.announcement.subject').':') }}
            <p>{{ html_entity_decode($announcement->subject) }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('date',__('messages.announcement.announcement_date').':') }}
            <p>{{ date('jS M, Y H:i A', strtotime($announcement->date)) }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}<br>
            <span data-toggle="tooltip" data-placement="right"
                  title="{{ date('jS M, Y', strtotime($announcement->created_at)) }}">{{ $announcement->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <br>
            <span data-toggle="tooltip" data-placement="right"
                  title="{{ date('jS M, Y', strtotime($announcement->updated_at)) }}">{{ $announcement->updated_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('description', __('messages.announcement.message').':') }}
            <br>{!! !empty($announcement->message) ? ($announcement->message) : __('messages.common.n/a')!!}
        </div>
    </div>
</div>


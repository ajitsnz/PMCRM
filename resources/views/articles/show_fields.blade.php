<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('subject',  __('messages.article.subject').':') }}
            <p>{{ html_entity_decode($article->subject) }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('group_id', __('messages.article.group').':') }}
            <p>{{ html_entity_decode($article->articleGroup->group_name) }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('internal_article', __('messages.article.internal_article').':') }}
            <p>{{ (isset($article->internal_article) && $article->internal_article) ? __('messages.common.active') : __('messages.common.deactive') }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('disabled', __('messages.common.status').':') }}
            <p>{{ (isset($article->disabled) && $article->disabled) ? __('messages.common.active') : __('messages.common.deactive') }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}<br>
            <span data-toggle="tooltip" data-placement="right"
                  title="{{ date('jS M, Y', strtotime($article->created_at)) }}">{{ $article->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <br>
            <span data-toggle="tooltip" data-placement="right"
                  title="{{ date('jS M, Y', strtotime($article->updated_at)) }}">{{ $article->updated_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('image', __('messages.article.attachment').':') }}
            <br>
            @if(!empty($article->image))
                <a href="{{ url('admin/attachment-download',$article->id) }}"
                   class="text-decoration-none">{{ __('messages.common.download') }}</a>
            @else
                <p>{{ __('messages.common.n/a') }}</p>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('description', __('messages.article.description').':') }}
            <br>
            {!! !empty($article->description) ? html_entity_decode($article->description) : __('messages.common.n/a')!!}
        </div>
    </div>
</div>


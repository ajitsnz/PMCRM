<div class="row">
    <div class="col-lg-9">
        <article class="article article-style-b">
            <div class="article-header">
                <div class="article-image" data-background="{{ $article->getImageUrl() }}">
                </div>
            </div>
            <div class="article-details">
                <div class="article-title">
                    <h5 class="text-dark">{{ $article->subject }}</h5>
                </div>
                <p>{!! $article->description !!}</p>
            </div>
        </article>
    </div>
    <div class="col-12 col-sm-3 col-md-3 col-lg-3">
        <div class="sidebar">
            <div class="widget">
                <h5 class="widget-title">{{ __('messages.common.search') }}</h5>
                <div class="search">
                    {{ Form::text('search',null,['class' => 'form-control', 'placeholder' => 'Search', 'autocomplete' => 'off']) }}
                    {{ Form::button('<i class="fa fa-search"></i>',['class' => 'btn']) }}
                </div>
            </div>
            <div class="widget">
                <h5 class="widget-title">{{ __('messages.article_group.article_groups') }}</h5>
                @foreach($articlesGroups as $articlesGroup)
                    <ul class="mr-5">
                        <li>{{ $articlesGroup->group_name }}</li>
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
</div>

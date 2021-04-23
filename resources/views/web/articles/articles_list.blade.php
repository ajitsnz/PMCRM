@forelse($articles as $article)
    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <article class="article article-style-b">
            <div class="article-header">
                <div class="article-image" data-background="{{ $article->getImageUrl() }}"
                     style="background-image: url({{ $article->getImageUrl() }});">
                </div>
            </div>
            <div class="article-details">
                <div class="article-title">
                    <h2><a href="{{ url('articles') }}/{{ $article->id }}"
                           class="text-decoration-none">{{ $article->subject }}</a>
                    </h2>
                </div>
                <p>{!! $article->description !!}</p>
                <div class="article-cta">
                    <a href="{{ url('articles') }}/{{ $article->id }}" class="text-decoration-none">Read More <i
                                class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </article>
    </div>
@empty
    <div class="no-articles">Articles Not Found.</div>
@endforelse

<div class="row">
    <div class="mt-0 mb-3 col-12 d-flex justify-content-end">
        <div class="p-2">
            <input wire:model.debounce.100ms="search" type="search" class="form-control" placeholder="Search"
                   id="search">
        </div>
    </div>
    <div class="col-md-12">
        <div wire:loading id="live-wire-screen-lock">
            <div class="live-wire-infy-loader">
                @include('loader')
            </div>
        </div>
    </div>
    @php
        $inStyle = 'style';
        $style = 'border-top: 3px solid';
    @endphp
    @forelse($articles as $article)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="livewire-card card author-box shadow mb-5 rounded client-card-view article-card-border">
                <img src="{{ $article->getImageUrl() }}" class="card-img-top article-img" alt="Card image cap">
                <div class="card-header client-card d-flex align-items-center user-card-index d-sm-flex-wrap-0">
                    <div class="ml-2 w-100 mb-auto">
                        <div class="justify-content-between d-flex">
                            <div class="article-card-name pb-1">
                                <h4><a href="{{ route('articles.show',$article->id) }}" class="text-decoration-none"
                                       data-id="{{ $article->id }}">{{ Str::limit(html_entity_decode($article->subject), 15, '...') }}</a>
                                </h4>
                            </div>
                            <a class="dropdown dropdown-list-toggle">
                                <a href="#" data-toggle="dropdown"
                                   class="notification-toggle action-dropdown d-none position-xs-bottom">
                                    <i class="fas fa-ellipsis-v action-toggle-mr"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-list-content dropdown-list-icons">
                                        <a href="{{ route('articles.edit',$article->id) }}"
                                           class="dropdown-item dropdown-item-desc edit-btn"
                                           data-id="{{ $article->id }}"><i
                                                    class="fas fa-edit mr-2 card-edit-icon"></i> {{ __('messages.common.edit') }}
                                        </a>
                                        <a href="#" class="dropdown-item dropdown-item-desc delete-btn"
                                           data-id="{{ $article->id }}"><i
                                                    class="fas fa-trash mr-2 card-delete-icon"></i>{{ __('messages.common.delete') }}
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="article-card-department">
                            <span data-toggle="tooltip"
                                  title="Article Group">{{ html_entity_decode($article->articleGroup->group_name) }}</span>
                            <label class="custom-switch pl-0" data-placement="bottom"
                                   title="{{ $article->disabled ? __('messages.common.active') : __('messages.common.deactive') }}">
                                <input type="checkbox" name="is_active" class="custom-switch-input articleDisabled"
                                       data-id="{{ $article->id }}" value="1"
                                       data-class="is_active" {{ $article->disabled ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                </div>
        </div>
</div>
@empty
    <div class="mt-0 mb-5 col-12 d-flex justify-content-center  mb-5 rounded">
        <div class="p-2">
            @if($search == null || empty($search))
                <p class="text-dark">{{ __('messages.article.no_article_available') }}</p>
            @else
                <p class="text-dark">{{ __('messages.article.no_article_found') }}</p>
            @endif
        </div>
    </div>
    @endforelse

    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }} 
                    <span class="font-weight-bold ml-1 mr-1">{{ $articles->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $articles->lastItem() }}</span> {{ __('messages.common.of') }} 
                    <span class="font-weight-bold ml-1">{{ $articles->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>

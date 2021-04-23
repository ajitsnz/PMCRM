<div class="navbar-bg article-navbar"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <a href="#" class="navbar-brand sidebar-gone-hide">{{ config('app.name') }}</a>
    <div class="navbar-nav">
        <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
    </div>
    <div class="nav-collapse">
        <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
            <i class="fas fa-ellipsis-v"></i>
        </a>
        <ul class="navbar-nav">
            <li class="nav-item active"><a href="{{ url('articles') }}"
                                           class="nav-link">{{ __('messages.articles') }}</a></li>
        </ul>
    </div>
</nav>

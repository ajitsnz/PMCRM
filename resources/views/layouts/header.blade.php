<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a>
        </li>
    </ul>
    <div class="search-element">
        <input class="form-control search-input-css" type="text" id="searchCustomer" disabled
               placeholder="Search Customers" aria-label="Search" autocomplete="off">
        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        <div class="search-backdrop"></div>
        <div class="search-result">
            <div id="customerName" class="py-2">
                <h6 class="py-1 px-3 my-0"><i
                            class="fab fa fa-search text-primary"></i> {{ __('messages.common.search_results') }}</h6>
            </div>
        </div>
    </div>
</form>
<ul class="navbar-nav navbar-right">
    @if(getLoggedInUser())
        <li class="dropdown">
            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img class="rounded-circle mr-1" id="loginUserImage" src="{{ getLoggedInUser()->image_url??'' }}"
                     alt="InfyOm">
                <div class="d-sm-none d-lg-inline-block">
                    {{__('messages.edit_profile.hi')}}, {{ getLoggedInUser()->first_name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    {{__('messages.edit_profile.welcome')}}
                    , {{ getLoggedInUser()->full_name }}</div>
                <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user mr-2"></i>{{__('messages.edit_profile.edit_profile')}}
                </a>
                <a class="dropdown-item has-icon" href="#" data-toggle="modal" data-id="{{ getLoggedInUserId() }}"
                   data-target="#changePasswordModal"><i
                            class="fa fa-lock mr-2"></i>{{__('messages.edit_profile.change_password')}}</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-id="{{ getLoggedInUserId() }}"
                   data-target="#changeLanguageModal"><i
                            class="fa fa-language mr-2"></i>{{ __('messages.user.change_language') }}</a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> {{__('messages.edit_profile.logout')}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    @else
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="#" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{__('messages.edit_profile.hello')}}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{__('messages.edit_profile.login_register')}}</div>
                <a href="{{ route('login') }}" class="dropdown-item has-icon">
                    <i class="fas fa-sign-in-alt"></i> {{__('messages.edit_profile.login')}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('register') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-plus"></i> {{__('messages.edit_profile.register')}}
                </a>
            </div>
        </li>
    @endif
</ul>

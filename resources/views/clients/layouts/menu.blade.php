@role('client')
<nav class="navbar navbar-secondary navbar-expand-lg">
    <div class="container">
        <ul class="navbar-nav sidebar-menu-client">
            <li class="nav-item {{ Request::is('client/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('clients.dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i><span>{{ __('messages.dashboard') }}</span>
                </a>
            </li>
            @can('contact_projects')
                <li class="nav-item {{ Request::is('client/projects*') ? 'active' : '' }}">
                    <a href="{{ route('clients.projects.index') }}" class="nav-link">
                        <i class="fas fa-layer-group"></i><span>{{ __('messages.projects') }}</span>
                    </a>
                </li>
            @endcan
            @can('contact_invoices')
                <li class="nav-item {{ Request::is('client/invoices*') ? 'active' : '' }}">
                    <a href="{{ route('clients.invoices.index') }}" class="nav-link">
                        <i class="fas fa-file-invoice"></i><span>{{ __('messages.invoices') }}</span>
                    </a>
                </li>
            @endcan
            @can('contact_proposals')
                <li class="nav-item {{ Request::is('client/proposals*') ? 'active' : '' }}">
                    <a href="{{ route('clients.proposals.index') }}" class="nav-link">
                        <i class="fas fa-scroll"></i><span>{{ __('messages.proposals') }}</span>
                    </a>
                </li>
            @endcan
            @can('contact_contracts')
                <li class="nav-item {{ Request::is('client/contracts*') ? 'active' : '' }}">
                    <a href="{{ route('clients.contracts.index') }}" class="nav-link">
                        <i class="fas fa-file-signature"></i><span>{{ __('messages.contracts') }}</span>
                    </a>
                </li>
            @endcan
            @can('contact_estimates')
                <li class="nav-item {{ Request::is('client/estimates*') ? 'active' : '' }}">
                    <a href="{{ route('clients.estimates.index') }}" class="nav-link">
                        <i class="fas fa-calculator"></i><span>{{ __('messages.estimates') }}</span>
                    </a>
                </li>
            @endcan
            <li class="nav-item {{ Request::is('client/announcements*') ? 'active' : '' }}">
                <a href="{{ route('clients.announcements.index') }}" class="nav-link">
                    <i class="fas fa-bullhorn"></i><span>{{ __('messages.announcements') }}</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
@endrole

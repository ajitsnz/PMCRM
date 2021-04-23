<aside id="sidebar-wrapper">
    <div class="sidebar-brand sidebar-sticky sidebar-bottom-padding">
        <a class="navbar-brand" href="{{ route('redirect.login') }}">
            <img class="navbar-brand-full"
                 src="{{getSettingValue("logo") ?? asset('img/infyom-logo.png') }}" width="50px"
                 alt="">&nbsp;&nbsp;
            <span class="navbar-brand-full-name text-black">{{ getAppName() }}</span>
        </a>
        <div class="input-group sidebar-search-box">
            <input type="text" class="form-control searchTerm" id="searchText" placeholder="Search Menu">
            <div class="input-group-append sGroup">
                <div class="input-group-text">
                    <i class="fas fa-search search-sign"></i>
                    <i class="fas fa-times close-sign"></i>
                </div>
            </div>
            <div class="no-results mt-3 ml-1">{{ __('messages.no_matching_records_found') }}</div>
        </div>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('redirect.login') }}" class="small text-white"> <img class="navbar-brand-full"
                                                                               src="{{getSettingValue("logo") ?? asset('img/infyom-logo.png') }}"
                                                                               width="50px"
                                                                               alt="">
        </a>
    </div>

    <ul class="sidebar-menu">
        <li class="menu-header side-menus">{{ __('messages.dashboard') }}</li>
        <li class="side-menus {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-lg fa-tachometer-alt"></i>
                <span class="menu-text-wrap">{{ __('messages.dashboard') }}</span></a>
        </li>
        @canany(['manage_customers','manage_customer_groups'])
            <li class="menu-header side-menus">{{ __('messages.customers') }}</li>
            <li class="nav-item dropdown side-menus">
                <a class="nav-link has-dropdown" href="#"><i class="fas fa-lg fa-street-view"></i>
                    <span>{{ __('messages.customers') }}</span></a>
                <ul class="dropdown-menu side-menus">
                    @can('manage_customer_groups')
                        <li class="side-menus {{ Request::is('admin/customer-groups*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('customer-groups.index') }}">
                                <i class="fas fa-lg fa-people-arrows"></i>
                                <span class="menu-text-wrap">{{ __('messages.customer_groups') }}</span></a>
                        </li>
                    @endcan
                    @can('manage_customers')
                        <li class="side-menus {{ Request::is('admin/customers*') || Request::is('admin/contacts*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('customers.index') }}">
                                <i class="fas fa-lg fa-street-view"></i><span
                                        class="menu-text-wrap">{{ __('messages.customers') }}</span></a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @can('manage_staff_member')
            <li class="side-menus {{ Request::is('admin/members*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('members.index') }}"><i class="fas fa-lg fa-user-friends"></i>
                    <span class="menu-text-wrap">{{ __('messages.members') }}</span>
                </a>
            </li>
        @endcan
        @canany(['manage_articles','manage_article_groups'])
            <li class="nav-item dropdown side-menus">
                <a class="nav-link has-dropdown" href="#"><i class="fab fa-lg fa-autoprefixer"></i>
                    <span>{{ __('messages.articles') }}</span></a>
                <ul class="dropdown-menu side-menus">
                    @can('manage_article_groups')
                        <li class="side-menus {{ Request::is('admin/article-groups*') ? 'active' : '' }}">
                            <a href="{{ route('article-groups.index') }}"><i class="fas fa-lg fa-edit"></i>
                                <span class="menu-text-wrap">{{ __('messages.article_group.article_groups') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_articles')
                        <li class="side-menus {{ Request::is('admin/articles*') ? 'active' : '' }}">
                            <a href="{{ route('articles.index') }}"><i class="fab fa-lg fa-autoprefixer"></i>
                                <span class="menu-text-wrap">{{ __('messages.articles') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @can('manage_tags')
            <li class="side-menus {{ Request::is('admin/tags*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tags.index') }}">
                    <i class="fas fa-tags"></i><span class="menu-text-wrap">{{ __('messages.tags') }}</span>
                </a>
            </li>
        @endcan
        @canany(['manage_lead_status','manage_lead_sources','manage_leads'])
            <li class="menu-header side-menus">{{ __('messages.leads') }}</li>
            <li class="nav-item dropdown side-menus">
                <a class="nav-link has-dropdown" href="#"><i class="fas fa-lg fa-tty"></i>
                    <span>{{ __('messages.leads') }}</span></a>
                <ul class="dropdown-menu side-menus">
                    @can('manage_lead_status')
                        <li class="side-menus {{ Request::is('admin/lead-status*') ? 'active' : '' }}">
                            <a href="{{ route('lead.status.index') }}"><i class="fas fa-lg fa-blender-phone"></i>
                                <span class="menu-text-wrap">{{ __('messages.lead_status.lead_status') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_lead_sources')
                        <li class="side-menus {{ Request::is('admin/lead-sources*') ? 'active' : '' }}">
                            <a href="{{ route('lead.source.index') }}"><i class="fas fa-lg fa-globe"></i>
                                <span class="menu-text-wrap">{{ __('messages.lead_sources') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_leads')
                        <li class="side-menus {{ Request::is('admin/leads*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('leads.index') }}">
                                <i class="fas fa-lg fa-tty"></i><span
                                        class="menu-text-wrap">{{ __('messages.leads') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['manage_tasks','manage_tickets','manage_ticket_priority','manage_ticket_statuses','manage_predefined_replies'])
            <li class="menu-header side-menus">{{ __('messages.projects') }}
            @can('manage_projects')
                <li class="side-menus {{ Request::is('admin/projects*') ? 'active' : '' }}">
                    <a href="{{ route('projects.index') }}">
                        <i class="fas fa-lg fa-layer-group"></i>
                        <span class="menu-text-wrap">{{ __('messages.projects') }}</span>
                    </a>
                </li>
            @endcan
            @can('manage_tasks')
                <li class="side-menus {{ Request::is('admin/tasks*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tasks.index') }}">
                        <i class="fas fa-lg fa-tasks"></i>
                        <span class="menu-text-wrap">{{ __('messages.tasks') }}</span></a>
                </li>
            @endcan
            <li class="nav-item dropdown side-menus">
                <a class="nav-link has-dropdown" href="#"><i class="fas fa-lg fa-ticket-alt"></i>
                    <span>{{ __('messages.tickets') }}</span></a>
                <ul class="dropdown-menu side-menus">
                    @can('manage_ticket_priority')
                        <li class="side-menus {{ Request::is('admin/ticket-priorities*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('ticketPriorities.index') }}">
                                <i class="fas fa-lg fa-sticky-note"></i>
                                <span class="menu-text-wrap">{{ __('messages.ticket_priorities') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_ticket_statuses')
                        <li class="side-menus {{ Request::is('admin/ticket-statuses*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('ticket.status.index') }}">
                                <i class="fas fa-lg fa-info-circle"></i><span
                                        class="menu-text-wrap">{{ __('messages.ticket_status.ticket_status') }}</span></a>
                        </li>
                    @endcan
                    @can('manage_predefined_replies')
                        <li class="side-menus {{ Request::is('admin/predefined-replies*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('predefinedReplies.index') }}">
                                <i class="fas fa-lg fa-reply"></i><span
                                        class="menu-text-wrap">{{ __('messages.predefined_replies') }}</span></a>
                        </li>
                    @endcan
                    @can('manage_tickets')
                        <li class="side-menus {{ Request::is('admin/tickets*') ? 'active' : '' }}">
                            <a href="{{ route('ticket.index') }}"><i class="fas fa-lg fa-ticket-alt"></i>
                                <span class="menu-text-wrap">{{ __('messages.tickets') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['manage_invoices','manage_payments','manage_credit_notes','manage_proposals','manage_estimates'])
            <li class="menu-header side-menus">{{ __('messages.sales') }}</li>
            <li class="nav-item dropdown side-menus">
                <a class="nav-link has-dropdown" href="#"><i class="fab fa-lg fa-speakap"></i>
                    <span>{{ __('messages.sales') }}</span></a>
                <ul class="dropdown-menu side-menus">
                    @can('manage_invoices')
                        <li class="side-menus {{ Request::is('admin/invoices*') ? 'active' : '' }}">
                            <a href="{{ route('invoices.index') }}"><i class="fas fa-lg fa-file-invoice"></i>
                                <span class="menu-text-wrap">{{ __('messages.invoices') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_credit_notes')
                        <li class="side-menus {{ Request::is('admin/credit-notes*') ? 'active' : '' }}">
                            <a href="{{ route('credit-notes.index') }}"><i class="fas fa-lg fa-clipboard"></i>
                                <span class="menu-text-wrap">{{ __('messages.credit_notes') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_proposals')
                        <li class="side-menus {{ Request::is('admin/proposals*') ? 'active' : '' }}">
                            <a href="{{ route('proposals.index') }}"><i class="fas fa-lg fa-scroll"></i>
                                <span class="menu-text-wrap">{{ __('messages.proposals') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_estimates')
                        <li class="side-menus {{ Request::is('admin/estimates*') ? 'active' : '' }}">
                            <a href="{{ route('estimates.index') }}"><i class="fas fa-lg fa-calculator"></i>
                                <span class="menu-text-wrap">{{ __('messages.contact.estimates') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_payments')
                        <li class="side-menus {{ Request::is('admin/payments-list*') ? 'active' : '' }}">
                            <a href="{{ route('payments.list.index') }}"><i class="fas fa-lg fa-money-check-alt"></i>
                                <span class="menu-text-wrap">{{ __('messages.invoice.invoice_payments') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['manage_departments'])
            <li class="menu-header side-menus">{{ __('messages.support') }}</li>
            @can('manage_departments')
                <li class="side-menus {{ Request::is('admin/departments*') ? 'active' : '' }}">
                    <a href="{{ route('departments.index') }}"><i class="fas fa-lg fa-columns"></i>
                        <span class="menu-text-wrap">{{ __('messages.department.departments') }}</span>
                    </a>
                </li>
            @endcan
        @endcanany
        @canany(['manage_expense_category','manage_expenses'])
            <li class="menu-header side-menus">{{ __('messages.expenses') }}</li>
            <li class="nav-item dropdown side-menus">
                <a class="nav-link has-dropdown" href="#"><i class="fab fa-lg fa-erlang"></i>
                    <span>{{ __('messages.expenses') }}</span></a>
                <ul class="dropdown-menu side-menus">
                    @can('manage_expense_category')
                        <li class="side-menus {{ Request::is('admin/expense-categories*') ? 'active' : '' }}">
                            <a href="{{ route('expense-categories.index') }}"><i class="fas fa-lg fa-list-ol"></i>
                                <span class="menu-text-wrap">{{ __('messages.expense_categories') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_expenses')
                        <li class="side-menus {{ Request::is('admin/expenses*') ? 'active' : '' }}">
                            <a href="{{ route('expenses.index') }}"><i class="fab fa-lg fa-erlang"></i>
                                <span class="menu-text-wrap">{{ __('messages.expenses') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @can('manage_payment_mode')
            <li class="side-menus {{ Request::is('admin/payment-modes*') ? 'active' : '' }}">
                <a href="{{ route('payment-modes.index') }}"><i class="fab fa-lg fa-product-hunt"></i>
                    <span class="menu-text-wrap">{{ __('messages.payment_modes') }}</span>
                </a>
            </li>
        @endcan
        @can('manage_tax_rates')
            <li class="side-menus {{ Request::is('admin/tax-rates*') ? 'active' : '' }}">
                <a href="{{ route('tax-rates.index') }}"><i class="fas fa-lg fa-percent"></i>
                    <span class="menu-text-wrap">{{ __('messages.tax_rates') }}</span>
                </a>
            </li>
        @endcan
        @canany(['manage_settings'])
            <li class="menu-header side-menus">{{ __('messages.others') }}</li>
            <li class="nav-item dropdown side-menus">
            @can('manage_announcements')
                <li class="side-menus {{ Request::is('admin/announcements*') ? 'active' : '' }}">
                    <a href="{{ route('announcements.index') }}"><i class="fas fa-lg fa-bullhorn"></i>
                        <span class="menu-text-wrap">{{ __('messages.announcements') }}</span>
                    </a>
                </li>
            @endcan
            @canany(['manage_items','manage_items_groups'])
                <li class="nav-item dropdown side-menus">
                    <a class="nav-link has-dropdown" href="#"><i class="fas fa-lg fa-sitemap"></i>
                        <span>{{ __('messages.items') }}</span>
                    </a>
                    <ul class="dropdown-menu side-menus">
                        @can('manage_items')
                            <li class="side-menus {{ Request::is('admin/items*') ? 'active' : '' }}">
                                <a href="{{ route('items.index') }}"><i class="fas fa-lg fa-sitemap"></i>
                                    <span class="menu-text-wrap">{{ __('messages.item.items') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('manage_items_groups')
                            <li class="side-menus {{ Request::is('admin/item-groups*') ? 'active' : '' }}">
                                <a href="{{ route('item-groups.index') }}"><i class="fas fa-lg fa-object-group"></i>
                                    <span class="menu-text-wrap">{{ __('messages.item_groups') }}</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
        @endcanany
        @canany(['manage_contracts','manage_contracts_types'])
            <li class="nav-item dropdown side-menus">
                <a class="nav-link has-dropdown" href="#"><i class="fas fa-lg fa-file-signature"></i>
                    <span>{{ __('messages.contracts') }}</span>
                </a>
                <ul class="dropdown-menu side-menus">
                    @can('manage_contracts')
                        <li class="side-menus {{ Request::is('admin/contracts*') ? 'active' : '' }}">
                            <a href="{{ route('contracts.index') }}"><i class="fas fa-lg fa-file-signature"></i>
                                <span class="menu-text-wrap">{{ __('messages.contracts') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('manage_contracts_types')
                        <li class="side-menus {{ Request::is('admin/contract-types*') ? 'active' : '' }}">
                            <a href="{{ route('contract-types.index') }}"><i class="fas fa-lg fa-file-contract"></i>
                                <span class="menu-text-wrap">{{ __('messages.contract_types') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @can('manage_goals')
            <li class="side-menus {{ Request::is('admin/goals*') ? 'active' : '' }}">
                <a href="{{ route('goals.index') }}"><i class="fas fa-lg fa-bullseye"></i>
                    <span class="menu-text-wrap">{{ __('messages.goals') }}</span>
                </a>
            </li>
        @endcan
        @canany(['manage_settings'])
            <li class="menu-header side-menus">{{ __('messages.cms') }}</li>
            @can('manage_services')
                <li class="side-menus {{ Request::is('admin/services*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('services.index') }}">
                        <i class="fab fa-lg fa-stripe-s"></i>
                        <span class="menu-text-wrap">{{ __('messages.services') }}</span>
                    </a>
                </li>
            @endcan
            @can('manage_settings')
                <li class="nav-item side-menus {{ Request::is('admin/settings*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('settings.show', ['group' => 'general']) }}">
                        <i class="nav-icon fa-lg fas fa-cogs"></i>
                        <span class="menu-text-wrap">{{ __('messages.settings') }}</span>
                    </a>
                </li>
            @endcan
        @endcanany
        <li class="side-menus {{ Request::is('admin/activity-logs*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('activity.logs.index') }}">
                <i class="fas fa-clipboard-check fa-lg"
                   aria-hidden="true"></i>
                <span>{{ __('messages.activity_log.activity_logs') }}</span>
            </a>
        </li>
    </ul>
</aside>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ mix('assets/js/sidebar-menu-search/sidebar-menu-search.js') }}"></script>

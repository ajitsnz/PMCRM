<ul class="nav nav-tabs mb-3" id="customerTab" role="tablist">
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'profile']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'profile' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.profile') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'contacts']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'contacts') ? 'active' : ''}}">
            {{ __('messages.contacts') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'notes']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'notes') ? 'active' : ''}}">
            {{ __('messages.invoice.notes') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'reminders']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'reminders') ? 'active' : ''}}">
            {{ __('messages.reminders') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'tasks']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tasks') ? 'active' : ''}}">
            {{ __('messages.tasks') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'projects']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'projects') ? 'active' : ''}}">
            {{ __('messages.projects') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'tickets']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tickets') ? 'active' : ''}}">
            {{ __('messages.tickets') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'invoices']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'invoices') ? 'active' : ''}}">
            {{ __('messages.invoices') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'proposals']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'proposals') ? 'active' : ''}}">
            {{ __('messages.proposals') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'estimates']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'estimates') ? 'active' : ''}}">
            {{ __('messages.estimates') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('customers.show',['customer' => $customer->id, 'group' => 'credit_notes']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'credit_notes') ? 'active' : ''}}">
            {{ __('messages.credit_notes') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
        <a href="{{ route('leads.show',['lead' => $lead->id, 'group' => 'lead_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'lead_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.lead.lead_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('leads.show',['lead' => $lead->id, 'group' => 'proposals']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'proposals') ? 'active' : ''}}">
            {{ __('messages.proposals') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('leads.show',['lead' => $lead->id, 'group' => 'tasks']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tasks') ? 'active' : ''}}">
            {{ __('messages.tasks') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('leads.show',['lead' => $lead->id, 'group' => 'notes']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'notes') ? 'active' : ''}}">
            {{ __('messages.notes') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('leads.show',['lead' => $lead->id, 'group' => 'reminders']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'reminders') ? 'active' : ''}}">
            {{ __('messages.reminders') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

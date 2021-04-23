<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
        <a href="{{ route('tickets.show',['ticket' => $ticket->id, 'group' => 'ticket_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'ticket_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.ticket.ticket_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tickets.show',['ticket' => $ticket->id, 'group' => 'tasks']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tasks') ? 'active' : ''}}">
            {{ __('messages.tasks') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tickets.show',['ticket' => $ticket->id, 'group' => 'notes']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'notes') ? 'active' : ''}}">
            {{ __('messages.notes') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tickets.show',['ticket' => $ticket->id, 'group' => 'reminders']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'reminders') ? 'active' : ''}}">
            {{ __('messages.reminders') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

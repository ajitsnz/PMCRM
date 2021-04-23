<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
        <a href="{{ route('proposals.show',['proposal' => $proposal->id, 'group' => 'proposal_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'proposal_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.proposal.proposal_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('proposals.show',['proposal' => $proposal->id, 'group' => 'tasks']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tasks') ? 'active' : ''}}">
            {{ __('messages.tasks') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('proposals.show',['proposal' => $proposal->id, 'group' => 'reminders']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'reminders') ? 'active' : ''}}">
            {{ __('messages.reminders') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

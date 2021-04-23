<ul class="nav nav-tabs mb-3" id="customerTab" role="tablist">
    <li class="nav-item">
        <a href="{{ route('members.show',['member' => $member->id, 'group' => 'member_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'member_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.member.member_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('members.show',['member' => $member->id, 'group' => 'tasks']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tasks') ? 'active' : ''}}">
            {{ __('messages.tasks') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

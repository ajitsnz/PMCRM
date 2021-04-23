<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
        <a href="{{ route('contracts.show',['contract' => $contract->id, 'group' => 'contract_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'contract_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.contract.contract_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('contracts.show',['contract' => $contract->id, 'group' => 'tasks']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tasks') ? 'active' : ''}}">
            {{ __('messages.tasks') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

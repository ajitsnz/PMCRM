<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
        <a href="{{ route('expenses.show',['expense' => $expense->id, 'group' => 'expense_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'expense_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.expense.expense_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('expenses.show',['expense' => $expense->id, 'group' => 'reminders']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'reminders') ? 'active' : ''}}">
            {{ __('messages.reminders') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('expenses.show',['expense' => $expense->id, 'group' => 'notes']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'notes') ? 'active' : ''}}">
            {{ __('messages.notes') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('expenses.show',['expense' => $expense->id, 'group' => 'comments']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'comments') ? 'active' : ''}}">
            {{ __('messages.comments') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

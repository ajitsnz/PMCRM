<ul class="nav nav-tabs mb-2" role="tablist">
    <li class="nav-item">
        <a href="{{ route('tasks.show',['task' => $task->id, 'group' => 'task_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'task_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.task.task_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tasks.show',['task' => $task->id, 'group' => 'reminders']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'reminders') ? 'active' : ''}}">
            {{ __('messages.reminders') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('tasks.show',['task' => $task->id, 'group' => 'comments']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'comments') ? 'active' : ''}}">
            {{ __('messages.comments') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

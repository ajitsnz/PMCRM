<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item">
        <a href="{{ route('projects.show',['project' => $project->id, 'group' => 'project_details']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'project_details' || !isset($groupName)) ? 'active' : ''}}">
            {{ __('messages.project.project_details') }}
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('projects.show',['project' => $project->id, 'group' => 'tasks']) }}"
           class="nav-link {{ (isset($groupName) && $groupName == 'tasks') ? 'active' : ''}}">
            {{ __('messages.tasks') }}
        </a>
    </li>
</ul>
<br>
@yield('section')

@component('mail::message')
# Hello {{ $projectMember->user->first_name }},

You are added into <b>{{ $project->project_name }}</b> as member.

Thanks & Regards,<br>
{{ config('app.name') }}
@endcomponent

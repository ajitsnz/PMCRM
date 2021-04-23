@component('mail::message')
# Hello {{ $reminder->user->full_name }},

This is the friendly reminder for your ticket you have been created on
<b>{{ date('jS M, Y g:i A', strtotime($reminder->created_at)) }}</b><br>

<b>Ticket Description</b>
<hr>
{!! html_entity_decode($reminder->description) !!}
<br>
You may contact us with your suitable time for your ticket & we are here to assist you 24/7.
<br>
Thanks & Regards,<br>
{{ config('app.name') }}
@endcomponent

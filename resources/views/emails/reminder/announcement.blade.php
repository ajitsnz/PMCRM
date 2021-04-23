@component('mail::message')
    # Hello,

    This is the friendly reminder announcement, created on <b>{{ date('jS M, Y g:i A', strtotime($created_at)) }}</b>
    <br>

    <b>Subject: </b> {{ $subject }}<br>
    &nbsp;&nbsp;&nbsp;{{ $message }}
    <br><br>

    Thanks & Regards,<br>
    {{ config('app.name') }}
@endcomponent

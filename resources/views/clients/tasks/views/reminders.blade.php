@extends('clients.tasks.show')
@section('section')
    <input type="hidden" name="owner_id" value="{{ $data['ownerId'] }}" id="ownerId">
    @include('clients.reminders.table')
@endsection

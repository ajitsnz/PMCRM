@extends('layouts.app')
@section('title')
    {{ __('messages.ticket.new_ticket') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.ticket.new_ticket') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="javascript:void(0)" class="btn btn-primary form-btn mr-2" id="ticketContactBtn">
                    <span id="ticketContact">{{__('messages.ticket.ticket_without_contact')}}</span> &nbsp;<i
                            class="fas fa-envelope"
                            id="ticketContactIcon"></i>
                </a>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ url()->previous() }}" class="btn btn-primary form-btn">
                    {{ __('messages.common.back') }}
                </a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'ticket.store','id' => 'createTicket','files' => true]) }}

                    @include('tickets.fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let predefinedReplyUrl = "{{ route('ticket.reply.body') }}/";
    </script>
    <script src="{{mix('assets/js/tickets/create-edit.js')}}"></script>
@endsection

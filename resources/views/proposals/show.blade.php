@extends('layouts.app')
@section('title')
    {{ __('messages.proposal.proposal_details') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sales/view-as-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/proposals/proposals.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.proposal.proposal_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                @if($proposal->status != \App\Models\Proposal::STATUS_DECLINED)
                <a href="{{ route('proposals.edit', ['proposal' => $proposal->id]) }}"
                   class="btn btn-warning mr-2 form-btn">{{ __('messages.common.edit') }}</a>
                @endif
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('proposals.show_fields')
                </div>
            </div>
        </div>
        @include('tasks.templates.templates')
        @include('reminders.templates.templates')
        @include('reminders.add_modal')
        @include('reminders.edit_modal')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let noteUrl = "{{ route('notes.index') }}/";
        let noteSaveUrl = "{{ route('notes.store') }}";
        let proposalId = "{{ $proposal->id }}";
        let reminderUrl = "{{ route('reminder.index') }}/";
        let reminderSaveUrl = "{{ route('reminder.store') }}";
        let changeStatus = "{{ route('proposal.change-status',$proposal->id) }}";
        let invoiceSaveUrl = "{{ route('proposal.convert-to-invoice',$proposal->id) }}";
        let estimateSaveUrl = "{{ route('proposal.convert-to-estimate',$proposal->id) }}";
        let invoiceUrl = "{{ route('invoices.index') }}";
        let estimateUrl = "{{ route('estimates.index') }}";
        let taskUrl = "{{ route('tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
        let ownerId = "{{ $proposal->id }}";
        let ownerType = 'App\\Models\\Proposal';
    </script>
    <script src="{{ mix('assets/js/proposals/show-page.js') }}"></script>
    <script src="{{ mix('assets/js/reminder/reminder.js')}}"></script>
    <script src="{{ mix('assets/js/tasks/tasks.js')}}"></script>
@endsection

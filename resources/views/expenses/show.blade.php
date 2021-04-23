@extends('layouts.app')
@section('title')
    {{ __('messages.expense.expense_details') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.expense.expense_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('expenses.edit', ['expense' => $expense->id]) }}"
                   class="btn btn-warning mr-2 form-btn">{{ __('messages.common.edit') }}</a>
                <a href="{{ route('expenses.index') }}" class="btn btn-primary form-btn">
                    {{ __('messages.common.back') }}
                </a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('expenses.show_fields')
                </div>
            </div>
        </div>
        @include('reminders.templates.templates')
        @include('reminders.add_modal')
        @include('reminders.edit_modal')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let reminderUrl = "{{ route('reminder.index') }}/";
        let reminderSaveUrl = "{{ route('reminder.store') }}";
        let noteUrl = "{{ route('notes.index') }}/";
        let noteSaveUrl = "{{ route('notes.store') }}";
        let commentUrl = "{{ route('comments.index') }}/";
        let commentSaveUrl = "{{ route('comments.store') }}";
        let expenseUrl = "{{ route('expenses.index') }}/";
        let expenseId = '{{ $expense->id }}';
        let authId = '{{ Auth::id() }}';
        let ownerId = "{{ $expense->id }}";
        let ownerUrl = "{{ route('expenses.index') }}";
        let isEdit = false;
    </script>
    <script src="{{ mix('assets/js/reminder/reminder.js') }}"></script>
    <script src="{{ mix('assets/js/notes/new-notes.js') }}"></script>
    <script src="{{ mix('assets/js/comments/new-comments.js') }}"></script>
    <script src="{{ mix('assets/js/expenses/create-edit.js') }}"></script>
@endsection

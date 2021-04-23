@extends('layouts.app')
@section('title')
    {{ __('messages.expenses') }}
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.expenses') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <div class="section-header-action mr-2">
                    {{ Form::select('expense_category',$expenseCategory,null,['id' => 'expenseCategory','class' => 'form-control','placeholder' => 'Select Expense Category']) }}
                </div>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('expenses.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @livewire('expenses')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let expenseUrl = "{{ route('expenses.index') }}";
        let downloadAttachmentUrl = "{{ url('admin/expense-attachment-download') }}";
    </script>
    <script src="{{ mix('assets/js/expenses/expenses.js') }}"></script>
@endsection

@extends('layouts.app')
@section('title')
    {{ __('messages.expense.edit_expense') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.expense.edit_expense') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('expenses.index') }}" class="btn btn-primary form-btn">
                    {{ __('messages.common.back') }}
                </a>
            </div>
        </div>
        @include('layouts.errors')
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($expense, ['route' => ['expenses.update', $expense->id], 'method' => 'put', 'id' => 'editExpense', 'files' => true]) }}

                    @include('expenses.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let isEdit = true;
    </script>
    <script src="{{mix('assets/js/expenses/create-edit.js')}}"></script>
    <script src="{{ mix('assets/js/custom/input-price-format.js')}}"></script>
    <script src="{{mix('assets/js/file-attachments/attachment.js')}}"></script>
@endsection

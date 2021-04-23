@extends('layouts.app')
@section('title')
    {{ __('messages.contract.edit_contract') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        @include('flash::message')
        <div class="section-header">
            <h1>{{ __('messages.contract.edit_contract') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('contracts.index') }}" class="btn btn-primary form-btn">
                    {{ __('messages.common.back') }}
                </a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($contract, ['route' => ['contracts.update', $contract->id],'id' => 'editContract', 'method' => 'put']) }}

                    @include('contracts.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_scripts')
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let editData = true;
    </script>
    <script src="{{mix('assets/js/contracts/create-edit.js')}}"></script>
    <script src="{{mix('assets/js/custom/input-price-format.js')}}"></script>
@endsection

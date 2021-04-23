@extends('layouts.app')
@section('title')
    {{ __('messages.contracts') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/contracts/contracts.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.contracts') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <div class="card-header-action mr-3">
                    {{Form::select('type', $typeArr, null, ['id' => 'filterType', 'class' => 'form-control status-filter', 'placeholder' => 'Select Contract Type']) }}
                </div>
            </div>
            <div class="float-right btn-alignment">
                <a href="{{ route('contracts.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.contract.add') }} <i
                            class="fas fa-plus"></i></a>
            </div>
        </div>
        @include('flash::message')
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('contracts')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let contractUrl = "{{ route('contracts.index') }}";
    </script>
    <script src="{{mix('assets/js/contracts/contracts.js')}}"></script>
@endsection

@extends('clients.layouts.app')

@section('title')
    {{ __('messages.contracts') }}
@endsection

@section('page_css')
    <link href="{{ mix('assets/css/clients/contracts/contracts.css') }}" rel="stylesheet" type="text/css"/>
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
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('clients.contracts')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page_scripts')
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let contractUrl = "{{ route('clients.contracts.index') }}";
        let viewAsCustomer = 'view-as-customer';
    </script>
    <script src="{{ mix('assets/js/clients/contracts/contracts.js') }}"></script>
@endsection

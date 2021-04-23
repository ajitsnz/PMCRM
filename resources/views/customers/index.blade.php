@extends('layouts.app')
@section('title')
    {{ __('messages.customer.customers') }}
@endsection
@section('css')
    @livewireStyles
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/customers/customers.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.customer.customers') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('customers.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @livewire('customers')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let customerUrl = "{{ route('customers.index') }}";
        let byDeleteThisCustomer = "{{ __('messages.customer.by_deleting_this_customer') }}";
        let deleteCustomerConfirm = "{{ __('messages.customer.delete_customer_confirm') }}";
    </script>
    <script src="{{mix('assets/js/customers/customers.js')}}"></script>
@endsection

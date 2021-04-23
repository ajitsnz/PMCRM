@extends('layouts.app')
@section('title')
    {{ __('messages.estimate.estimate_details') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sales/view-as-customer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/estimates/estimates.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.estimate.estimate_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                @if($estimate->status !== \App\Models\Estimate::STATUS_DECLINED && $estimate->status !== \App\Models\Estimate::STATUS_EXPIRED)
                    <a href="{{ route('estimates.edit', ['estimate' => $estimate->id]) }}"
                       class="btn btn-warning mr-2 form-btn btn-alignment">{{ __('messages.common.edit') }}</a>
                @endif
                <a href="{{ url()->previous() }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('estimates.show_fields')
                </div>
            </div>
        </div>
        @include('tasks.templates.templates')
    </section>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let estimateId = "{{ $estimate->id }}";
        let changeStatus = "{{ route('estimate.change-status',$estimate->id) }}";
        let invoiceSaveUrl = "{{ route('estimate.convert-to-invoice',$estimate->id) }}";
        let invoiceUrl = "{{ route('invoices.index') }}";
        let taskUrl = "{{ route('tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
        let ownerId = "{{ $estimate->id }}";
        let ownerType = 'App\\Models\\Estimate';
    </script>
    <script src="{{ mix('assets/js/tasks/tasks.js')}}"></script>
    <script src="{{ mix('assets/js/estimates/show-page.js') }}"></script>
@endsection

@extends('customers.show')
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/clients/estimates/estimates.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-header">
                    <div class="row w-100 justify-content-end">
                        <a href="{{ route('estimates.create', $customer->id) }}"
                           class="btn btn-primary form-btn add-button">{{ __('messages.common.add') }}
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('estimates', ['customer' => $customer->id])
                </div>
            </div>
        </div>
    </section>
@endsection
@push('page-scripts')
    @livewireScripts
    <script>
        let estimateUrl = "{{ route('estimates.index') }}";
    </script>
    <script src="{{ mix('assets/js/custom/get-price-format.js') }}"></script>
    <script src="{{ mix('assets/js/estimates/estimates-datatable.js') }}"></script>
@endpush

@extends('customers.show')
@section('page_css')
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ mix('assets/css/tickets/tickets.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('css')
    @livewireStyles
@endsection
@section('section')
    <section class="section">
        <div class="section-body mb-1">
            <div class="row w-100 justify-content-end">
                <a href="{{ route('ticket.create') }}"
                   class="btn btn-primary form-btn add-button mr-3">{{ __('messages.common.add') }}
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @livewire('tickets', ['customer' => $customer->id])
                </div>
            </div>
        </div>
    </section>
@endsection
@push('page-scripts')
    @livewireScripts
    <script>
        let ticketUrl = "{{ route('ticket.index') }}/";
    </script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ mix('assets/js/status-counts/status-counts.js') }}"></script>
    <script src="{{ mix('assets/js/tickets/tickets.js') }}"></script>
@endpush

@extends('customers.show')
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
                        <a href="{{ route('credit-notes.create', $customer->id) }}"
                           class="btn btn-primary form-btn add-button">{{ __('messages.common.add') }}
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('credit-notes',['customer' => $customer->id])
                </div>
            </div>
        </div>
    </section>
@endsection
@push('page-scripts')
    @livewireScripts
    <script>
        let creditNoteUrl = "{{ route('credit-notes.index') }}";
    </script>
    <script src="{{ mix('assets/js/custom/get-price-format.js') }}"></script>
    <script src="{{ mix('assets/js/credit-notes/credit-notes-datatable.js') }}"></script>
@endpush

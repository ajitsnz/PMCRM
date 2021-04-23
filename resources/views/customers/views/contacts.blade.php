@extends('customers.show')
@section('page_css')
    <link href="{{ mix('assets/css/customers/contact-details.css') }}" rel="stylesheet" type="text/css"/>
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
                        <a href="{{ route('contacts.create', $customer->id) }}"
                           class="btn btn-primary form-btn add-button">{{ __('messages.common.add') }}
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('customer-detail-contacts', ['contactId' => $customer->id])
                </div>
            </div>
        </div>
    </section>
@endsection
@push('page-scripts')
    @livewireScripts
    <script>
        let contactUrl = "{{ route('contacts.index') }}/";
        let byDeleteThisContact = "{{ __('messages.contact.by_deleting_this_contact') }}";
        let deleteContactConfirm = "{{ __('messages.contact.delete_contact_confirm') }}";
    </script>
    <script src="{{mix('assets/js/contacts/contacts.js')}}"></script>
@endpush

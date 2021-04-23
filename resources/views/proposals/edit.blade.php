@extends('layouts.app')
@section('title')
    {{ __('messages.proposals') }}
@endsection
@section('page_css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bs4-summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/proposals/proposals.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.proposal.edit_proposal') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ url()->previous() }}" class="btn btn-primary form-btn">
                    {{ __('messages.common.back') }}
                </a>
            </div>
        </div>
        <div class="section-body">
            @include('layouts.errors')
            <div class="card">
                {{ Form::open(['route' => ['proposals.update', $proposal->id], 'validated' => false, 'method' => 'POST', 'id' => 'editProposalForm']) }}
                @include('proposals.address_modal')
                @include('proposals.edit_fields')
                {{ Form::close() }}
            </div>
        </div>
    </section>
    @include('proposals.templates.templates')
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/bs4-summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ mix('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/int-tel/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('assets/js/int-tel/js/utils.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let proposalEdit = true;
        let taxData = JSON.parse('@json($data['taxes'])');
        let itemUrl = "{{ route('items.index') }}";
        let proposalEditURL = "{{ route('proposals.index') }}";
        let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";
        let isEdit = true;
        let phoneNo = "{{ old('prefix_code').old('phone') }}";
        let editData = true;
        let editProposalAddress = true;
        let customerURL = "{{ route('get.proposal.customer.address') }}";
    </script>
    <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>
    <script src="{{ mix('assets/js/sales/sales.js') }}"></script>
    <script src="{{ mix('assets/js/custom/input-price-format.js') }}"></script>
    <script src="{{ mix('assets/js/proposals/proposals.js') }}"></script>
@endsection

@extends('layouts.app')
@section('title')
    {{ __('messages.members') }}
@endsection
@section('css')
    @livewireStyles
@endsection
@section('content')
    <section class="section">
        <div class="section-header m-section">
            <h1>{{ __('messages.members') }}</h1>
            <div class="section-header-breadcrumb btn-alignment m-section-header">
                <div class="card-header-action mr-3">
                    {{ Form::select('is_enable',$memberStatus, 2 ,['id' => 'memberStatus','class' => 'form-control']) }}
                </div>
                <a href="{{ route('members.create') }}"
                   class="btn btn-primary form-btn">{{ __('messages.member.add') }} <i
                            class="fas fa-plus"></i></a>
            </div>
        </div>
        @include('flash::message')
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @livewire('members')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    @livewireScripts
    <script>
        let memberUrl = "{{ route('members.index') }}";
        let getLoginUserId = "{{ getLoggedInUserId() }}";
        let byDeleteThisMember = "{{ __('messages.member.by_deleting_this_member') }}";
        let deleteMemberConfirm = "{{ __('messages.member.delete_member_confirm') }}";
    </script>
    <script src="{{ mix('assets/js/members/member.js') }}"></script>
@endsection

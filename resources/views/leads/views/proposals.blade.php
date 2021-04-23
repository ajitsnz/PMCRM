@extends('leads.show')
@section('page_css')
    <link rel="stylesheet" href="{{ mix('assets/css/proposals/proposals.css') }}">
@endsection
@section('css')
    @livewireStyles
@endsection
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="row w-100 justify-content-end">
                <div class="justify-content-end mr-4">
                    {{Form::select('status', $statusArr, null, ['id' => 'filterStatus', 'class' => 'form-control status-filter','placeholder' => 'Select Status']) }}
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @livewire('proposals',['lead' => $lead->id])
                </div>
            </div>
        </div>
    </section>
@endsection

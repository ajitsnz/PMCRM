@extends('leads.show')
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="row w-100 justify-content-end">
                <div class="justify-content-end mr-2">
                    {{ Form::select('status',$status,null,['class' => 'form-control', 'id' => 'filter_status', 'placeholder' => 'Select Status']) }}
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @include('tasks.table')
                </div>
            </div>
        </div>
    </section>
@endsection

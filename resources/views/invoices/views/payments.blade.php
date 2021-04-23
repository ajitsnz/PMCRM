@extends('invoices.show')
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-body">
                    @include('payments.table')
                </div>
            </div>
        </div>
    </section>
@endsection

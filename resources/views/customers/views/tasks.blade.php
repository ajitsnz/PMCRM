@extends('customers.show')
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="card">
                <div class="card-header">
                    <div class="row w-100 justify-content-end">
                        <div class="justify-content-end mr-2">
                            {{ Form::select('status',$status,null,['id' => 'filter_status', 'class' => 'form-control', 'placeholder' => 'Select Status']) }}
                        </div>
                        <div>
                            <a href="{{ route('tasks.create', ['Customer', $customer->id]) }}"
                               class="btn btn-primary form-btn add-button">{{ __('messages.common.add') }}
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('tasks.table')
                </div>
            </div>
        </div>
        @include('tasks.templates.templates')
    </section>
@endsection
@push('page-scripts')
    <script>
        let taskUrl = "{{ route('tasks.index') }}";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
    </script>
    <script src="{{mix('assets/js/tasks/tasks.js')}}"></script>
@endpush

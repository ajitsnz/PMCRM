@extends('members.show')
@section('section')
    <section class="section">
        <div class="section-body">
            @include('flash::message')
            <div class="row w-100 justify-content-end">
                <div class="justify-content-end mr-2">
                    {{ Form::select('status',$status,null,['id' => 'filter_status', 'class' => 'form-control', 'placeholder' => 'Select Status']) }}
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @include('members.views.member_task_table')
                </div>
            </div>
        </div>
    </section>
@endsection
@push('page-scripts')
    <script>
        let taskUrl = "{{ route('tasks.index') }}/";
        let statusArray = JSON.parse('@json($status)');
        let priorities = JSON.parse('@json($priorities)');
    </script>
    <script src="{{mix('assets/js/tasks/member-task.js')}}"></script>
@endpush

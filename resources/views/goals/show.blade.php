@extends('layouts.app')
@section('title')
    {{ __('messages.goal.goal_details') }}
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.goal.goal_details') }}</h1>
            <div class="section-header-breadcrumb btn-alignment">
                <a href="{{ route('goals.edit', ['goal' => $goal->id]) }}"
                   class="btn btn-warning mr-2 form-btn">{{ __('messages.common.edit') }}</a>
                <a href="{{ route('goals.index') }}"
                   class="btn btn-primary form-btn">{{ __('messages.common.back') }}</a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('goals.show_fields')
                </div>
            </div>
        </div>
    </section>
@endsection

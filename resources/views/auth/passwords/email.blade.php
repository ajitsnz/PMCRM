@extends('layouts.auth')
@section('title')
    {{__('messages.email.forgot_password')}}
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>{{__('messages.email.reset_password')}}</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">{{__('messages.email.send_reset_link')}}:</label><span
                            class="text-danger">*</span>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" tabindex="1" value="{{ old('email') }}" autofocus required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        {{__('messages.email.send_reset_link')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        {{__('messages.reset.recalled_your_login_info')}} <a
                href="{{ route('login') }}">{{__('messages.reset.sign_in')}}</a>
    </div>
@endsection

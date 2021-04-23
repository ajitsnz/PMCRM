@extends('layouts.auth')
@section('title')
    {{__('messages.reset.reset_password')}}
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>{{__('messages.reset.set_a_new_password')}}</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email">{{__('messages.reset.email')}}:</label><span class="text-danger">*</span>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" tabindex="1" value="{{ old('email') }}" autofocus>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">{{__('messages.reset.password')}}"</label><span
                            class="text-danger">*</span>
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                           tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="control-label">{{__('messages.reset.confirm_password')}}
                        :</label><span
                            class="text-danger">*</span>
                    <input id="password_confirmation" type="password"
                           class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                           name="password_confirmation" tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        {{__('messages.reset.set_a_new_password')}}
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

@extends('layouts.auth')
@section('title')
    {{__('messages.login.login')}}
@endsection
@section('content')
    <div class="card card-primary">
        @include('flash::message')
        <div class="card-header"><h4>{{__('messages.login.login')}}</h4></div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="email">{{__('messages.login.email')}}:</label><span class="text-danger">*</span>
                    <input aria-describedby="emailHelpBlock" id="email" type="email"
                           class="form-control{{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                           placeholder="Enter Email" tabindex="1"
                           value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus
                           required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">{{__('messages.login.password')}}:</label><span
                                class="text-danger">*</span>
                        <div class="float-right">
                            <a href="{{ route('password.request') }}" class="text-small">
                                {{__('messages.login.forgot_password')}}
                            </a>
                        </div>
                    </div>
                    <input aria-describedby="passwordHelpBlock" id="password" type="password"
                           placeholder="Enter Password"
                           class="form-control{{ $errors->has('password') ? 'is-invalid': '' }}" name="password"
                           value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                           tabindex="2" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                               id="remember" {{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{__('messages.login.remember_me')}}</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        {{__('messages.login.login')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

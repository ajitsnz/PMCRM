@extends('layouts.auth')
@section('title')
    {{__('messages.register.register')}}
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>{{__('messages.register.register')}}</h4></div>

        <div class="card-body pt-1">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">{{__('messages.register.first_name')}}:</label><span
                                    class="text-danger">*</span>
                            <input id="firstName" type="text"
                                   class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                   name="first_name"
                                   tabindex="1" placeholder="Enter First Name" value="{{ old('first_name') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('first_name') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">{{__('messages.register.last_name')}}:</label><span
                                    class="text-danger">*</span>
                            <input id="lastName" type="text"
                                   class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                   name="last_name"
                                   tabindex="1" placeholder="Enter Last name" value="{{ old('last_name') }}" required
                                   autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('last_name') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">{{__('messages.register.email')}}:</label><span
                                    class="text-danger">*</span>
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="Enter Email address" name="email" tabindex="1"
                                   value="{{ old('email') }}"
                                   required autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">{{__('messages.register.phone')}}:</label>
                            <input id="phone" type="text"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   placeholder="Enter Phone Number" name="phone" tabindex="1" value="{{ old('phone') }}"
                                   autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">{{__('messages.register.password')}}
                                :</label><span
                                    class="text-danger">*</span>
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                   placeholder="Set account password" name="password" tabindex="2" required>
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation"
                                   class="control-label">{{__('messages.register.confirm_password')}}:</label><span
                                    class="text-danger">*</span>
                            <input id="password_confirmation" type="password" placeholder="Confirm account password"
                                   class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                   name="password_confirmation" tabindex="2">
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="profile_picture"
                                   class="control-label">{{__('messages.register.profile_picture')}}:</label>
                            <div class="custom-file">
                                <input type="file" name="profile_picture" class="custom-file-input" id="customFile">
                                <label class="custom-file-label"
                                       for="customFile">{{__('messages.register.choose')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                {{__('messages.register.register')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        {{__('messages.register.already_have_an_account')}} <a
                href="{{ route('login') }}">{{__('messages.register.sign_in')}}</a>
    </div>
@endsection

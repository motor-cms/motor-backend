@extends('motor-backend::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
    <body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Login</h1>
                            <p class="text-muted">{{ trans('motor-backend::backend/login.sign_in_text') }}</p>
                            <form action="{{ url('/login') }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="icon-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="email" class="form-control"
                                           placeholder="{{ trans('motor-backend::backend/users.email') }}">
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="icon-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="{{ trans('motor-backend::backend/users.password') }}">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="checkbox" name="remember" id="remember"> <label
                                                for="remember">{{ trans('motor-backend::backend/login.remember') }}</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit"
                                                class="btn btn-primary px-4">{{ trans('motor-backend::backend/login.sign_in') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                        <div class="card-body text-center">
                            <div>
                                <h2>{{ config('motor-backend-project.name') }}</h2>
                                <img src="{{ config('motor-backend-project.logo-white') }}" style="max-width: 100%;
                                max-height: 200px;"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('motor-backend::layouts.partials.scripts_auth')

@endsection

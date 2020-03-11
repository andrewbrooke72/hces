@extends('templates.welcome')
@section('title', 'Login')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Login</h1>
                            <p class="text-muted">Sign In to your account</p>
                            @include('snippets.dialogs')
                            <form method="POST" action="{{ route('authenticate') }}">
                                {{ csrf_field() }}
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" required
                                           autofocus placeholder="Email">
                                </div>
                                <div class="input-group mb-4">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                           required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-arsenal-blue px-4">Login</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('reset.index') }}" class="btn text-muted btn-link px-0">Forgot password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card text-white bg-arsenal-blue py-5 d-md-down-none" style="width:44%">
                        <div class="card-body text-center">
                            <div>
                                <h2 align="left">{{ env('APP_NAME') }}</h2>
                                <p align="left">Not your casual HR system</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additionalJS')
@endsection

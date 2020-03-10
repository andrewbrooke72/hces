@extends('templates.welcome')
@section('title', 'Reset Password')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Reset</h1>
                            <p class="text-muted">Reset your password</p>
                            @include('snippets.dialogs')
                            <form method="POST" action="{{ route('reset.store') }}">
                                {{ csrf_field() }}
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" required
                                           autofocus placeholder="Email">
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-arsenal-blue btn-block px-4">Reset</button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <center>
                                            <a href="{{ route('login') }}" class="text-muted px-4">Remembered your password?</a>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card text-white bg-arsenal-blue py-5 d-md-down-none" style="width:44%">
                        <div class="card-body text-center">
                            <div>
                                <h2 align="left">Password Reset</h2>
                                <p align="left">Arsenal will send you an email containing a link to reset your password.</p>
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

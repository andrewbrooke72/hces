@extends('templates.welcome')
@section('title', 'Setup')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            @if(\HCES\SystemSetting::first()->finished_setup == 0)
                                <form action="{{ route('postSystemInstall') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <h2 class="card-title text-dark"><img style="width: 98px; height: 32px;" src="{{ URL::asset('img/banner.png') }}"></h2>
                                            <hr>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <h5 class="card-title text-muted">Organization Section</h5>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="organization-name-addon"><i class="fas fa-building"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="organization_name" value="{{ old('organization_name') }}" placeholder="Organization name"
                                                       aria-label="Org name"
                                                       aria-describedby="organization-name-addon"
                                                       required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="organization-website-addon"><i class="fas fa-building"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="organization_website" value="{{ old('organization_website') }}" placeholder="Organization website"
                                                       aria-label="Org site"
                                                       aria-describedby="organization-website-addon">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <h5 class="card-title text-muted">User Section</h5>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="firstname-addon"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First name" aria-label="First name"
                                                       aria-describedby="firstname-addon" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="lastname-addon"><i class="fas fa-users"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" aria-label="Last name"
                                                       aria-describedby="lastname-addon"
                                                       required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="email-addon">@</span>
                                                </div>
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" aria-label="Email" aria-describedby="email-addon"
                                                       required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="password-addon"><i class="fas fa-lock"></i></span>
                                                </div>
                                                <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="confirm-password-addon"><i class="fas fa-lock"></i></span>
                                                </div>
                                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" aria-label="Confirm Password"
                                                       aria-describedby="confirm-password-addon"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            @include('snippets.dialogs')
                                            <button class="btn btn-arsenal-blue btn-block">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div>
                                    <center>
                                        <h2 class="card-title text-dark">Not available</h2>
                                        <a href="/" class="btn btn-danger pull-right">To the batmobile</a>
                                    </center>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card text-white bg-arsenal-blue py-5 d-md-down-none" style="width:44%">
                        <div class="card-body text-center">
                            <div>
                                <h2 align="left">System Setup</h2>
                                <p align="left">This will be a one time process make sure to fill the correct details.</p>
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

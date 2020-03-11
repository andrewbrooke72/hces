@extends('templates.master')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> @include('snippets.pagename')
                            <a href="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.index') }}"
                               class="btn btn-primary float-right text-light">Browse</a>
                        </div>
                        <div class="card-body">
                            @include('snippets.dialogs')
                            <form id="main-form" action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.update', ['id' => $user->id]) }}" method="POST">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="input-group">
                                            <input class="form-control" value = "{{ $user->first_name }}" type="text" name="first_name" placeholder="First name"
                                                   required>
                                            <input class="form-control" value = "{{ $user->last_name }}" type="text" name="last_name" placeholder="Last name"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="input-group">
                                            <input class="form-control" value = "{{ $user->email }}" type="text" name="email" placeholder="Email"
                                                   required>
                                            <input class="form-control" value = "" type="password" name="password" placeholder="Password"
                                                   >
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row" style="padding: 24px">
                                    @foreach($permissions as $index => $permission)
                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                            <div class="form-check">
                                                <input name = "permissions[]" type="checkbox" value="{{ $permission->id }}"
                                                       class="form-check-input" id="{{ $index }}" {{ !is_null($user->permissions->where('id', $permission->id)->first()) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                       for="{{ $index }}">{{ ucwords(str_replace('.', ' ', $permission->name)) }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type = "submit" class = "btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additionalJS')
@endsection

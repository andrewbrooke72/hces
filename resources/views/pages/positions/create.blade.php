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
                            <form id="main-form"
                                  action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.store') }}"
                                  method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="input-group">
                                            <select class="form-control" required name="rank">
                                                <option value="" selected disabled>Ranking</option>
                                                @for($rank = 1; $rank < ($highest_rank + 2); $rank++)
                                                    <option value="{{ $rank }}">{{ $rank }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ old('name') }}" type="text"
                                                   name="name" placeholder="Name"
                                                   required>
                                            <input class="form-control" value="{{ old('description') }}" type="text"
                                                   name="description" placeholder="Description"
                                                   required>
                                            <select class="form-control" required name="employment_status">
                                                <option value="" selected disabled>Employment Status</option>
                                                @foreach(\HCES\Enums\PositionEnums::employment_statuses as $status)
                                                    <option value="{{ $status }}">{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ old('rate') }}" type="number"
                                                   name="rate" placeholder="Rate"
                                                   required>
                                            <select class="form-control" required name="rate_type">
                                                <option value="" selected disabled>Rate Type</option>
                                                @foreach(\HCES\Enums\PositionEnums::rate_types as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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

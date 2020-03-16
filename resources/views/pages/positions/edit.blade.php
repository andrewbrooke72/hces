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
                                  action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.update', ['id' => $position->id]) }}"
                                  method="POST">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="input-group">
                                            <select class="form-control" required name="rank">
                                                @for($rank = 1; $rank < ($highest_rank + 2); $rank++)

                                                    <option
                                                        value="{{ $rank }}" {{ $position->rank == $rank ? 'selected' : ''}}>
                                                        {{ $rank }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ $position->name }}" type="text"
                                                   name="name" placeholder="Name"
                                                   required>
                                            <input class="form-control" value="{{ $position->description }}" type="text"
                                                   name="description" placeholder="Description"
                                                   required>
                                            <select class="form-control" required name="employment_status">
                                                @foreach(\HCES\Enums\PositionEnums::employment_statuses as $status)
                                                    <option
                                                        value="{{ $status }}" {{ $position->employment_status == $status ? 'selected' : ''}}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ $position->rate }}" type="number"
                                                   name="rate" placeholder="Rate"
                                                   required>
                                            <select class="form-control" required name="rate_type">
                                                @foreach(\HCES\Enums\PositionEnums::rate_types as $type)
                                                    <option value="{{ $type }}" {{ $position->rate_type == $type ? 'selected' : '' }}>{{ $type }}</option>
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

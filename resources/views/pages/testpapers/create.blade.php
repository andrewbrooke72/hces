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
                                        <input class="form-control" value="{{ old('name') }}" type="text"
                                               name="name" placeholder="Name"
                                               required>
                                    </div>
                                    <br><br>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input class="form-control" min="0" type="number"
                                               name="number_of_questions" placeholder="Number of questions"
                                               required>
                                    </div>
                                    <br><br>
                                    <div class="col-lg-12 col-md-12 col-sm-12">

                                        <input class="form-control" value="{{ old('passing_score') }}" type="number"
                                               name="passing_score" placeholder="Passing Score %"
                                               required>
                                    </div>
                                    <br><br>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input class="form-control" value="{{ old('slide_url') }}" type="url"
                                               name="slide_url" placeholder="Google Slide URL"
                                               required>
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

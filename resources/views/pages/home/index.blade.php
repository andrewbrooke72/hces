@extends('templates.master')
@section('content')
    <div class="container-fluid">
        <div class="animate fadeIn">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card-group h-100 w-100">
                        <div class="card p-12 border-0">
                            <div class="card-body">
                                <center><h3 class="text-muted">HELLO! {{ auth()->user()->first_name }} let's be
                                        productive today.</h3></center>
                                @if(auth()->user()->hasPermission('agent.*'))
                                    <a href="{{ route('exams.index') }}" class = "btn btn-block btn-arsenal-blue">Click here to take your exam.</a>
                                @endif

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

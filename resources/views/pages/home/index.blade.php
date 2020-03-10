@extends('templates.master')
@section('content')
    <div class="container-fluid">
        <div class="animate fadeIn">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card-group h-100 w-100">
                        <div class="card p-12 border-0">
                            <div class="card-body">
                                <label id="list-to-suppression-last-ran"></label>
                                <canvas id="list-to-suppression-chart" width="400" height="400"></canvas>
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

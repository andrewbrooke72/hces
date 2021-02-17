@extends('templates.exam')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 col-md-12">
                                    @include('snippets.dialogs')
                                    <iframe src="{{ $slide }}" frameborder="0" width="100%" height="749"
                                            allowfullscreen="true" mozallowfullscreen="true"
                                            webkitallowfullscreen="true"></iframe>
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                                <div class="col-sm-12 col-md-12">
                                    <a href="{{ route('exams.loadexam', ['id' => $test_paper_id]) }}"
                                       class="btn btn-arsenal-blue btn-block">I'm ready to take
                                        the exam</a>
                                </div>
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

@extends('templates.exam')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Exam flow:</h4>
                            <div class="row">
                                @foreach($module->testpapers as $index => $testpaper)
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <iframe src="{{ $testpaper->slide_url }}"
                                                        style="width: 100%;"></iframe>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <p style="margin: 25%; font-style: strong;">
                                                    <i class="icon-arrow-right"></i>
                                                    Take exam
                                                    @if($index + 1 < $module->testpapers->count())
                                                        <i class="icon-arrow-right"></i>
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <hr>
                                <div class="col-sm-12 col-md-12">
                                    <a href="{{ route('exams.loadslide', ['id' => encrypt($module->testpapers->first()->id)]) }}"
                                       class="btn btn-arsenal-blue btn-block">I'm ready to start</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

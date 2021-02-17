@extends('templates.master')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @include('snippets.dialogs')
                    <div class="row">
                        @foreach($module->testpapers as $index => $test_paper)
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <form method="POST" action="{{ route('modules.resort') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="module_id" value="{{ $module->id }}">
                                            <input type="hidden" name="from" value="{{ $test_paper->id }}">
                                            <div class="input-group">
                                                <select name="to" class="form-control" required>
                                                    <option selected value="" disabled>Move Section Before</option>
                                                    @foreach($module->testpapers->where('id', '!=', $test_paper->id) as $indexpaper => $paper)
                                                        @if($indexpaper > $index + 1 || $indexpaper < $index)
                                                            <option value="{{ $paper->id }}">{{ $paper->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn-arsenal-blue">Re-sort</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                {{ $test_paper->name }}
                                                <hr>
                                                <iframe src="{{ $test_paper->slide_url }}"></iframe>
                                            </div>
                                            <div class="col-sm-12 col-md-8 col-lg-8"
                                                 style="border-left: 1px solid lightgrey">
                                                <div class="row">
                                                    @foreach($test_paper->questions as $question)
                                                        <div class="col-sm-12 col-md-3 col-lg-3">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <label> {{ $question->name }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form action="{{ route('modules.update', ['id' => $module->id]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <select class="form-control" name="test_paper_id" required>
                                    <option selected disabled>Select Test Paper</option>
                                    @foreach($test_papers as $test_paper)
                                        <option value="{{ $test_paper->id }}">{{ $test_paper->name }}</option>
                                    @endforeach
                                </select>
                                <button data-toggle="modal" type="submit"
                                        class="btn btn-arsenal-blue btn-block"><i class="icon-plus"></i></button>
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

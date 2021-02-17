@extends('templates.exam')
@section('content')
    <div class="container">
        <div class="animated fadeIn">
            <form action="{{ route('exams.submit', ['id' => encrypt($test_paper->id)]) }}" method="POST">
                {{ csrf_field() }}
                <input type = "hidden" value = "{{ $question_ids }}" name = 'qid' required>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        @foreach($compiled_questions as $questions)
                            @foreach($questions as $question)
                                <div class="card">
                                    <div class="card-header">
                                        {!! $question->question !!}
                                    </div>
                                    <div class="card-body" style="padding-left: 5%;">
                                        @if($question->type == 'single')
                                            @foreach($question->choices as $choice)
                                                <div class="form-check">
                                                    <input required class="form-check-input" type="radio"
                                                           name="{{ $question->id . '_answers' }}"
                                                           id="{{ $question->id . '_answers' }}"
                                                           value="{{ $choice->id }}">
                                                    <label class="form-check-label"
                                                           for="{{ $question->id . '_answers' }}">
                                                        {{ $choice->value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if($question->type == 'multiple')
                                            @foreach($question->choices as $choice)
                                                <div class="form-check">
                                                    <input class="form-check-input browsers" type="checkbox"
                                                           name="{{ $question->id . '_answers[]' }}"
                                                           id="{{ $question->id . '_answers' }}"
                                                           value="{{ $choice->id }}">
                                                    <label class="form-check-label"
                                                           for="{{ $question->id . '_answers' }}">
                                                        {{ $choice->value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button type="submit" class="btn btn-block btn-arsenal-blue">Submit my answers</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('additionalJS')

@endsection

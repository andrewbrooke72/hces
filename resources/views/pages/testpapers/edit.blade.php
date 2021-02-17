@extends('templates.master')
@section('content')
    <div class="modal fade" id="question-create-modal" tabindex="-1" role="dialog"
         aria-labelledby="question-create-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('testpaperquestion.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create a question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $test_paper->id }}" name="test_paper_id">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="text" class="form-control" placeholder="Name" name="name" required>
                            </div>
                            <hr>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                    <textarea name="question" class="question-editor" id="question-editor" rows="10" cols="80">
                Type your question here...
                    </textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 input-group">
                                <input type="text" class="form-control" name="file_page_reference"
                                       placeholder="Page reference" required>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 input-group">
                                <select name="type" class="form-control">
                                    <option selected disabled>Select Question Type</option>
                                    <option value="single">Single</option>
                                    <option value="multiple">Multiple</option>
                                </select>
                                <select name="is_star" class="form-control">
                                    <option value="0" selected>NOT STAR</option>
                                    <option value="1">STAR</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="text-muted">Choices</label>
                                <div id="choices-display" class="form-control">

                                </div>
                                <button type="button" id="choices-add"
                                        class="btn btn-arsenal-blue btn-block"><i class="icon-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @include('snippets.dialogs')
                    <div class="row">
                        @foreach($test_paper->questions as $question)
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <form action="{{ route('testpaperquestion.destroy', ['id' => $question->id]) }}"
                                              method="POST">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn pull-right btn-danger"><i class="icon-trash"></i>
                                            </button>
                                        </form>
                                        <i class="icon-star {{ $question->is_star ? 'text-warning' : 'text-muted' }}"></i>
                                        {{ $question->name }}

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-12 col-md-12">
                                                <form
                                                    action="{{ route('testpaperquestion.update', ['id' => $question->id]) }}"
                                                    method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PUT') }}
                                                    <input type = "text" name = "name" class="form-control" value = "{{ $question->name }}" required>
                                                    <textarea name="question" class="question-editor"
                                                              id="{{ $question->id }}-editor" rows="10"
                                                              cols="80">
                {{ $question->question }}
                    </textarea>
                                                    <button type="submit" class="btn btn-block btn-arsenal-blue">Save Question Body
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-sm-12 col-lg-12 col-md-12">
                                                <hr>
                                                @foreach($question->choices as $choice)
                                                    <form
                                                        action="{{ route('questionchoice.update', ['id' => $choice->id]) }}"
                                                        method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PUT') }}
                                                        <div class="input-group">

                                                            <input type="text" placeholder="Value" name="value"
                                                                   value="{{ $choice->value }}"
                                                                   class="form-control" required/>
                                                            <input type="number" placeholder="Points" name="points"
                                                                   value="{{ $choice->points }}"
                                                                   class="form-control" required/>
                                                            <button type="submit" class="btn btn-arsenal-blue"><i
                                                                    class="fa fa-save"></i></button>
                                                            <button type="button"
                                                                    onclick="{{ '$("#'.$choice->id.'-deleteform").submit();' }}"
                                                                    class="btn btn-danger"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </div>
                                                    </form>
                                                    <form id="{{ $choice->id . '-deleteform' }}"
                                                          action="{{ route('questionchoice.destroy', ['id' => $choice->id]) }}"
                                                          method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                    <br>
                                                @endforeach
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <hr>
                                                <small class="text-muted">Add more choices
                                                    to {{ $question->name }}</small>
                                                <form action="{{ route('questionchoice.store') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $question->id }}"
                                                           name="test_paper_question_id">
                                                    <div class="input-group">
                                                        <input type="text" name="value" placeholder="Value"
                                                               class="form-control" required>
                                                        <input type="number" name="points" placeholder="Points"
                                                               class="form-control" required>
                                                        <button class="btn btn-arsenal-blue"><i class="icon-plus"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button data-toggle="modal" data-target="#question-create-modal"
                                    class="btn btn-arsenal-blue btn-block"><i class="icon-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additionalJS')
    <script>
        $(function () {
            $('.question-editor').each(function (e) {
                CKEDITOR.replace(this.id, {customConfig: '/jblog/ckeditor/config_Large.js'});
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#choices-add').click(function () {
                var choices = $('<input type="text" placeholder="Value" name = "choices[]" class="form-control" required/>');
                var points = $('<input type="number" placeholder="Points" name = "points[]" class="form-control" required/>');
                var delete_button = $('<button type="button" class = "btn btn-danger" onclick="$(this).parent().remove();"><i class = "icon-trash"></i></button>');
                var wrapper = $('<div class = "input-group"></div>');
                wrapper.append(choices);
                wrapper.append(points);
                wrapper.append(delete_button);
                $('#choices-display').append(wrapper);
            });
        });
    </script>
@endsection

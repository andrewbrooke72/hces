@extends('templates.master')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> @include('snippets.pagename')
                            <a href="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.create') }}"
                               class="btn btn-primary float-right text-light">Create</a>
                        </div>
                        <div class="card-body">
                            @include('snippets.dialogs')
                            <table class="table table-responsive-sm">
                                <thead>
                                <tr>
                                    <th>Slide</th>
                                    <th>Number of questions</th>
                                    <th>Name</th>
                                    <th>Questions</th>
                                    <th>Total Score</th>
                                    <th>Passing Score</th>
                                    <th>Date created</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($test_papers as $test_paper)
                                    <div style="display: none !important;">
                                        {{ $sum = 0 }}
                                        @foreach($test_paper->questions as $question)
                                            {{ $sum += $question->choices->sum('points') }}
                                        @endforeach
                                    </div>
                                    <tr>
                                        <td><a target="_blank" href = "{{ $test_paper->slide_url }}">View slide</a></td>
                                        <td>{{ $test_paper->number_of_questions }}</td>
                                        <td>{{ $test_paper->name }}</td>
                                        <td>{{ number_format($test_paper->questions->count()) }}</td>
                                        <td>{{ number_format($sum) }}</td>
                                        <td>{{ $test_paper->passing_score }}%</td>
                                        <td>{{ $test_paper->created_at }}</td>
                                        <td>
                                            <a href="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.edit', ['id' => $test_paper->id]) }}"
                                               class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <form onsubmit="return confirm('Do you really want to delete this testpaper?');"
                                                  action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.destroy', ['id' => $test_paper->id]) }}"
                                                  method="post">
                                                {{ csrf_field()  }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $test_papers->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

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
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Employment Status</th>
                                    <th>Rate</th>
                                    <th>Rate type</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($positions as $position)
                                    <tr>
                                        <td>
                                            {{ $position->rank }}
                                        </td>
                                        <td>
                                            {{ ucwords($position->name) }}
                                        </td>
                                        <td>
                                            {{ $position->description }}
                                        </td>
                                        <td>
                                            {{ $position->employment_status }}
                                        </td>
                                        <td>
                                            {{ $position->rate }}
                                        </td>
                                        <td>
                                            {{ $position->rate_type }}
                                        </td>
                                        <td>
                                            <a href="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.edit', ['id' => $position->id]) }}"
                                               class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <form
                                                onsubmit="return confirm('Do you really want to delete this variable? It will detach any employee on this position.');"
                                                action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.destroy', ['id' => $position->id]) }}"
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
                            {{ $positions->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

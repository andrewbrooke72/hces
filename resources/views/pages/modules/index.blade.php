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
                                    <th></th>
                                    <th>Name</th>
                                    <th>Date created</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($modules as $module)
                                    <tr>
                                        <td>
                                            @if($module->is_active == 0)
                                                <form action="{{ route('modules.setAsMain', ['id' => $module->id]) }}"
                                                      method="POST">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-arsenal-blue">Set as main
                                                    </button>
                                            @else
                                                        <label>MAIN</label>
                                            @endif
                                        </td>
                                        <td>{{ $module->name }}</td>
                                        <td>{{ $module->created_at }}</td>
                                        <td>
                                            <a href="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.edit', ['id' => $module->id]) }}"
                                               class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <form
                                                onsubmit="return confirm('Do you really want to delete this module?');"
                                                action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.destroy', ['id' => $module->id]) }}"
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
                            {{ $modules->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

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
                                    <th>Fullname</th>
                                    <th>Shift</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td>
                                            <form id="{{ $employee->id . '-activation' }}" method="POST"
                                                  action="{{ route('employees.toggleActive', ['id' => $employee->id]) }}">
                                                {{ csrf_field() }}
                                                <label class="switch switch-text switch-pill switch-success switch-sm">
                                                    <input type="checkbox"
                                                           class="switch-input" onchange="$('{{ '#'.$employee->id . '-activation' }}').submit();" {{ $employee->is_active ? 'checked' : '' }}>
                                                    <span class="switch-label" data-on="ACT" data-off="IACT"></span>
                                                    <span class="switch-handle"></span>
                                                </label>
                                            </form>
                                        </td>
                                        <td>
                                            <img style="width: 65px; height: 65px;"
                                                 src="{{ route('image.load', ['disk' => encrypt('employee_photos'), !is_null($employee->photo) ? encrypt($employee->photo) : encrypt('null.png')]) }}"/>
                                            {{ $employee->first_name }} {{ $employee->last_name }}
                                        </td>
                                        <td>{{ $employee->shift->name }}
                                            ({{ date("g:i a", strtotime($employee->shift->from)) }})
                                            ({{ date("g:i a", strtotime($employee->shift->to)) }})
                                        </td>
                                        <td>{{ $employee->department->name }}</td>
                                        <td>{{ strtoupper($employee->position->name) }}
                                            ({{ $employee->position->employment_status }})
                                        </td>
                                        <td>
                                            <a href="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.edit', ['id' => $employee->id]) }}"
                                               class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <form
                                                onsubmit="return confirm('Do you really want to delete this variable?');"
                                                action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.destroy', ['id' => $employee->id]) }}"
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
                            {{ $employees->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

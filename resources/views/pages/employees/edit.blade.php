@extends('templates.master')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> @include('snippets.pagename')
                            <a href="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.index') }}"
                               class="btn btn-primary float-right text-light">Browse</a>
                        </div>
                        <div class="card-body">
                            @include('snippets.dialogs')
                            <form id="main-form"
                                  action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.update', ['id' => $employee->id]) }}"
                                  method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <p>Photo</p>
                                        <img style="width: 130px; height: 130px; border: 3px solid #ff0530" src = "{{ !is_null($employee->photo) ? asset('/employee_photos/' . $employee->photo) : route('image.load', ['disk' => encrypt('employee_photos'), encrypt('null.png')]) }}" id="output"/>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ $employee->employee_id }}" type="text"
                                                   name="employee_id" placeholder="Employee ID"
                                            >
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ $employee->first_name }}" type="text"
                                                   name="first_name" placeholder="Firstname"
                                                   required>
                                            <input class="form-control" value="{{ $employee->middle_name }}" type="text"
                                                   name="middle_name" placeholder="Middlename"
                                                   required>
                                            <input class="form-control" value="{{ $employee->last_name }}" type="text"
                                                   name="last_name" placeholder="Lastname"
                                                   required>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <select class="form-control" name="gender" required>
                                                <option value="{{ $employee->gender }}" selected disabled>{{ $employee->gender }}</option>
                                                <option value="MALE">Male</option>
                                                <option value="FEMALE">Female</option>
                                            </select>
                                            <input class="form-control" type="date" name="date_of_birth"
                                                   placeholder="Date of birth" value = "{{ $employee->date_of_birth }}"
                                                   required>
                                            <input class="form-control" type="number" value = "{{ $employee->age }}" name="age" placeholder="Age"
                                                   required>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="permanent_address"
                                                   placeholder="Permanent Address" value = "{{ $employee->permanent_address }}" required>
                                            <input class="form-control" type="number" name="length_of_service_years" value = "{{ $employee->length_of_service_years }}"
                                                   placeholder="LOS Years" >
                                            <input class="form-control" type="number"
                                                   name="length_of_service_years_months" placeholder="LOS Months" value = "{{ $employee->length_of_service_years_months }}"
                                            >
                                            <input class="form-control" type="text" name="contact_number" value = "{{ $employee->contact_number }}"
                                                   placeholder="Contact Number">
                                            <input class="form-control" type="text" name="other_contact_number" value = "{{ $employee->other_contact_number }}"
                                                   placeholder="Other Contact Number">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <select class="form-control" name="shift_id">
                                                <option value="{{ $employee->shift_id }}" selected disabled>{{ $employee->shift->name }}</option>
                                                @foreach($shifts as $shift)
                                                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control" name="department_id" >
                                                <option value="{{ $employee->department_id }}" selected disabled>{{ $employee->department->name }}</option>
                                                @foreach($departments as $department)
                                                    <option
                                                        value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control" name="position_id" >
                                                <option value="{{ $employee->position_id }}" selected disabled>{{ $employee->position->name }}</option>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
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

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
                                  action="{{ route(explode('.', \Illuminate\Support\Facades\Route::currentRouteName())[0].'.store') }}"
                                  method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <p>Photo</p>
                                        <img style="width: 130px; height: 130px; border: 3px solid #ff0530" src = "{{ route('image.load', ['disk' => encrypt('employee_photos'), encrypt('null.png')]) }}" id="output"/>
                                        <div class="input-group">
                                            <input type="file" name="photo" id="employee-photo" accept="image/*"
                                                   onchange="preview(event)">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ old('employee_id') }}" type="text"
                                                   name="employee_id" placeholder="Employee ID"
                                                   >
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ old('first_name') }}" type="text"
                                                   name="first_name" placeholder="Firstname"
                                                   required>
                                            <input class="form-control" value="{{ old('middle_name') }}" type="text"
                                                   name="middle_name" placeholder="Middlename"
                                                   required>
                                            <input class="form-control" value="{{ old('last_name') }}" type="text"
                                                   name="last_name" placeholder="Lastname"
                                                   required>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <select class="form-control" name="gender" required>
                                                <option value="" selected disabled>Gender</option>
                                                <option value="MALE">Male</option>
                                                <option value="FEMALE">Female</option>
                                            </select>
                                            <input class="form-control" type="date" name="date_of_birth"
                                                   placeholder="Date of birth"
                                                   required>
                                            <input class="form-control" type="number" name="age" placeholder="Age"
                                                   required>
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="permanent_address"
                                                   placeholder="Permanent Address" required>
                                            <input class="form-control" type="number" name="length_of_service_years"
                                                   placeholder="LOS Years" >
                                            <input class="form-control" type="number"
                                                   name="length_of_service_years_months" placeholder="LOS Months"
                                                   >
                                            <input class="form-control" type="text" name="contact_number"
                                                   placeholder="Contact Number">
                                            <input class="form-control" type="text" name="other_contact_number"
                                                   placeholder="Other Contact Number">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <select class="form-control" name="shift_id">
                                                <option value="" selected disabled>Select a shift</option>
                                                @foreach($shifts as $shift)
                                                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control" name="department_id" >
                                                <option value="" selected disabled>Select a department</option>
                                                @foreach($departments as $department)
                                                    <option
                                                        value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-control" name="position_id" >
                                                <option value="" selected disabled>Select a position</option>
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
    <script>
        var preview = function (event) {
            var output = document.getElementById('output');
            output.src = '/img/loading.gif';
            setTimeout(function(){
                output.src = URL.createObjectURL(event.target.files[0]);
                console.log('Image loaded');
            },  Math.floor(Math.random() * (5000 - 1000 + 1) + 1000));

        };
    </script>
@endsection

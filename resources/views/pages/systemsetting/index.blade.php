@extends('templates.master')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> System Settings
                        </div>
                        <div class="card-body">
                            @include('snippets.dialogs')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('additionalJS')
    <script>
        $(document).ready(function () {
            $('.collapse').collapse();
        });
    </script>
@endsection

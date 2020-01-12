@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
    <!-- Select2 -->
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
@endsection

@section('content')
    {{--    {{dump($pageAuth)}}--}}
    @if($pageAuth['is_read']==1 || false)
        {{--    <h1>{{$p['name']}}</h1>--}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>Local Authority</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Advanced Form</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>



        <section class="content-header">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    @if($pageAuth['is_create']==1 || false)
                        <div class="col-md-5">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <label>Local Authority Registration</label>
                                </div>

                                <form method="POST" action="/localAuthority">
                                    <div class="card-body">
                                        @csrf
                                        @if($provinces!=null)
                                            <div class="form-group">

                                                <label>Provincel Council</label>

                                                <select class="form-control select2 select2-purple levelCombo"
                                                        data-dropdown-css-class="select2-purple"
                                                        style="width: 100%;" name="province">

                                                    @foreach($provinces as $province)
                                                        @if (old('province') == $province['id'])
                                                            <option value="{{$province['id']}}"
                                                                    selected>{{$province['name']}}</option>

                                                        @else
                                                            <option
                                                                value="{{$province['id']}}">{{$province['name']}}</option>
                                                        @endif
                                                    @endforeach

                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label>Type</label>

                                            <select class="form-control select2 select2-purple levelCombo"
                                                    data-dropdown-css-class="select2-purple"
                                                    style="width: 100%;" name="laType">

                                                @foreach($laTypes as $key=>$laType)
                                                    @if (old('$laType') == $key)
                                                        <option value="{{$key}}"
                                                                selected>{{$laType}}</option>

                                                    @else
                                                        <option value="{{$key}}">{{$laType}}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Authority Name</label>
                                            <input name="name" type="text" class="form-control form-control-sm" required
                                                   placeholder="Enter Local Authority Name"
                                                   value="{{old('name')}}">
                                            @error('name')
                                            <p class="text-danger">{{$errors->first('name')}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Authority Code</label>
                                            <input name="code" type="text" class="form-control form-control-sm"
                                                   placeholder="Enter Local Authority Code"
                                                   value="{{old('code')}}">
                                            @error('code')
                                            <p class="text-danger">{{$errors->first('code')}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control form-control-sm" rows="3" placeholder="Enter Address"
                                                      name="address">{{old('address')}}</textarea>
                                            @error('address')
                                            <p class="text-danger">{{$errors->first('address')}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-7">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">All Local Authorities</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-condensed assignedPrivilages" id="tblUsers">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th style="width: 200px">Code</th>
                                        <th style="width: 200px">Type</th>
                                        <th style="width: 200px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                                                        @foreach($localAuthorities as $indexKey=>$localAuthority)
                                                                            <tr>
                                                                                <td>{{$indexKey+1}}.</td>
                                                                                <td>{{$localAuthority['name']}}</td>
                                                                                <td>{{$localAuthority['laCode']}}</td>
                                                                                <td>{{$localAuthority['type']}}</td>
                                                                                <td>
                                                                                    <a href="/localAuthority/id/{{$localAuthority['id']}}"
                                                                                       class="btn btn-sm btn-primary">Select</a>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </section>
    @endif
@endsection



@section('pageScripts')
    <!-- Page script -->

    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <script>
        $(function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });

            @if (session('success'))
            Toast.fire({
                type: 'success',
                title: 'Waste Management System</br>Local Authority Saved'
            });
            @endif

            @if (session('error'))
            Toast.fire({
                type: 'error',
                title: 'Waste Management System</br>Error'
            });
            @endif
            //Initialize Select2 Elements
            $('.select2').select2();
            $("#tblUsers").DataTable();

        });
    </script>
@endsection

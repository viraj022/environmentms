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
                        <h1>Waste Collecting and Transfer Vehicles</h1>
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
                        <div class="col-md-5">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <label>Vehicle Edit</label>
                                </div>
                                <form method="POST" action="/vehicle/id/{{$vehicle['id']}}">
                                    <div class="card-body">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Registration No</label>
                                            <input name="registerNo" type="text" class="form-control form-control-sm" required
                                                   placeholder="Enter Vehicle Register Number"
                                                   value="{{$vehicle['register_no']}}">
                                            @error('registerNo')
                                            <p class="text-danger">{{$errors->first('registerNo')}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                          <label>Vehicle Type</label>
                                          <input  type="text" class="form-control form-control-sm" required
                                          placeholder="Enter Vehicle Register Number"
                                          value="{{$vehicle['vehicleType']['type']}}">
                                        </div>


                                        <div class="form-group">
                                                  <label>Capacity (m<sup><sup>3</sup>)</label>
                                                  <input name="capacity" type="number" step="0.01"" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehicle Capacity "
                                                                    value="{{$vehicle['capacity']}}">
                                                  @error('code')
                                                  <p class="text-danger">{{$errors->first('capacity')}}</p>
                                                  @enderror
                                              </div>
                                         <div class="form-group">
                                                  <label>Wide (m)</label>
                                                  <input name="wide" type="number" step="0.01"" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehicle Width"
                                                                    value="{{$vehicle['wide']}}">
                                                  @error('wide')
                                                  <p class="text-danger">{{$errors->first('wide')}}</p>
                                                  @enderror
                                              </div>
                                      <div class="form-group">
                                                  <label>Length (m)</label>
                                                  <input name="length" type="number" step="0.01"" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehicle Length"
                                                                    value="{{$vehicle['length']}}">
                                                  @error('length')
                                                  <p class="text-danger">{{$errors->first('length')}}</p>
                                                  @enderror
                                              </div>
                                      <div class="form-group">
                                                  <label>Height (m)</label>
                                                  <input name="height" type="number" step="0.01"" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehicle Height"
                                                                    value="{{$vehicle['height']}}">
                                                  @error('height')
                                                  <p class="text-danger">{{$errors->first('height')}}</p>
                                                  @enderror
                                              </div>
                                        <div class="form-group">
                                                  <label>Manufacture Year</label>
                                                  <input name="production_year" type="number" class="form-control form-control-sm" required
                                                         placeholder="Enter Manufacture Year"
                                                                    value="{{$vehicle['production_year']}}">
                                                  @error('production_year')
                                                  <p class="text-danger">{{$errors->first('production_year')}}</p>
                                                  @enderror
                                              </div>
                                <div class="form-group">
                                                  <label> Vehicle Bland</label>
                                                  <input name="bland" type="text" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehcle Bland"
                                                                    value="{{$vehicle['bland']}}">
                                                  @error('bland')
                                                  <p class="text-danger">{{$errors->first('bland')}}</p>
                                                  @enderror
                                              </div>
                                                       <div class="form-group">
                                          <label>Vehicle Condition</label>
                                            <select class="form-control select2 select2-purple levelCombo"
                                                    data-dropdown-css-class="select2-purple"
                                                    style="width: 100%;" name="condition">
                                              @foreach($conditions as $key=>$condition)
                                                    @if ($vehicle->condition == $key)
                                                        <option value="{{$key}}"
                                                                selected>{{$condition}}</option>
                                                    @else
                                                        <option value="{{$key}}">{{$condition}}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                             @error('condition')
                                            <p class="text-danger">{{$errors->first('condition')}}</p>
                                            @enderror
                                        </div>
                                               <div class="form-group">
                                          <label>Vehicle Categoty</label>
                                            <select class="form-control select2 select2-purple levelCombo"
                                                    data-dropdown-css-class="select2-purple"
                                                    style="width: 100%;" name="category">
                                              @foreach($categories as $key=>$category)
                                                    @if ($vehicle['dump_type'] == $key)
                                                        <option value="{{$key}}"
                                                                selected>{{$category}}</option>

                                                    @else
                                                        <option value="{{$key}}">{{$category}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                             @error('categoty')
                                            <p class="text-danger">{{$errors->first('category')}}</p>
                                            @enderror
                                        </div>
                                               <div class="form-group">
                                          <label>Vehicle Ownership</label>
                                              <select class="form-control select2 select2-purple levelCombo"
                                                    data-dropdown-css-class="select2-purple"
                                                    style="width: 100%;" name="ownership">
                                                     @foreach($owners as $key=>$owner)
                                                    @if ($vehicle['ownership'] == $key)
                                                        <option value="{{$key}}"
                                                                selected>{{$owner}}</option>
                                                    @else
                                                          <option value="{{$key}}"
                                                                >{{$owner}}</option>
                                                                 @endif
@endforeach
                                              </select>
                                               </div>
                                    </div>

                                                                  <div class="card-footer">
                                            @if($pageAuth['is_update']==1 || false)
                                        <button type="submit" class="btn btn-warning">Update</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>

                    <div class="col-md-7">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">All Vehicles</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-condensed assignedPrivilages" id="tblUsers">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Register No</th>
                                        <th style="width: 200px">Type</th>
                                        <th style="width: 200px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                                                        @foreach($vehicles as $indexKey=>$v)
                                                                            <tr>
                                                                                <td>{{$indexKey+1}}.</td>
                                                                                <td>{{$v['register_no']}}</td>
                                                                                <td>{{$v['dump_type']}}</td>
                                                                                <td>
                                                                                    <a href="/vehicle/id/{{$v['id']}}"
                                                                                       class="btn btn-sm btn-primary">Select</a>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">

                                <h3 class="card-title"><b>Remove '{{$vehicle['register_no']}}' Vehicle
                                    </b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="alert alert-danger alert-dismissible">

                                        <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                                        Deleting selected vehicle is not reversible. <br>
                                        Please Procede with care.
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer">
                                @if($pageAuth['is_delete']==1 || false)
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-danger">
                                        Delete Vehicle
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </section>
        @if($pageAuth['is_delete']==1 || true)
            <div class="modal fade" id="modal-danger">
                <div class="modal-dialog">
                    <div class="modal-content bg-danger">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Vehicle</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><b>Are you sure you want to permanently delete this Vehicle ? </b></p>
                            <p>Once you continue, this process can not be undone. Please Procede with care.</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <form action="/vehicle/id/{{$vehicle['id']}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-light">Delete Permanently</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        @endif
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

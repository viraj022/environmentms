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
                    @if($pageAuth['is_create']==1 || false)
                        <div class="col-md-5">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <label>Vehicle Registration</label>
                                </div>

                                <form method="POST" action="/vehicle">
                                    <div class="card-body">
                                        @csrf
                                     
                                        <div class="form-group">
                                            <label>Registration No</label>
                                            <input name="registerNo" type="text" class="form-control form-control-sm" required
                                                   placeholder="Enter Vehicle Register Number"
                                                   value="{{old('registerNo')}}">
                                            @error('registerNo')
                                            <p class="text-danger">{{$errors->first('registerNo')}}</p>
                                            @enderror
                                        </div>                                      
                                        <div class="form-group">
                                          <label>Vehicle Type</label>
                                            <select class="form-control select2 select2-purple levelCombo"
                                                    data-dropdown-css-class="select2-purple"
                                                    style="width: 100%;" name="type">
                                                  @foreach($vehicleTypes as $key=>$vehicleType)
                                                    @if (old('$type') == $vehicleType->id)
                                                        <option value="{{$vehicleType->id}}"
                                                                selected>{{$vehicleType->type}}</option>

                                                    @else
                                                        <option value="{{$vehicleType->id}}">{{$vehicleType->type}}</option>
                                                    @endif
                                                @endforeach
                                               

                                            </select>
                                             @error('type')
                                            <p class="text-danger">{{$errors->first('type')}}</p>
                                            @enderror
                                        </div>  


                                        <div class="form-group">
                                                  <label>Capacity (m<sup><sup>3</sup>)</label>
                                                  <input name="capacity" type="number" step="0.01"" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehicle Capacity "
                                                                    value="{{old('capacity')}}">
                                                  @error('code')
                                                  <p class="text-danger">{{$errors->first('capacity')}}</p>
                                                  @enderror
                                              </div>
                                        <div class="form-group">
                                                  <label>Wide (m)</label>
                                                  <input name="wide" type="number" step="0.01"" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehicle Width"
                                                                    value="{{old('wide')}}">
                                                  @error('wide')
                                                  <p class="text-danger">{{$errors->first('wide')}}</p>
                                                  @enderror
                                              </div>
                                        <div class="form-group">
                                                  <label>Length (m)</label>
                                                  <input name="length" type="number" step="0.01"" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehicle Length"
                                                                    value="{{old('length')}}">
                                                  @error('length')
                                                  <p class="text-danger">{{$errors->first('length')}}</p>
                                                  @enderror
                                              </div>
                                        <div class="form-group">
                                                  <label>Height (m)</label>
                                                  <input name="height" type="number" step="0.01"" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehicle Height"
                                                                    value="{{old('height')}}">
                                                  @error('height')
                                                  <p class="text-danger">{{$errors->first('height')}}</p>
                                                  @enderror
                                              </div>
                                        <div class="form-group">
                                                  <label>Manufacture Year</label>
                                                  <input name="production_year" type="number" class="form-control form-control-sm" required
                                                         placeholder="Enter Manufacture Year"
                                                                    value="{{old('production_year')}}">
                                                  @error('production_year')
                                                  <p class="text-danger">{{$errors->first('production_year')}}</p>
                                                  @enderror
                                              </div>
                                        <div class="form-group">
                                                  <label> Vehicle Bland</label>
                                                  <input name="bland" type="text" class="form-control form-control-sm" required
                                                         placeholder="Enter Vehcle Bland"
                                                                    value="{{old('bland')}}">
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
                                                    @if (old('$condition') == $key)
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
                                                    style="width: 100%;" name="categoty">                                                         
                                              @foreach($categories as $key=>$category)
                                                    @if (old('$categoty') == $key)
                                                        <option value="{{$key}}"
                                                                selected>{{$category}}</option>

                                                    @else
                                                        <option value="{{$key}}">{{$category}}</option>
                                                    @endif
                                                @endforeach            
                                            </select>
                                             @error('categoty')
                                            <p class="text-danger">{{$errors->first('categoty')}}</p>
                                            @enderror
                                        </div>  
                                              <div class="form-group">
                                          <label>Vehicle Ownership</label>
                                            <select class="form-control select2 select2-purple levelCombo"
                                                    data-dropdown-css-class="select2-purple"
                                                    style="width: 100%;" name="ownership">
                                                     @foreach($owners as $key=>$owner)
                                                    @if (old('$ownership') == $key)
                                                        <option value="{{$key}}"
                                                                selected>{{$owner}}</option>

                                                    @else
                                                        <option value="{{$key}}">{{$owner}}</option>
                                                    @endif
                                                @endforeach      
                                               

                                            </select>
                                             @error('ownership')
                                            <p class="text-danger">{{$errors->first('ownership')}}</p>
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
                                                                        @foreach($vehicles as $indexKey=>$vehicle)
                                                                            <tr>
                                                                                <td>{{$indexKey+1}}.</td>
                                                                                <td>{{$vehicle['register_no']}}</td>
                                                                                <td>{{$vehicle['dump_type']}}</td>                                                                                
                                                                                <td>
                                                                                    <a href="/vehicle/id/{{$vehicle['id']}}"
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
    <script src="/js/lajs/laget.js"></script>
    <script src="/js/lajs/lacombo.js"></script>
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

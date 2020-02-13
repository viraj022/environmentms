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
    @if($pageAuth['is_read']==1 || false)
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>Pradesheyasaba</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Add New Attachments</a></li>
                            <li class="breadcrumb-item active">Environmental MS</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card card-primary">
                            <div class="card-header">
                                <label>Roles</label>
                            </div>
                            <div class="card-body">
                                <label>Level</label>
                                 <input name="roll" type="text" class="form-control form-control-sm"
                                                               placeholder="Enter Roll..."
                                                               value="{{old('expert')}}">
                            </div>
                           
                            <div class="card-footer">
                                @if($pageAuth['is_create']==1 || false)
                                    <button id="btnUpdateModel" type="submit" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modal-xl">Save</button>
                                @endif
                                @if($pageAuth['is_update']==1 || false)
                                    <button id="btnUpdateModel" type="submit" class="btn btn-warning" data-toggle="modal"
                                            data-target="#modal-xl">Update</button>
                                @endif
                                @if($pageAuth['is_delete']==1 || false)
                                    <button type="submit" class="btn btn-danger"  data-toggle="modal"
                                            data-target="#modal-danger">Delete</button>
                                @endif
                            </div>                           
                                        </div>
                                </div>

                        </div>
                        <div class="col-md-7">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Assigned Privileges</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body p-0">
                                                    <table class="table table-condensed assignedPrivilages" id="as">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th>Previlage</th>
                                                            <th style="width: 20px">Read</th>
                                                            <th style="width: 20px">Write</th>
                                                            <th style="width: 20px">Update</th>
                                                            <th style="width: 20px">Delete</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        {{-- @foreach($privileges as $indexKey =>$privilege)
                                                            
                                                        @endforeach --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>


                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
             <div class="modal fade" id="modal-danger">
                <div class="modal-dialog">
                    <div class="modal-content bg-danger">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Role</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><b>Are you sure you want to permanently delete this Role ? </b></p>
                            <p>Once you continue, this process can not be undone. Please Procede with care.</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                <button id="btnDelRole" type="submit" class="btn btn-outline-light" data-dismiss="modal">Delete Permanently</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
                  <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update Role</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                 <div class="card-header">
                                                        <label>New Role Name</label>
                                                    </div>
               <input id="txtupdateRoleName" name="roll" type="text" class="form-control form-control-sm"
                                                               placeholder="Enter Roll..."
                                                               value="{{old('expert')}}">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-warning" id="btnUpdateRole" data-dismiss="modal">Update Role</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <script src="../../js/userjs/submit.js"></script>
    <!-- AdminLTE App -->
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
                title: 'Waste Management System</br>Roll Saved'
            });
            @endif

            @if (session('error'))
            Toast.fire({
                type: 'error',
                title: 'Waste Management System</br>Error'
            });
            @endif            
        });
    </script>
@endsection

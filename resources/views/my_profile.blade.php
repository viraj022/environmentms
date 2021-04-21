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
    @if($pageAuth['is_read']==1 || True)

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>System Users</h1>
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
                        <div class="card card-gray">
                            <div class="card-header">
                                <label>Baic Information</label>
                            </div>

                            <form method="POST" action="/users/id/{{$user['id']}}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input name="firstName" type="text" disabled class="form-control form-control-sm"
                                               placeholder="Enter First Name"
                                               value="{{$user['first_name']}}">
                                        @error('roll')
                                        <p class="text-danger">{{$errors->first('firstName')}}</p>
                                        @enderror
                                  </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input name="lastName" type="text" disabled class="form-control form-control-sm"
                                               placeholder="Enter Last Name"
                                               value="{{$user['last_name']}}">
                                        @error('roll')
                                        <p class="text-danger">{{$errors->first('lastName')}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input name="userName" type="text" disabled class="form-control form-control-sm"
                                               placeholder="Enter User Name"
                                               value="{{$user['user_name']}}">
                                        @error('roll')
                                        <p class="text-danger">{{$errors->first('userName')}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control form-control-sm" rows="3" disabled placeholder="Enter Address"
                                                  name="address">{{$user['address']}}</textarea>
                                        @error('address')
                                        <p class="text-danger">{{$errors->first('address')}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Contact No</label>
                                        <input name="contactNo" type="text" disabled class="form-control form-control-sm"
                                               placeholder="Enter Contact No"
                                               value="{{$user['contact_no']}}">
                                        @error('contactNo')
                                        <p class="text-danger">{{$errors->first('contactNo')}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" type="text" disabled class="form-control form-control-sm" placeholder="Enter Email"
                                               value="{{$user['email']}}">
                                        @error('email')
                                        <p class="text-danger">{{$errors->first('email')}}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>NIC</label>
                                        <input name="nic" type="text" disabled class="form-control form-control-sm" placeholder="Enter NIC"
                                               value="{{$user['nic']}}">
                                        @error('nic')
                                        <p class="text-danger">{{$errors->first('nic')}}</p>
                                        @enderror
                                    </div>

                                </div>
                                <div class="card-footer">
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-7">
                      @if($pageAuth['is_update']==1 || True)
                            <form method="POST" action="/users/my_password">
                                <div class="card card-gray">
                                    <div class="card-header">
                                        <h3 class="card-title">Credentials</h3>
                                    </div>
                                    <div class="card-body">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input name="password" type="password" class="form-control form-control-sm"
                                                   placeholder="Enter Password"
                                            >
                                            @error('password')
                                            <p class="text-danger">{{$errors->first('password')}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input name="password_confirmation" type="password" class="form-control form-control-sm"
                                                   placeholder="Re-enter Password"
                                            >
                                            @error('password_confirmation')
                                            <p class="text-danger">{{$errors->first('password_confirmation')}}</p>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-warning">Reset Password</button>
                                    </div>

                                </div>
                            </form>
                        @endif
                    
                       
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
    <script src="../../js/userjs/submit.js"></script>
    <script>
        $(function () {
            @if (session('success'))
            Toast.fire({
                type: 'success',
                title: 'Environment management system</br>User Saved'
            });
            @endif

            @if (session('error'))
            Toast.fire({
                type: 'error',
                title: 'Environment management system</br>Error'
            });
            @endif


            //Initialize Select2 Elements
            var userId = '{{$user['id']}}'
            var rollId = '{{$user['roll_id']}}'
            $('.select2').select2();
          

            ///// end array initialize
            


        })
    </script>

@endsection

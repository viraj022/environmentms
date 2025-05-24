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
                        @method('POST')
                        <div class="card-body">
                            <div class="form-group">
                                <label>First Name</label>
                                <input name="firstName" maxlength="50" type="text" class="form-control form-control-sm"
                                       placeholder="Enter First Name"
                                       value="{{$user['first_name']}}">
                                @error('roll')
                                <p class="text-danger">{{$errors->first('firstName')}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input name="lastName" maxlength="50" type="text" class="form-control form-control-sm"
                                       placeholder="Enter Last Name"
                                       value="{{$user['last_name']}}">
                                @error('roll')
                                <p class="text-danger">{{$errors->first('lastName')}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input name="userName" maxlength="50" type="text" class="form-control form-control-sm"
                                       placeholder="Enter User Name"
                                       value="{{$user['user_name']}}">
                                @error('roll')
                                <p class="text-danger">{{$errors->first('userName')}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control form-control-sm" maxlength="75" rows="3" placeholder="Enter Address"
                                          name="address">{{$user['address']}}</textarea>
                                @error('address')
                                <p class="text-danger">{{$errors->first('address')}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Contact No</label>
                                <input name="contactNo" type="text" maxlength="10" class="form-control form-control-sm"
                                       placeholder="Enter Contact No"
                                       value="{{$user['contact_no']}}">
                                @error('contactNo')
                                <p class="text-danger">{{$errors->first('contactNo')}}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="text" maxlength="50" class="form-control form-control-sm" placeholder="Enter Email"
                                       value="{{$user['email']}}">
                                @error('email')
                                <p class="text-danger">{{$errors->first('email')}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>NIC</label>
                                <input name="nic" type="text" maxlength="12" class="form-control form-control-sm" placeholder="Enter NIC"
                                       value="{{$user['nic']}}">
                                @error('nic')
                                <p class="text-danger">{{$errors->first('nic')}}</p>
                                @enderror
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
                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title">Privileges</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label>User Level</label>
                            <input name="nic" type="text" class="form-control form-control-sm" value="{{$level['name']}}"
                                   disabled="true">
                        </div>
                        <div class="form-group">
                            <label>User Role</label>
                            <select class="form-control select2 select2-purple roleCombo"
                                    data-dropdown-css-class="select2-purple"
                                    style="width: 100%;" name="level">
                                @foreach($roles as $role)
                                @if ($user['roll_id'] == $role['id'])
                                <option value="{{$role['id']}}"
                                        selected>{{$role['name']}}</option>

                                @else
                                <option value="{{$role['id']}}">{{$role['name']}}</option>
                                @endif
                                @endforeach

                            </select>
                        </div>
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
                                @foreach($privileges as $indexKey =>$privilege)
                                <tr id="pre{{$privilege['id']}}">
                                    <td>{{$indexKey+1}}.</td>
                                    <td>{{$privilege['name']}}</td>
                                    <td align="center"><input class="form-check-input read"
                                                              type="checkbox" value="option1">
                                    </td>
                                    <td align="center">
                                        <input class="form-check-input write" type="checkbox"
                                               value="option1">
                                    </td>
                                    <td align="center">
                                        <input class="form-check-input update" type="checkbox"
                                               value="option1">
                                    </td>
                                    <td align="center">
                                        <input class="form-check-input delete" type="checkbox"
                                               value="option1">
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="btnReset">Reset</button>
                        <button type="button" class="btn btn-success" id="btnSetRollPrivilege">Default Privilege
                        </button>
                        @if($pageAuth['is_update']==1 || true)
                        <button type="button" class="btn btn-warning" id="btnAssign">Assign</button>
                        @endif
                    </div>
                </div>
                @if($pageAuth['is_update']==1 || false)
                <form method="POST" action="/users/password/{{$user['id']}}">
                    <div class="card card-gray">
                        <div class="card-header">
                            <h3 class="card-title">Credentials</h3>
                        </div>
                        <div class="card-body">
                            @csrf
                            @method('POST')
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
                @if($pageAuth['is_update']==1 || false)
                <form method="POST" action="/users/password/{{$user['id']}}">
                    <div class="card card-gray">
                        <div class="card-header">
                            <h3 class="card-title">User Activity</h3>
                        </div>
                        <div class="card-body">
                            @csrf
                            @method('POST')
                            <div class="form-group">

                                <label>Active Status</label>
                                <select class="form-control select2 select2-purple activityCombo"
                                        data-dropdown-css-class="select2-purple"
                                        style="width: 100%;" name="level">
                                    @foreach($activitys as $key=>$activity)
                                    {{--                                        @if ($user['roll_id'] == $role['id'])--}}
                                    {{--                                            <option value="{{$role['id']}}"--}}
                                    {{--                                                    selected>{{$role['name']}}</option>--}}

                                    {{--                                        @else--}}
                                    <option value="{{$key}}">{{$activity}}</option>
                                    {{--                                        @endif--}}
                                    @endforeach

                                </select>

                            </div>
                        </div>
                        <div class="card-footer">
                            @if($pageAuth['is_delete']==1 || false)
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#modal-danger">
                                Delete User
                            </button>
                            @endif
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
@if($pageAuth['is_delete']==1 || true)
<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Delete User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b>Are you sure you want to permanently delete this user ? </b></p>
                <p>Once you continue, this process can not be undone. Change Active Status to
                    <b>Inactive</b> if
                    you
                    want to keep the user and disable from the system(Recommended)</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <form action="/users/id/{{$user['id']}}" method="POST">
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
<!-- /.modal -->
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
loadUserPrevilages(userId);
///// end array initialize
function loadPrevilages(id) {
    $.ajax({
        type: "GET",
        headers: {
           "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
           "Accept": "application/json"
        },
    url: "/api/rolls/rollPrivilege/" + id,
    contentType: false,
    dataType: "json",
    cache: false,
    processDaate: false,
    success: function (result) {
    // alert(JSON.stringify(result));
    $('.read').prop('checked', false);
    $('.write').prop('checked', false);
    $('.update').prop('checked', false);
    $('.delete').prop('checked', false);
    if (result.length > 0) {
    $.each(result, function (key, value) {

    if ($("#pre" + value.id).length == 1) {

    if (value.pivot.is_read == 1) {

    $("#pre" + value.id + " .read").prop('checked', true);
    } else {
    $("#pre" + value.id + " .read").prop('checked', false);
    }
    if (value.pivot.is_create == 1) {

    $("#pre" + value.id + " .write").prop('checked', true);
    } else {
    $("#pre" + value.id + " .write").prop('checked', false);
    }
    if (value.pivot.is_update == 1) {

    $("#pre" + value.id + " .update").prop('checked', true);
    } else {
    $("#pre" + value.id + " .update").prop('checked', false);
    }
    if (value.pivot.is_delete == 1) {

    $("#pre" + value.id + " .delete").prop('checked', true);
    } else {
    $("#pre" + value.id + " .delete").prop('checked', false);
    }

    } else {
    alert('Error Previlage table not found');
    }
    });
    } else {
    console.log('No Privileges');
    }
    // alert(JSON.stringify(result));
    console.log(result);
    }
});
}

function loadUserPrevilages(id) {
$(".roleCombo").val(rollId);
$('.select2').select2();
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
    url: "/api/user/Privileges/" + id,
    contentType: false,
    dataType: "json",
    cache: false,
    processDaate: false,
    success: function (result) {
    // alert(JSON.stringify(result));
    $('.read').prop('checked', false);
    $('.write').prop('checked', false);
    $('.update').prop('checked', false);
    $('.delete').prop('checked', false);
    if (result.length > 0) {
    $.each(result, function (key, value) {

    if ($("#pre" + value.id).length == 1) {

    if (value.pivot.is_read == 1) {

    $("#pre" + value.id + " .read").prop('checked', true);
    } else {
    $("#pre" + value.id + " .read").prop('checked', false);
    }
    if (value.pivot.is_create == 1) {

    $("#pre" + value.id + " .write").prop('checked', true);
    } else {
    $("#pre" + value.id + " .write").prop('checked', false);
    }
    if (value.pivot.is_update == 1) {

    $("#pre" + value.id + " .update").prop('checked', true);
    } else {
    $("#pre" + value.id + " .update").prop('checked', false);
    }
    if (value.pivot.is_delete == 1) {

    $("#pre" + value.id + " .delete").prop('checked', true);
    } else {
    $("#pre" + value.id + " .delete").prop('checked', false);
    }

    } else {
    alert('Error Previlage table not found');
    }
    });
    } else {
    console.log('No Privileges');
    }
    // alert(JSON.stringify(result));
    console.log(result);
    }
});
}

$('.roleCombo').change(function () {
// load the default assigned privileges in a user roll
loadPrevilages(this.value);
});
$('.activityCombo').change(function () {
// alert(this.value);
var data = {
'status': this.value
    }
changeAciveStatus(userId, data, function () {
// alert('User Changes to \'' + $(".activityCombo option:selected").html() + '\' status');
Toast.fire({
type: 'success',
    title: 'Environment management system</br>User Changes to \'' + $(".activityCombo option:selected").html() + '\' status'
});
});
});
$('#btnSetRollPrivilege').click(function () {
// alert(this.value);
loadPrevilages($('.roleCombo').val());
});
$('#btnReset').click(function () {
// rest un saved privileges
loadUserPrevilages(userId);
// $('.roleCombo').val(rollId);
});
$('#btnAssign').click(function () {
// saving privileges
assignPrivilegesToUser(userId, function () {
rollId = $('.roleCombo').val();
Toast.fire({
type: 'success',
    title: 'Environment management system</br>Privilege changed successfully'
    });
loadUserPrevilages(userId);
});
});
})
</script>

@endsection

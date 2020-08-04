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
                        <h1>System User Roles</h1>
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
                                <select class="form-control select2 select2-purple levelCombo"
                                        data-dropdown-css-class="select2-purple"
                                        style="width: 100%;">

                                    @foreach($levels as $level)
                                        <option value="{{$level['id']}}">{{$level['name']}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="card-body">
                                <label>Role</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select class="form-control select2 select2-purple rollCombo"
                                                data-dropdown-css-class="select2-purple" style="width: 100%;"
                                                id="rollCombo">


                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        @if($pageAuth['is_create']==1 || false)
                                            <button type="button" class="btn btn-success" id="btn_add_roll"><i
                                                    class="fas fa-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @if($pageAuth['is_update']==1 || false)
                                    <button id="btnUpdateModel" type="submit" class="btn btn-warning" data-toggle="modal"
                                            data-target="#modal-xl">Update</button>
                                @endif
                                @if($pageAuth['is_delete']==1 || false)
                                    <button type="submit" class="btn btn-danger"  data-toggle="modal"
                                            data-target="#modal-danger">Delete</button>
                                @endif
                            </div>

                            @if(count($errors) ||session('success'))
                                <div class="div_add_roll">
                                    @else
                                        <div class="d-none div_add_roll">
                                            @endif
                                            @if($pageAuth['is_create']==1 || false)
                                                <form method="POST" action="/rolls">
                                                    @csrf
                                                    <div class="card-header">
                                                        <label>Add new System Roll</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <label>Select Level</label>
                                                        <select name="level" class="form-control select2 select2-purple"
                                                                data-dropdown-css-class="select2-purple"
                                                                style="width: 100%;">

                                                            @foreach($levels as $level)

                                                                @if (old('level') == $level['id'])
                                                                    <option value="{{$level['id']}}"
                                                                            selected>{{$level['name']}}</option>

                                                                @else
                                                                    <option
                                                                        value="{{$level['id']}}">{{$level['name']}}</option>
                                                                @endif
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="card-body">
                                                        <input name="roll" type="text" class="form-control form-control-sm"
                                                               placeholder="Enter Roll..."
                                                               value="{{old('expert')}}">
                                                        @error('roll')
                                                        <p class="text-danger">{{$errors->first('roll')}}</p>
                                                        @enderror

                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-success" id="btnSaveRoll">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            @endif
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
                                        <div class=" col-sm-6 form-check form-inline">
                                            <input id="addAllPriv" class="form-check-input" type="checkbox">
                                            <label id="txtPriv" class="form-check-label">Check All Privileges</label>
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
                                                        @foreach($privileges as $indexKey =>$privilege)
                                                            <tr id="pre{{$privilege['id']}}">
                                                                <td>{{$indexKey+1}}.</td>
                                                                <td>{{$privilege['name']}}</td>
                                                                <td align="center"><input class="form-check-input read"
                                                                                          type="checkbox"
                                                                                          value="option1">
                                                                </td>
                                                                <td align="center">
                                                                    <input class="form-check-input write"
                                                                           type="checkbox"
                                                                           value="option1">
                                                                </td>
                                                                <td align="center">
                                                                    <input class="form-check-input update"
                                                                           type="checkbox"
                                                                           value="option1">
                                                                </td>
                                                                <td align="center">
                                                                    <input class="form-check-input delete"
                                                                           type="checkbox"
                                                                           value="option1">
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>


                                        </div>
                                        @if($pageAuth['is_update']==1 || false)
                                            <button type="button" class="btn btn-success" id="btnAssign">Assign</button>
                                        @endif
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

            //Initialize Select2 Elements
            $('.select2').select2();
            loadRolls($('.levelCombo').val(), 'rollCombo', function () {
                $('.rollCombo').change();
            });

            // alert(this.value);
            // loads system rolls to the roll combobox when level combo changes
            $('.levelCombo').change(function () {
                loadRolls(this.value, 'rollCombo', function () {
                    $('.rollCombo',).change();
                });
            });


            $('.rollCombo').change(function () {
                // alert(this.value);
                loadPrevilages(this.value);
            });


            $("#btnAssign").click(function () {
                // assign privileges to rolls
                assignPrivilegesToRolls(function (result) {
                    /// confirmation msessage
                    // alert(result.id);
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Waste Management System</br>Privileges Saved'
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Waste Managemet System</br>Error'
                        });
                    }
                    // refresh the privilege table
                    loadRolls($('.levelCombo').val(), 'rollCombo', function () {
                        $('.rollCombo',).change();
                    });
                })
            });


            $('#btn_add_roll').click(function () {
                $('.div_add_roll').removeClass('d-none');
            });

            function loadPrevilages(id) {
                $.ajax({
                    type: "GET",
                    headers: {
                        "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
                        "Accept": "application/json"
                    },
                    url: "api/rolls/rollPrivilege/" + id,
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
$("#btnDelRole").click(function(){
//  alert($('.rollCombo').val());
 deleteRole($('.rollCombo').val(),function(result){
                     if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Waste Management System</br>User Deleted'
                        });
                    } else if(result.id == 2) {
                        Toast.fire({
                            type: 'error',
                            title: 'Waste Managemet System</br>Delete Failed'
                        });
                    }  else if(result.id == 3){
                            Toast.fire({
                            type: 'warning',
                            title: '<h4>Can not delete while role is assigned to a user</h4>'
                        });
                    }else{
                            Toast.fire({
                            type: 'error',
                            title: 'Waste Managemet System</br>Delete Failed'
                        });
                    }
                    location.reload();
 });
});

$("#btnUpdateModel").click(function(){
$("#txtupdateRoleName").val($('.rollCombo').text());
// $("#txtupdateRoleName").select();
})

$("#btnUpdateRole").click(function(){

             updateRole($('.rollCombo').val(),{"roll":$("#txtupdateRoleName").val()},function(result){
  if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Waste Management System</br>Role Updated'
                        });
                    } else if(result.id == 2) {
                        Toast.fire({
                            type: 'error',
                            title: 'Waste Managemet System</br>Update Failed'
                        });
                    }  else if(result.id == 3){
                            Toast.fire({
                            type: 'warning',
                            title: '<h4>Can not Update</h4>'
                        });
                    }else{
                            Toast.fire({
                            type: 'error',
                            title: 'Waste Managemet System</br>Delete Failed'
                        });
                    }
                      $('.select2').select2();
            loadRolls($('.levelCombo').val(), 'rollCombo', function () {
                $('.rollCombo').change();
            });
});
});
        });
        
$(document).ready(function () {
//check all checkboxes in page 
    $('#addAllPriv').click(function () {
        if ($(this).prop("checked") === true) {
            $('input:checkbox').not(this).prop('checked', this.checked = true)
            $("#txtPriv").text("Uncheck All Privileges");
        } else if ($(this).prop("checked") === false) {
            $('input:checkbox').not(this).prop('checked', this.checked = false)
            $("#txtPriv").text("Check All Privileges");
        }
    });
//check checkboxes in a row
    $('.selectRow').click(function () {
        if ($(this).prop("checked") === true) {
            var table = $(this).closest('tr');
            $('td input:checkbox', table).prop('checked', this.checked = true);
        } else if ($(this).prop("checked") === false) {
            $('td input:checkbox', table).prop('checked', this.checked = false);
        }
    });

});        
        
    </script>
@endsection

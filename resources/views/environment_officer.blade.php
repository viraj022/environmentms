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
                <h1>Environment Officer</h1>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="card card-success">
                <div class="card-header">
                    <label id="lblTitle">Add New Environment Officer</label>
                </div>

                <div class="card-body">
                    <div class="form-group" id="comboAssistantDirectorDisplay">
                        <label>Assistant Director*</label>
                        <select id="getAssistantDirector" class="form-control form-control-sm select2 select2-purple combo_AssistantDirector" data-dropdown-css-class="select2-purple"
                                style="width: 100%;" name="level">
                            <option>Loading...</option>
                        </select>
                        <div id="valZone" class="d-none"><p class="text-danger">Field is required</p></div>
                    </div>
                    <div class="form-group d-none" id="lblAssistantDirectorDiplay">
                        <label>Assistant Director</label>
                        <label  id="lblAssistantDirector" class="form-control form-control-sm"><5151/2151561<label>
                                </div>

                                <div class="form-group" id="comboUserDiplay">
                                    <label>Users*</label>
                                    <select id="getUsers" class="form-control form-control-sm select2 select2-purple"                                                  data-dropdown-css-class="select2-purple"
                                            style="width: 100%;" name="level">
                                        <option>Loading...</option>
                                    </select>
                                    <div id="valUsers" class="d-none"><p class="text-danger">Field is required</p></div>
                                </div>

                                <div class="form-group d-none" id="lblUserDiplay">
                                    <label>Users</label>
                                    <label  id="lblUser" class="form-control form-control-sm"></label>



                                </div>


                                </div>
                                <div class="card-footer">
                                    <button id="btnReset" type="submit" class="btn btn-info d-none">Reset</button>
                                    @if($pageAuth['is_create']==1 || false)
                                    <button id="btnSave" type="submit" class="btn btn-success">Save</button>
                                    @endif
                                    @if($pageAuth['is_update']==1 || false)
                                    <button id="btnUpdate" type="submit" class="btn btn-warning d-none">Update</button>
                                    @endif
                                    @if($pageAuth['is_delete']==1 || false)
                                    <button  id="btnshowDelete" type="submit" class="btn btn-danger d-none"  data-toggle="modal"
                                             data-target="#modal-danger">Delete</button>
                                    @endif
                                </div>                           
                                </div>
                                </div>


                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4"><label>Assistant Director</label></div>
                                                    <div class="col-md-8">
                                                        <select id="getAssistantDirectorTbl" class="form-control form-control-sm combo_AssistantDirector">
                                                            <option>Loading...</option>
                                                        </select>
                                                        <div id="valZone" class="d-none"><p class="text-danger">Field is required</p></div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <table class="table table-condensed" id="tblEnvOfficer">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Environment Officer Name</th>

                                                        <th style="width: 140px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>                                        
                                </div>
                                </div>
                                <div class="modal fade" id="modal-danger">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Selected Item</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><b>Are you sure you want to permanently delete this Item? </b></p>
                                                <p>Once you continue, this process can not be undone. Please Procede with care.</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                <button id="btnDelete" type="submit" class="btn btn-outline-light" data-dismiss="modal">Delete Permanently</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
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
                                <script src="../../js/\EnvironmentOfficerJS/submit.js"></script>
                                <script src="../../js/\EnvironmentOfficerJS/get.js"></script>
                                <script src="../../js/\EnvironmentOfficerJS/update.js"></script>
                                <script src="../../js/\EnvironmentOfficerJS/delete.js"></script>
                                <!-- AdminLTE App -->
                                <script>
                                    $(function () {

                                        //Load table
                                        //loadTable();
                                        //   loadZoneCombo();
                                        loadUsersCombo();
                                        loadAssistantDirectorCombo(function () {
                                            loadEnvOficerTable($('#getAssistantDirectorTbl').val());

                                        });
                                        //loadTable();
                                        //click save button
                                        $('#btnSave').click(function () {
                                            var data =
                                                    {
                                                        "user_id": $('#getUsers').val(),
                                                        "assistantDirector_id": $('#getAssistantDirector').val()
                                                    }
                                            //alert(JSON.stringify(data));

                                            AddAssistantDir(data, function (result) {
                                                if (result.id == 1) {
                                                    Toast.fire({
                                                        type: 'success',
                                                        title: 'Enviremontal Officer</br>Saved'
                                                    });

                                                } else {
                                                    Toast.fire({
                                                        type: 'error',
                                                        title: 'Enviremontal Officer</br>Error'
                                                    });
                                                }
                                                loadUsersCombo();
                                                loadAssistantDirectorCombo(function () {
                                                    loadEnvOficerTable($('#getAssistantDirectorTbl').val());
                                                });

                                            });

                                        });
                                        //click update button
                                        $('#btnReset').click(function () {
                                            showSaveBtn();
                                            loadUsersCombo();
                                            loadAssistantDirectorCombo(function () {
                                                loadEnvOficerTable($('#getAssistantDirectorTbl').val());
                                            });
                                        });
                                        //click delete button
                                        $('#btnDelete').click(function () {
                                            //alert('delete btn');
                                            deleteEnviremontalOfficer($('#btnDelete').val(), function (result) {
                                                if (result.id == 1) {
                                                    Toast.fire({
                                                        type: 'success',
                                                        title: 'Enviremontal Officer</br>Removed!'
                                                    });

                                                } else {
                                                    Toast.fire({
                                                        type: 'error',
                                                        title: 'Enviremontal Officer</br>Error'
                                                    });
                                                }
                                                loadUsersCombo();
                                                loadAssistantDirectorCombo(function () {
                                                    loadEnvOficerTable($('#getAssistantDirectorTbl').val());
                                                });
                                                showSaveBtn();

                                                // resetinputFields();
                                                //hideAllErrors();
                                            });
                                        });
                                        //select button action 
                                        $(document).on('click', '.btnAction', function () {
                                            // alert(this.id);
                                            getEnvOfficerById(this.id, function (result) {
                                                //alert(result.id);
                                                $('#lblAssistantDirector').text(result.assistant_director_first_name + ' ' + result.assistant_director_last_name);
                                                $('#lblUser').text(result.user_name + ' ' + result.last_name);

                                                $('#btnUpdate').val(result.id);
                                                $('#btnDelete').val(result.id);
                                                showUpdate_DeleteBtn();
                                            });
                                            hideAllErrors();
                                        });
                                    });
                                    //show update buttons    
                                    function showUpdate_DeleteBtn() {
                                        $('#btnSave').addClass('d-none');
                                        //$('#btnUpdate').removeClass('d-none');
                                        $('#btnshowDelete').removeClass('d-none');
                                        $('#btnReset').removeClass('d-none');

                                        $('#comboUserDiplay').addClass('d-none');
                                        $('#lblUserDiplay').removeClass('d-none');
                                        $('#comboAssistantDirectorDisplay').addClass('d-none');
                                        $('#lblAssistantDirectorDiplay').removeClass('d-none');
                                    }
                                    //show save button    
                                    function showSaveBtn() {
                                        $('#btnReset').addClass('d-none');
                                        $('#btnSave').removeClass('d-none');
                                        $('#btnUpdate').addClass('d-none');
                                        $('#btnshowDelete').addClass('d-none');
                                        $('#lblUserDiplay').addClass('d-none');
                                        $('#comboUserDiplay').removeClass('d-none');
                                        $('#comboAssistantDirectorDisplay').removeClass('d-none');
                                        $('#lblAssistantDirectorDiplay').addClass('d-none');
                                    }
                                    //Reset all fields    
                                    function resetinputFields() {
                                        $('#getName').val('');
                                        $('#getCode').val('');
                                        $('#btnUpdate').val('');
                                        $('#btnDelete').val('');
                                    }

                                    //HIDE ALL ERROR MSGS   
                                    function hideAllErrors() {
                                        $('#valName').addClass('d-none');
                                        $('#valCode').addClass('d-none');
                                        $('#uniName').addClass('d-none');
                                        $('#uniCode').addClass('d-none');
                                    }

                                    $('#getAssistantDirectorTbl').change(function () {

                                        loadEnvOficerTable($('#getAssistantDirectorTbl').val());
                                    });
                                </script>
                                @endsection

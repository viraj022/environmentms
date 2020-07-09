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
                <h1>(<a href="/epl_profile/client/{{$client_id}}/profile/{{$id}}" target="_blank">{{$epl_code}}</a>) - Certificate Approval</h1>
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
                        <label id="lblTitle">Approve By Environment Officer</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Date*</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right envOfficer_section" id="trackDate">
                            </div>
                            <div id="valName" class="d-none"><p class="text-danger">Date is required</p></div>
                        </div>
                        <div class="form-group">
                            <label>Comment*</label>
                            <textarea  id="getEnvOfficerCmt" type="text" class="form-control form-control-sm envOfficer_section" placeholder="Enter Comment..." value=""></textarea>
                            <div id="valCode" class="d-none"><p class="text-danger">Comment is required</p></div>
                        </div>
                    </div>
                    <div class="card-footer">
                      
                        <button disabled id="btnSave" type="submit" class="btn btn-success envOfficer_section">Approve</button>
                      
                    </div>                           
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <label id="lblTitle">Approve By Assistant Director</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Date*</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right astDir_section" id="trackDateAssDir">
                            </div>
                            <div id="valName" class="d-none"><p class="text-danger">Date is required</p></div>
                        </div>
                        <div class="form-group">
                            <label>Comment*</label>
                            <input id="getAssDirCmt" type="text" class="form-control form-control-sm astDir_section" placeholder="Enter Comment..." value="">
                            <div id="valCode" class="d-none"><p class="text-danger">Comment is required</p></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button disabled id="btnSave2" type="submit" class="btn btn-success astDir_section">Approve</button>
                        @endif
                        @if($pageAuth['is_delete']==1 || false)
                        <button disabled  id="btnshowDelete2" type="submit" class="btn btn-danger astDir_section">Reject</button>
                        @endif
                    </div>                           
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <label id="lblTitle">Approve By Director</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Date*</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right director_sectiom" id="trackDateDir">
                            </div>
                            <div id="valName" class="d-none"><p class="text-danger">Date is required</p></div>
                        </div>
                        <div class="form-group">
                            <label>Comment*</label>
                            <input id="getDirCmt" type="text" class="form-control form-control-sm director_sectiom" placeholder="Enter Comment..." value="">
                            <div id="valCode" class="d-none"><p class="text-danger">Comment is required</p></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button disabled id="btnSave3" type="submit" class="btn btn-success director_sectiom">Approve</button>
                        @endif
                        @if($pageAuth['is_delete']==1 || false)
                        <button disabled  id="btnshowDelete3" type="submit" class="btn btn-danger director_sectiom" >Reject</button>
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
                                        <h3 class="card-title">All Logs</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <table class="table table-condensed" id="tblCerApprove">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Date</th>
                                                        <th>Comment</th>
                                                        <th style="width: 140px">Status</th>
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
<script src="../../js/CertificateApprovalJS/submit.js"></script>
<script src="../../js/CertificateApprovalJS/get.js"></script>
<script src="../../js/CertificateApprovalJS/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
        var profileId = "{{$id}}";
//Load table
        loadTable(profileId);
        $('#trackDate,#trackDateAssDir,#trackDateDir').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
        get_initial_approvalStatus(profileId, function (res) {
            showHide_Content_By_Status(res);
        });
        function showHide_Content_By_Status(status) {
            let type = status.officer_type;
            let st = status.status;
            $('.envOfficer_section').prop('disabled', true);
            $('.astDir_section').prop('disabled', true);
            $('.director_sectiom').prop('disabled', true);
            switch (type) {
                case 'director':
                    if (st == 0) {
                        $('.director_sectiom').prop('disabled', false);
                    } else {
                        $('.astDir_section').prop('disabled', false);
                    }
                    break;

                case 'a_director':
                    if (st == 0) {
                        $('.director_sectiom').prop('disabled', false);
                    } else {
                        $('.envOfficer_section').prop('disabled', false);
                    }
                    break;

                case 'officer':
                    if (st == 0) {//env officer approved
                        $('.astDir_section').prop('disabled', false);
                    }else{
                          $('.envOfficer_section').prop('disabled', false);
                    }
                    break;


                case 'new':
                    $('.envOfficer_section').prop('disabled', false);
                    break;

                default:
                    break;
            }
        }
//click save button
        $('#btnSave').click(function () {
            var data = fromValues();
            if (Validiteinsert(data)) {
                // if validiated
                AddEnvOfficer(data, profileId, function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Enviremontal MS</br>Saved'
                        });
                        get_initial_approvalStatus(profileId, function (res) {
                            showHide_Content_By_Status(res);
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>Error'
                        });
                    }
                    loadTable(profileId);
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
        $('#btnSave2').click(function () {
            var data = fromValues2();
            if (Validiteinsert2(data)) {
                // if validiated
                AddAssDir(data, profileId, function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Enviremontal MS</br>Saved'
                        });
                        get_initial_approvalStatus(profileId, function (res) {
                            showHide_Content_By_Status(res);
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>Error'
                        });
                    }
                    loadTable(profileId);
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
        $('#btnSave3').click(function () {
            var data = fromValues3();
            if (Validiteinsert3(data)) {
                // if validiated
                AddDir(data, profileId, function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Enviremontal MS</br>Saved'
                        });
                        get_initial_approvalStatus(profileId, function (res) {
                            showHide_Content_By_Status(res);
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>Error'
                        });
                    }
                    loadTable(profileId);
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
//click delete button
        $('#btnshowDelete').click(function () {
            var data = fromValues();
            deleteEnvOfficer(data, profileId, function (result) {
                if (result.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: 'Enviremontal MS</br>Removed!'
                    });
                    get_initial_approvalStatus(profileId, function (res) {
                        showHide_Content_By_Status(res);
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: 'Enviremontal MS</br>Error'
                    });
                }
                loadTable(profileId);
                showSave();
                resetinputFields();
                hideAllErrors();
            });
        });
        $('#btnshowDelete2').click(function () {
            var data = fromValues2();
            deleteAssDir(data, profileId, function (result) {
                if (result.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: 'Enviremontal MS</br>Removed!'
                    });
                    get_initial_approvalStatus(profileId, function (res) {
                        showHide_Content_By_Status(res);
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: 'Enviremontal MS</br>Error'
                    });
                }
                loadTable(profileId);
                showSave();
                resetinputFields();
                hideAllErrors();
            });
        });
        $('#btnshowDelete3').click(function () {
            var data = fromValues3();
            deleteDir(data, profileId, function (result) {
                if (result.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: 'Enviremontal MS</br>Removed!'
                    });
                    get_initial_approvalStatus(profileId, function (res) {
                        showHide_Content_By_Status(res);
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: 'Enviremontal MS</br>Error'
                    });
                }
                loadTable(profileId);
                showSave();
                resetinputFields();
                hideAllErrors();
            });
        });
    }
    );
    //show update buttons    
    function showUpdate() {
        $('#btnSave').addClass('d-none');
        $('#btnUpdate').removeClass('d-none');
    }
    //show save button    
    function showSave() {
        $('#btnSave').removeClass('d-none');
        $('#btnUpdate').addClass('d-none');
    }
    //Reset all fields    
    function resetinputFields() {
        $('#getEnvOfficerCmt').val('');
        $('#getAssDirCmt').val('');
        $('#getDirCmt').val('');
    }
//get form values
    function fromValues() {
        var Start = $('#trackDate').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var data = {
            date: Start,
            comment: $('#getEnvOfficerCmt').val()
        };
        return data;
    }
    function fromValues2() {
        var StartAssDir = $('#trackDateAssDir').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var data = {
            date: StartAssDir,
            comment: $('#getAssDirCmt').val()
        };
        return data;
    }
    function fromValues3() {
        var StartDir = $('#trackDateDir').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var data = {
            date: StartDir,
            comment: $('#getDirCmt').val()
        };
        return data;
    }
    //HIDE ALL ERROR MSGS   
    function hideAllErrors() {
        $('#valName').addClass('d-none');
        $('#valCode').addClass('d-none');
        $('#uniName').addClass('d-none');
        $('#uniCode').addClass('d-none');
    }
</script>
@endsection

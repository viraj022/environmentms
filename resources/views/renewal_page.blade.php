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
                <h1>Renewal</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-success">
                    <div class="card-header">
                        <label id="lblTitle">Add New Renewal</label>
                    </div>
                    <div class="card-body">
                        <!--                        <div class="form-group">
                                                    <label>New Or Old*</label>
                                                    <select id="getNewOld" class="form-control form-control-sm">
                                                        <option value="1">New</option>
                                                        <option value="0">Old</option>
                                                    </select>
                                                    <div id="valPayType" class="d-none"><p class="text-danger">Field is required</p></div>
                                                </div>-->
                        <div class="form-group">
                            <label>Remark</label>
                            <input id="getRemarkVal" type="text" class="form-control form-control-sm"
                                   placeholder="Enter Remark..."
                                   value="">
                            <div id="valName" class="d-none"><p class="text-danger">Remark is required</p></div>
                        </div>
                        <div class="form-group">
                            <label>Date *</label>
                            <input id="renewDate" type="date" max="2999-12-31" class="form-control form-control-sm" placeholder="" value="">
                        </div>
                        <div class="form-group">
                            <label>Renewal Application*</label>
                            <input id="inp" accept="image/*,application/pdf" type="file">
                        </div>
                        <div class="progress d-none">
                            <div class="progress-bar bg-primary progress-bar-striped Uploadprogress" id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                <!--<span class="sr-only">40% Complete (success)</span>-->
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="submit" class="btn btn-success">Submit Application</button>
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
                <div class="card card-success">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">All Renewals</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <table class="table table-condensed" id="tblZone">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Name</th>
                                                        <th>Code</th>
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
<script src="../../js/RenewalJS/post_data.js"></script>
<script src="../../js/commonFunctions/file_upload.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    let PROFILE_ID = '{{$id}}';
    $(function () {
//Load table
//        loadTable();   
//             
//click save button
        $('#btnSave').click(function () {
            var data = fromValues();
            if (Validiteinsert(data)) {
                // if validiated
                saveRenew(PROFILE_ID, data, function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Enviremontal MS</br>Saved'
                        });
                        window.location.href = ""+result.rout;
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>Error'
                        });
                    }
//                    loadTable();
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
        $(document).on('change', '#inp', function () {
            readImage(this.id, function (result) {
                renew_file = result;
            });
        });
//click update button
        $('#btnUpdate').click(function () {
            //get form data
            var data = fromValues();
            if (Validiteupdate(data)) {
                updateZone($('#btnUpdate').val(), data, function (result) {
                });
            }
        });
//click delete button
        $('#btnDelete').click(function () {
            deleteZone($('#btnDelete').val(), function (result) {

            });
        });
//select button action 
        $(document).on('click', '.btnAction', function () {
            getaZonebyId(this.id, function (result) {
                $('#getName').val(result.name);
                $('#getCode').val(result.code);
                showUpdate();
                $('#btnUpdate').val(result.id);
                $('#btnDelete').val(result.id);
            });
            hideAllErrors();
        });
    });
//show update buttons    
    function showUpdate() {
        $('#btnSave').addClass('d-none');
        $('#btnUpdate').removeClass('d-none');
        $('#btnshowDelete').removeClass('d-none');
    }
//show save button    
    function showSave() {
        $('#btnSave').removeClass('d-none');
        $('#btnUpdate').addClass('d-none');
        $('#btnshowDelete').addClass('d-none');
    }
//Reset all fields    
    function resetinputFields() {
        $('#getRemarkVal').val('');
        $('#renewDate').val('');
        $('#btnUpdate').val('');
        $('#btnDelete').val('');
    }
//get form values
    function fromValues() {
        var data = {
            client_id: PROFILE_ID,
            created_date: $('#renewDate').val(),
            remark: $('#getRemarkVal').val(),
            file: $('#inp')[0].files[0]
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
    function readImage(img_selector, callback) {
        var img = document.getElementById(img_selector);
        if (img.files && img.files[0]) {
            var FR = new FileReader();
            FR.addEventListener("load", function (e) {
                callback(e.target.result)
            });
            FR.readAsDataURL(img.files[0]);
        } else {
            alert("No Image");
        }
    }
</script>
@endsection

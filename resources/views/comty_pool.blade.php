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
                <h1>Committee Pool</h1>
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
                        <label id="lblTitle">Create New Committee</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>First Name*</label>
                            <input id="getFname" type="text" class="form-control form-control-sm"
                                   placeholder="Enter attachment..."
                                   value="">
                            <div id="valFname" class="d-none"><p class="text-danger">First Name is required!</p></div>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input id="getLname" type="text" class="form-control form-control-sm"
                                   placeholder="Enter Last Name..."
                                   value="">
                        </div>
                        <div class="form-group">
                            <label>NIC</label>
                            <input id="getNic" maxlength="12" type="text" class="form-control form-control-sm"
                                   placeholder="Enter NIC Number..."
                                   value="">
                            <div id="valUnique" class="d-none"><p class="text-danger">NIC already taken!</p></div>
                            <div id="valNic" class="d-none"><p class="text-danger">Invalid NIC Number!</p></div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input id="getEmail" type="text" class="form-control form-control-sm"
                                   placeholder="Enter Email..."
                                   value="">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input id="getAddress" type="text" class="form-control form-control-sm"
                                   placeholder="Enter Address..."
                                   value="">
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input id="getContact" maxlength="10" type="text" class="form-control form-control-sm"
                                   placeholder="Enter Contact Number..."
                                   value="">
                            <!--<div id="valContact" class="d-none"><p class="text-danger">Invalid Contact Number!</p></div>-->
                            <div id="valContact" class="d-none"><p class="text-danger">Invalid Contact Number! (Example: 0714564567)</p></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="submit" class="btn btn-primary">Save</button>
                        @endif
                        @if($pageAuth['is_update']==1 || false)
                        <button id="btnUpdate" type="submit" class="btn btn-warning d-none">Update</button>
                        @endif
                        @if($pageAuth['is_delete']==1 || false)
                        <button  id="btnshowDelete" type="submit" class="btn btn-danger d-none"  data-toggle="modal"
                                 data-target="#modal-danger">Delete</button>
                        @endif
                        <button id="btnReset" type="submit" class="btn btn-secondary">Reset</button>
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
                                        <h3 class="card-title">Committees</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <table class="table table-bordered table-striped" id="tblCommittees">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>First Name</th>
                                                        <th>NIC</th>
                                                        <th>Action</th>
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
                <p><b>Are you sure you want to permanently delete this Committee ? </b></p>
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
<script src="../../js/CommitteeJS/submit.js"></script>
<script src="../../js/CommitteeJS/get.js"></script>
<script src="../../js/CommitteeJS/update.js"></script>
<script src="../../js/CommitteeJS/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000

        });
//Load table
        loadTableUI();
//click save button
        $('#btnSave').click(function () {
            var data = fromValues();
            if (Validiteinsert(data)) {
                // if validiated
                uniqueNICcheck(data.nic, function (r) {
//                    alert(JSON.stringify(r));
                    if (r.message == 'true') {
                        AddCommittee(data, function (result) {
                            if (result.id == 1) {
                                Toast.fire({
                                    type: 'success',
                                    title: 'Saved Successfully'
                                });
                            } else {
                                Toast.fire({
                                    type: 'error',
                                    title: 'Something Went Wrong!'
                                });
                            }
                            loadTableUI();
                            resetinputFields();
                            hideAllErrors();
                        });
                    } else
                    {
                        $('#valFname').addClass('d-none');
                        $('#valUnique').removeClass('d-none');
                    }
                });
            }
        });
//click update button
        $('#btnUpdate').click(function () {
            //get form data
            var data = fromValues();
            if (Validiteupdate(data)) {
                updateCommittee($('#btnUpdate').val(), data, function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: ' Updated Successfully'
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Something Went Wrong!'
                        });
                    }
                    loadTableUI();
                    showSave();
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
//click delete button
        $('#btnDelete').click(function () {
            deleteCommittee($('#btnDelete').val(), function (result) {
                if (result.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: 'Removed Successfully'
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: 'Something Went Wrong!'
                    });
                }
                loadTableUI();
                showSave();
                resetinputFields();
            });
            hideAllErrors();
        });
//select button action 
        $(document).on('click', '.btnAction', function () {
            getaCommitteebyId(this.id, function (result) {
                $('#getFname').val(result.first_name);
                $('#getLname').val(result.last_name);
                $('#getNic').val(result.nic);
                $('#getEmail').val(result.email),
                $('#getAddress').val(result.address);
                $('#getContact').val(result.contact_no);
                showUpdate();
                $('#btnUpdate').val(result.id);
                $('#btnDelete').val(result.id);
            });
            hideAllErrors();
        });
    });
//Check change of name input   
    $('#getNic').change(function () {
        var data = fromValues();
        uniqueNICcheck(data.nic, function (r) {
            if (r.message === 'true') {
                $('#valFname').addClass('d-none');
                $('#valUnique').addClass('d-none');

            } else
            {
                $('#valFname').addClass('d-none');
                $('#valUnique').removeClass('d-none');
            }
        });
    });
    //Reset
    $('#btnReset').click(function () {
        resetinputFields();
        hideAllErrors();
        $('#valContact').addClass('d-none');
        $('#valNic').addClass('d-none');
        showSave();
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
        $('#getFname').val('');
        $('#getLname').val('');
        $('#getNic').val('');
        $('#getEmail').val(''),
        $('#getAddress').val('');
        $('#getContact').val('');
        $('#btnUpdate').val('');
        $('#btnDelete').val('');
        $('#valFname').addClass('d-none');
        $('#valUnique').addClass('d-none');
    }
//HIDE ALL ERROR MSGS   
    function hideAllErrors() {
        $('#valUnique').addClass('d-none');
        $('#getFname').addClass('d-none');
        $('#valNic').addClass('d-none');
        $('#valContact').addClass('d-none');
    }
//get form values
    function fromValues() {
        var data = {
            first_name: $('#getFname').val(),
            last_name: $('#getLname').val(),
            nic: $('#getNic').val(),
            email: $('#getEmail').val(),
            address: $('#getAddress').val(),
            contact_no: $('#getContact').val()
        };
        return data;
    }

</script>
@endsection

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
                <h1>Client Space</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <!--    Register New Client START-->
    <div class="container-fluid reg-newClient d-none">
        <div class="row">

            <div class="col-md-12">
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <label id="lblTitle">Register New Client</label>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>First Name*</label>
                                <input id="getfName" type="text" class="form-control form-control-sm"
                                       placeholder="Enter Name..."
                                       value="">
                                <div id="valName" class="d-none"><p class="text-danger">Name is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Last Name*</label>
                                <input id="getlName" type="text" class="form-control form-control-sm"
                                       placeholder="Enter Name..."
                                       value="">
                                <div id="valName" class="d-none"><p class="text-danger">Name is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Address*</label>
                                <input id="getAddress" type="text" class="form-control form-control-sm"
                                       placeholder="Enter Name..."
                                       value="">
                                <div id="valName" class="d-none"><p class="text-danger">Name is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Contact Number*</label>
                                <input id="getContact" type="text" class="form-control form-control-sm"
                                       placeholder="Enter Name..."
                                       value="">
                                <div id="valName" class="d-none"><p class="text-danger">Name is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Email*</label>
                                <input id="getEmail" type="text" class="form-control form-control-sm"
                                       placeholder="Enter Name..."
                                       value="">
                                <div id="valName" class="d-none"><p class="text-danger">Name is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>NIC*</label>
                                <input id="getNicSave" type="text" class="form-control form-control-sm"
                                       placeholder="Enter Name..."
                                       value="">
                                <div id="valName" class="d-none"><p class="text-danger">Name is required</p></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($pageAuth['is_create']==1 || false)
                            <button id="btnSave" type="submit" class="btn btn-success">Register</button>
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
<!--If something about Datatable place tt here again! -->
            </div>
        </div>
    </div>
    <!--Register New Client END-->

    <!---------END ALL------------>

    <!--Search Client By NIC START-->
    <div class="container-fluid search-Client">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <label id="lblTitle">Search Client</label>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>NIC Number*</label>
                                <input id="getNic" type="text" class="form-control form-control-sm"
                                       placeholder="Enter NIC Number..."
                                       value="">
                                <div id="valName" class="d-none"><p class="text-danger">Name is required</p></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($pageAuth['is_create']==1 || false)
                            <button id="btnSearch" type="submit" class="btn btn-success">Search</button>
                            @endif
                        </div>                           
                    </div>
                </div>                                       
            </div>
        </div>
    </div>
    <!--Search Client By NIC END-->

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
<section>
    <div class="viewClientData d-none">
        <p>Here Is Our Client Data!</p>
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
<script src="../../js/ClientJS/submit.js"></script>
<script src="../../js/ClientJS/get.js"></script>
<script src="../../js/ClientJS/update.js"></script>
<script src="../../js/ClientJS/delete.js"></script>
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
        loadTable();
//Register Button
        $('#btnSave').click(function () {
            var data = fromValues();
            if (Validiteinsert(data)) {
                // if validiated
                AddClient(data, function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Enviremontal MS</br>Saved'
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>Error'
                        });
                    }
                    loadTable();
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
//click update button
        $('#btnUpdate').click(function () {
            //get form data
            var data = fromValues();
            if (Validiteupdate(data)) {
                updatePaymentCat($('#btnUpdate').val(), data, function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Enviremontal MS</br>Updated'
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>Error'
                        });
                    }
                    loadTable();
                    showSave();
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
//click delete button
        $('#btnDelete').click(function () {
            deletePaymentCat($('#btnDelete').val(), function (result) {
                if (result.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: 'Enviremontal MS</br>Removed!'
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: 'Enviremontal MS</br>Error'
                    });
                }
                loadTable();
                showSave();
                resetinputFields();
                hideAllErrors();
            });
        });
//select button action 
        $(document).on('click', '.btnAction', function () {
            getaPaymentCatbyId(this.id, function (result) {
                $('#getName').val(result.name);
                showUpdate();
                $('#btnUpdate').val(result.id);
                $('#btnDelete').val(result.id);
            });
            hideAllErrors();
        });
//Search NIC Button 
        $(document).on('click', '#btnSearch', function () {
            getClientbyNic($('#getNic').val(), function (result) {
                if (result.id == -1) {
                    alert("Client Not Found");
                    $('.search-Client').addClass('d-none');
                    $('.reg-newClient').removeClass('d-none');
                } else {
                    alert("Client Found Yeha!");
                    $('.search-Client').addClass('d-none');
                    $('.viewClientData').removeClass('d-none');
                }
//                $('#getName').val(result.name);
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
        $('#getName').val('');
        $('#btnUpdate').val('');
        $('#btnDelete').val('');
    }
//get form values
    function fromValues() {
        var data = {
            first_name: $('#getfName').val(),
            last_name: $('#getlName').val(),
            address: $('#getAddress').val(),
            contact_no: $('#getContact').val(),
            email: $('#getEmail').val(),
            nic: $('#getNicSave').val(),
            //password: $('#gefkfg').val(),
            //conpassword: $('#getfffk').val()
        };
        return data;
    }
//HIDE ALL ERROR MSGS   
    function hideAllErrors() {
        $('#valName').addClass('d-none');
    }
</script>
@endsection

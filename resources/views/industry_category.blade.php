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
                <h1>Industry Category</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-gray">
                    <div class="card-header">
                        <label class="card-title" id="lblTitle">Add New Industry Category</label>
                    </div>
                    <div class="card-body">
                        <label>Name*</label>
                        <input id="getIndustryName" maxlength="50" type="text" class="form-control form-control-sm" placeholder="Enter Industry Name..." value="">
                        <div id="valIndustryName" class="d-none">
                            <p class="text-danger">Industry Name is required</p>
                        </div>
                        <div id="valUnique" class="d-none">
                            <p class="text-danger">Name already taken!</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <label>Code*</label>
                        <input id="getIndustryCode" maxlength="5" type="text" class="form-control form-control-sm" placeholder="Enter Industry Code..." value="">
                        <div id="valIndustryCode" class="d-none">
                            <p class="text-danger">Industry Code is required</p>
                        </div>
                        <div id="valCodeUnique" class="d-none">
                            <p class="text-danger">Code already taken!</p>
                        </div>
                    </div>

                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="submit" class="btn btn-success">Save</button>
                        @endif
                        @if($pageAuth['is_update']==1 || false)
                        <button id="btnUpdate" type="submit" class="btn btn-warning d-none">Update</button>
                        @endif
                        @if($pageAuth['is_delete']==1 || false)
                        <button id="btnshowDelete" type="submit" class="btn btn-danger d-none" data-toggle="modal" data-target="#modal-danger">Delete</button>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-md-7">
                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title">Industry Categories</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-condensed assignedPrivilages" id="tblIndustryCat">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Industry Name</th>
                                        <th>Industry Code</th>
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
    <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Industry Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Are you sure you want to permanently delete this Industry Category? </b></p>
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
<script src="../../js/industrycatjs/submit.js"></script>
<script src="../../js/industrycatjs/get.js"></script>
<script src="../../js/industrycatjs/update.js"></script>
<script src="../../js/industrycatjs/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function() {
        //Load table
        loadTable();
        //click save button
        $('#btnSave').click(function() {
            var data = fromValues();
            if (Validiteinsert(data)) {
                //if validiated!
                uniqueNamecheck(data.name, function(r) {
                    uniqueCodecheck(data.code, function(re) {
                        if (r.message == 'unique') {
                            if (re.message == 'unique') {
                                AddIndustry(data, function(result) {
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
                                    location.reload(true);
                                    resetinputFields();
                                });
                            } else {
                                $('#valIndustryName').addClass('d-none');
                                //$('#valUnique').removeClass('d-none');
                                $('#valCodeUnique').removeClass('d-none');
                            }
                        } else {
                            $('#valIndustryName').addClass('d-none');
                            $('#valUnique').removeClass('d-none');
                            //                            $('#valCodeUnique').removeClass('d-none');
                        }
                    });
                });
            }
            hideAllErrors();
        });
        //click update button
        $('#btnUpdate').click(function() {
            //get form data
            var data = fromValues();
            if (Validiteupdate(data)) {
                updateIndustry($('#btnUpdate').val(), data, function(result) {
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
                    location.reload(true);
                    showSave();
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
        //click delete button
        $('#btnDelete').click(function() {
                deleteIndustry($('#btnDelete').val(), function(result) {
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
                    location.reload(true);
                    showSave();
                    resetinputFields();
                    hideAllErrors();
                });
        });
        
        //select button action 
        $(document).on('click', '.btnAction', function() {
            getaIndustrybyId(this.id, function(result) {
                $('#getIndustryName').val(result.name);
                $('#getIndustryCode').val(result.code);
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
        $('#getIndustryName').val('');
        $('#getIndustryCode').val('');
        $('#btnUpdate').val('');
        $('#btnDelete').val('');
    }
    //HIDE ALL ERROR MSGS   
    function hideAllErrors() {
        $('#valCodeUnique').addClass('d-none');
        $('#valUnique').addClass('d-none');
    }
    //get form values
    function fromValues() {
        var data = {
            name: $('#getIndustryName').val(),
            code: $('#getIndustryCode').val()
        };
        return data;
    }
</script>
@endsection
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
                <h1>Payments</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <label id="lblTitle">Add New Payment Range(Press Enter)</label>
                    </div>
                    <div class="card-body">
                        <div class="row" id="getFromToAmount">
                            <div class="col-3"> <label>From*</label></div>
                            <div class="col-3"><label>To*</label></div>
                            <div class="col-4"> <label>Amount*</label></div>
                            <div class="col-2"></div>
                        </div>
                        <div class="row form-group create-Now">
                            <div class="col-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Enter From..">
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Enter To..">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control form-control-sm" placeholder="Enter Amount..">
                            </div>   
                            <div class="col-1">
                                <button type="button" class="btn btn-block btn-outline-primary btn-xs make-new"><i class="fas fas fa-plus"></i></button>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-block btn-outline-danger btn-xs make-remove"><i class="fas fas fa-minus"></i></button>
                            </div>
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
                    </div>                           
                </div>
            </div>


            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">All Payment Ranges</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <table class="table table-condensed" id="tblPaymentRange">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
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
<script src="../../js/paymentrangejs/submit.js"></script>
<script src="../../js/paymentrangejs/get.js"></script>
<script src="../../js/paymentrangejs/update.js"></script>
<script src="../../js/paymentrangejs/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000

        });
//Load table & combo
        loadTable();
//click save button
        $('#btnSave').click(function () {
            var data = fromValues();
            if (Validiteinsert(data)) {
                // if validiated
                AddPaymentRange(data, function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: ' Enviremontal MS</br>Saved'
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: ' Enviremontal MS</br>Error'
                        });
                    }
                    loadTable($('#getPaymentInfobyCat').val());
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
                updatePaymentRange($('#btnUpdate').val(), data, function (result) {
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
            deletePaymentRange($('#btnDelete').val(), function (result) {
                if (result.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: ' Enviremontal MS</br>Removed!'
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: ' Enviremontal MS</br>Error'
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
            getaPaymentRangebyId(this.id, function (result) {
                $('#getPaymentCat').val(result.payment_type_id);
                $('#getName').val(result.name);
                $('#getPaymentType').val(result.type);
                $('#getPaymentAmount').val(result.amount);
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
        $("#getPaymentType").prop("disabled", false);
        $('#getName').val('');
        $('#getPaymentCat').reset('');
        $('#btnUpdate').val('');
        $('#btnDelete').val('');
    }
//get form values
    function fromValues() {
        var data = {
            payment_type_id: $('#getPaymentCat').val(),
            name: $('#getName').val(),
            type: $('#getPaymentType').val(),
            amount: $('#getPaymentAmount').val()
        };
        return data;
    }
//HIDE ALL ERROR MSGS   
    function hideAllErrors() {
        $('#valName').addClass('d-none');
        $('#valPayCat').addClass('d-none');
        $('#valPayType').addClass('d-none');
    }
//Create New Area -Press Enter
    $(document).keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        //Add via Enter Key
        if (keycode === 13) {
            $(".create-Now:last").clone(true).insertBefore('.create-Now:last');
            event.preventDefault();
        }
        //Remove via Del Key
        if (keycode === 46) {
            alert("fk not workin????");
            $(this).closest('.create-Now').remove();
        }
    });
//Create New Area
    $(function genNewAmount() {
        //Create
        $(".make-new").on('click', function () {
            var ele = $(this).closest('.create-Now').clone(true);
            $(this).closest('.create-Now').after(ele);
        });
        //Remove
        $(".make-remove").on('click', function () {
            if ($(".create-Now")[1]) {
                $(this).closest('.create-Now').remove();
            } else {
                return false;
            }
        });
    });
</script>
@endsection

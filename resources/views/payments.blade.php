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
            <div class="col-md-5">
                <div class="card card-gray">
                    <div class="card-header">
                        <label class="card-title" id="lblTitle">Add New Payment</label>
                    </div>
                    <div class="card-body">
                        <form id="payment_form">
                            <div class="form-group">
                                <label>Payment Category*</label>
                                <select id="getPaymentCat" class="form-control form-control-sm">
                                    <option>Loading...</option>
                                </select>
                                <div id="valPayCat" class="d-none">
                                    <p class="text-danger">Field is required</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Payment Name*</label>
                                <input id="getName" maxlength="75" type="text" class="form-control form-control-sm" placeholder="Enter Name..." value="">
                                <div id="valName" class="d-none">
                                    <p class="text-danger">Name is required</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Payment Type*</label>
                                <select id="getPaymentType" class="form-control form-control-sm">
                                    <option value="regular">Regular</option>
                                    <option value="unit">Unit</option>
                                    <option value="ranged">Ranged</option>
                                </select>
                                <div id="valPayType" class="d-none">
                                    <p class="text-danger">Field is required</p>
                                </div>
                            </div>
                            <div class="form-group" id="useToHideAmount">
                                <label>Amount(Rs)*</label>
                                <input id="getPaymentAmount" maxlength="11" type="number" class="form-control form-control-sm" placeholder="Amount" value="">
                                <div id="valAmount" class="d-none">
                                    <p class="text-danger">Field is required</p>
                                </div>
                            </div>
                        </form>
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
                        <h3 class="card-title">Payments</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Payment Category*</label>
                            <select id="getPaymentInfobyCat" class="custom-select form-control-sm">
                                <option>Loading...</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-condensed" id="tblPayments">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Amount(Rs)</th>
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
<script src="../../js/paymentsjs/submit.js"></script>
<script src="../../js/paymentsjs/get.js"></script>
<script src="../../js/paymentsjs/update.js"></script>
<script src="../../js/paymentsjs/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function() {
        //Load table & combo
        loadPayInfoCatCombo(function() {
            loadTable($('#getPaymentInfobyCat').val());
        });
        loadPayCatCombo();
        //click save button
        $('#btnSave').click(function() {
            var data = fromValues();
            if (Validiteinsert(data)) {
                // if validiated
                AddPayments(data, function(result) {
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
                    // loadTable($('#getPaymentInfobyCat').val());
                    location.reload(true);
                    $('#payment_form').trigger("reset");
                    // resetinputFields();
                    hideAllErrors();
                });
            }
        });
        //click update button
        $('#btnUpdate').click(function() {
            //get form data
            var data = fromValues();
            if (Validiteupdate(data)) {
                updatePayments($('#btnUpdate').val(), data, function(result) {
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
                    // loadTable($('#getPaymentInfobyCat').val());
                    location.reload(true);
                    showSave();
                    $('#payment_form').trigger("reset");
                    // resetinputFields();
                    hideAllErrors();
                });
            }
        });
        //click delete button
        $('#btnDelete').click(function() {
            deletePayments($('#btnDelete').val(), function(result) {
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
                // loadTable($('#getPaymentInfobyCat').val());
                location.reload(true);
                showSave();
                $('#payment_form').trigger("reset");
                // resetinputFields();
                hideAllErrors();
            });
        });
        //select button action 
        $(document).on('click', '.btnAction', function() {
            getaPaymentsbyId(this.id, function(result) {
                $('#getPaymentCat').val(result.payment_type_id);
                $('#getName').val(result.name);
                $('#getPaymentType').val(result.type);
                $('#getPaymentAmount').val(result.amount);
                showUpdate();
                $('#btnUpdate').val(result.id);
                $('#btnDelete').val(result.id);
                if (result.amount === null) {
                    $('#useToHideAmount').addClass('d-none');
                } else {
                    $('#useToHideAmount').removeClass('d-none');
                }
            });
            $("#getPaymentType").prop("disabled", true);
            hideAllErrors();
        });
    });
    //Payment Cat Info To Loadtable
    $("#getPaymentInfobyCat").change(function() {
        loadTable($(this).val());
    });
    //Show amount by payment type
    $("#getPaymentType").change(function() {
        if ($(this).val() === 'ranged') {
            $('#useToHideAmount').addClass('d-none');
        } else {
            $('#useToHideAmount').removeClass('d-none');
        }
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
    // //Reset all fields    
    // function resetinputFields() {
    //     $("#getPaymentType").prop("disabled", false);
    //     $('#getName').val('');
    //     $('#getPaymentCat').reset('');
    //     $('#btnUpdate').val('');
    //     $('#btnDelete').val('');
    // }
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
</script>
@endsection
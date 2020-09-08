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
                <div class="card card-success">
                    <div class="card-header">
                        <label id="lblTitle">Add New Payment Range</label>
                        <div class="addNewByEnter d-none">
                            <p>(Press Enter To Add New Ranges)</p>
                            <label class="currentSelName"></label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="getFromToAmount">
                            <div class="col-3"> <label>From*</label></div>
                            <div class="col-3"><label>To*</label></div>
                            <div class="col-4"> <label>Amount*</label></div>
                            <div class="col-2"></div>
                        </div>
                        <div id="attachBoxHere">
                            <div class="row form-group create-Now">
                                <!-- Create Texboxes !-->  
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div id="trackUsr" class="col-12 tackMe"> <label>Please Select A Payment Range.</label></div>
                        @if($pageAuth['is_create']==1 || false)
                        <div class="divSave">   </div>
                        @endif

                        @if($pageAuth['is_delete']==1 || false)
                        <div class="divDelete">
                            <!--                        <button  id="btnshowDelete" type="submit" class="btn btn-danger d-none"  data-toggle="modal"
                                                             data-target="#modal-danger">Delete</button
                                                    </div>-->
                        </div>
                        @endif
                    </div>                           
                </div>
            </div>


            <div class="col-md-6">
                <div class="card card-success">
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
//Load table & combo
        loadTable();
//click save button
        $(document).on('click', '#btnSave', function () {
            var data = {
                payment_id: selected,
                range: []
            }
            var values_container = $('.create-Now');
            $.each(values_container, function (key, value) {
                var range = {
                    from: 0,
                    to: 0,
                    amount: 0
                }
                range.from = $(value).find('.txt-from').val();
                if ($(value).find('.txt-to').val() === '') {
                    range.to = 'max';
                } else {
                    range.to = $(value).find('.txt-to').val();
                }
                range.amount = $(value).find('.txt-amount').val();
//                alert(range.to.length);
                if (range.from.length > 0 && range.amount.length > 0) {
//                    alert(range.to.length);
                    data.range.push(range);
                }
//                alert(txtFrom);
            });
            AddPaymentRange(data, function (result) {
                if (result.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: ' Successfully Saved!'
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: ' Something Went Wrong!'
                    });
                }
                loadTable();
                createPaymentRangeBox(selected);
                hideAllErrors();
            });
//            alert(JSON.stringify(data));
        });
//        
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
//select button action 
        $(document).on('click', '.btnAction', function (result) {
            selected = this.id;
            createPaymentRangeBox(this.id);
            hideAllErrors();
            $('#trackUsr').addClass('d-none');
            $('.addNewByEnter').removeClass('d-none');
            $('.currentSelName').text('Name: ' + $(this).val());
//            alert($(this).val());
        });
//click delete button
        $('#btnDelete').click(function () {
            deletePaymentRange(selected, function (result) {
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
                createPaymentRangeBox();
                hideAllErrors();
            });
        });
    });
//show save button    
    function showSave() {
        $('#btnSave').removeClass('d-none');
        $('#btnUpdate').addClass('d-none');
        $('#btnshowDelete').addClass('d-none');
    }
//Reset all fields    
    function resetinputFields() {
        $('.txt-from').val('');
        $('.txt-to').val('');
        $('.txt-amount').val('');
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
            if ($('#trackUsr').hasClass('d-none')) {
                if ($('#btnSave').hasClass('btn-success')) {
                    loadTextBoxes();
                    event.preventDefault();
                } else {
                    alert('Please Delete And Add New Ranges');
                }
            } else {
                alert('Please select a payment range.');
            }
        }
        //Remove via Del Key
        else if (keycode === 16) {
            alert(" not workin????");
            if ($(".create-Now")[1]) {
                $(document).closest('.create-Now').remove();
            } else {
                return false;
            }
        }
    });
//Create New Area
    $(function genNewAmount() {
        //Create
        $(document).on('click', '.make-new', function () {
            loadTextBoxes();
        });
        //Remove
        $(document).on('click', '.make-remove', function () {
            if ($(".create-Now")[1]) {
                $(this).closest('.create-Now').remove();
            } else {
                return false;
            }
        });
    });
</script>
@endsection

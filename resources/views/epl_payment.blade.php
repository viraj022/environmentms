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
            <div class="col-12">
                <h1>(<a href="/{{$type_title}}/client/{{$client}}/profile/{{$id}}">{{$epl_no}}</a>) <b class="siteDataType">...</b></h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Application Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Inspection Type *</label>
                            <select id="epl_methodCombo" class="form-control form-control-sm">
                                <option>Loading...</option>
                            </select>
                        </div>
                        <label>Amount <b class="text-success ifPaidRaid"></b></label>
                        <div class="input-group mb-3">
                            <input id="paymnt_amount" type="number" class="form-control form-control-sm" placeholder="" value="">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-sm btn-dark" id="inspection_payBtn">Add</button>
                            </div>
                            <!-- /btn-group -->
                        </div>
                        <div class="form-group eiApaySection d-none">
                            <label id="applicationtype_lbl">EIA Payment*</label>
                            <input id="eiaPayment" type="text" class="form-control form-control-sm" placeholder="0.00" value="">
                        </div>
                        <hr>

                        <div id="fineDev" class="d-none">
                            <div class="form-group">
                                <label>Fine Type</label>
                                <select id="fine_list" class="form-control form-control-sm">
                                    <option>Loading...</option>
                                </select>
                            </div>

                            <label>Fine <b class="text-success ifPaidFine"></b></label>
                            <div class="input-group mb-3">
                                <input id="fine_amt" type="number" class="form-control form-control-sm" placeholder="" value="">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-sm btn-dark" id="fine_payBtn">Add</button>
                                </div>
                                <!-- /btn-group -->
                            </div>
                        </div>


                        <hr>
                        <div class="form-group">
                            <label>Certificate List *</label>
                            <select id="certificate_list" class="form-control form-control-sm">
                                <option>Loading...</option>
                            </select>
                        </div>

                        <label>Certificate Amount *<b class="text-success ifPaidLicFee"></b></label>
                        <div class="input-group mb-3">
                            <input id="cert_amt" type="number" class="form-control form-control-sm" placeholder="" readonly="" value="">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-sm btn-dark" id="certificate_payBtn">Add</button>
                            </div>
                            <!-- /btn-group -->
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="submit" class="btn btn-success pull-right"><i class="fa fa-print"></i> &nbsp;Complete</button>
                        @endif
                    </div>                           
                </div>
            </div>


            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Pending Payment List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="card-body table-responsive" style="height: 450px;">
                                    <table class="table table-condensed" id="tbl_applications">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th style="">Action</th>
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
</section>
@endif
@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Select2 -->
<script src="/../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="/../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="/../../plugins/moment/moment.min.js"></script>
<script src="/../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="/../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="/../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="/../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="/../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/../../js/paymentsjs/epl_payments.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
        // alert("123");
        var ITEM_LIST = [];
        var EPL_ID = "{{$id}}";
        var TYPE = '{{$type}}';

        processingFeeList();
        if (TYPE == 'epl') {
            $('.siteDataType').html('EPL Payment');
            loadEPL_details(EPL_ID, function (parameters) {
                loadEPL_methodCombo(function () {
                    if (parameters.inspection.status == "not_payed") {
                        calc_amount();
                    } else {
                        $('.ifPaidRaid').text('(Paid)');
                    }
                    if (parameters.fine.status == "payed") {
                        $('.ifPaidFine').text('(Paid)');
                        $('#fine_amt').val(parameters.fine.object.amount);
                    }
                    if (parameters.license_fee.status == "payed") {
                        $('.ifPaidLicFee').text('(Paid)');
                        $('#fine_amt').val(parameters.license_fee.object.amount);
                    }
                });
            });
            fineList_Combo(function () {
//            loadFine_amount(EPL_ID, parseFloat($('#paymnt_amount').val()), function (e) {
//            });
            });//fine combo
        } else if (TYPE == 'site_clearance') {
            $('.siteDataType').html('Site Clearance Payment');
            loadSiteClear_details(EPL_ID, function (parameters) {
                loadEPL_methodCombo(function () {
                    if (parameters.inspection.status == "not_payed") {
                        calc_amount();
                    } else {
                        $('.ifPaidRaid').text('(Paid)');
                    }
                });
            });
        } else {
            return false;
        }

        certificateList_Combo(function () {
            certificate_amount();
        });

        $('#paymnt_amount').blur(function () {
            loadFine_amount(EPL_ID, parseFloat($('#paymnt_amount').val()));
        });
        $('#fine_amt').focus(function () {
            loadFine_amount(EPL_ID, parseFloat($('#paymnt_amount').val()));
        });
        $('#certificate_list').change(function () {
            certificate_amount();
        });
        $('#epl_methodCombo').change(function () {
            calc_amount();
        });

        $('#inspection_payBtn').click(function () {// add inspection Amount
            addItemsToArray($('#epl_methodCombo').val(), "Inspection Amount", $('#paymnt_amount').val());
        });
        $('#fine_payBtn').click(function () {// add fine
            addItemsToArray($('#fine_list').val(), "Fine Amount", $('#fine_amt').val());
        });
        $('#certificate_payBtn').click(function () {// add certificate Amount
            addItemsToArray($('#certificate_list').val(), "Certificate Amount", $('#cert_amt').val());
        });
        function addItemsToArray(id, name, amount) {
            if (isValueExsist(id)) {
                alert('"' + name + '" already added !');
                return false;
            }
            if (isNaN(parseInt(id))) {
                alert('Invalid Inspection Type');
                return false;
            }
            if (isNaN(parseFloat(amount))) {
                alert('Invalid Amount');
                return false;
            }
            if (amount <= 0) {
                alert('Please Add Positive value');
                return false;

            }
            amount = parseFloat(amount).toFixed(2);
            ITEM_LIST.push({id: id, name: name, amount: amount});
            console.log(ITEM_LIST);
            selectedPayments_table(ITEM_LIST);
        }
        $(document).on('click', '.app_removeBtn', function (parameters) {
            remove_itemFrom_bill($(this).val());
        });
        $('#btnSave').click(function () {
            if (TYPE == 'epl') {
                savePayment(ITEM_LIST, EPL_ID, function (r) {
                    show_mesege(r);
                    // alert(r.name);
                    if (r.id == 1) {
                        ITEM_LIST = [];
                        selectedPayments_table(ITEM_LIST);
                        $.ajax({
                            url: 'http://127.0.0.1:8081/hansana',
                            data: {code: r.code, name: r.name},
                            success: function (result) {
                            }
                        });
                        loadEPL_details(EPL_ID, function (parameters) {
                            loadEPL_methodCombo(function () {
                                if (parameters.inspection.status == "not_payed") {
                                    calc_amount();
                                }
                            });
                        });
                    }
                });
            } else if (TYPE == 'site_clearance') {
                saveSiteClearPayment(ITEM_LIST, EPL_ID, function (r) {
                    show_mesege(r);
                    // alert(r.name);
                    if (r.id == 1) {
                        ITEM_LIST = [];
                        selectedPayments_table(ITEM_LIST);
                        $.ajax({
                            url: 'http://127.0.0.1:8081/hansana',
                            data: {code: r.code, name: r.name},
                            success: function (result) {
                            }
                        });
                        loadSiteClear_details(EPL_ID, function (parameters) {
                            loadEPL_methodCombo(function () {
                                if (parameters.inspection.status == "not_payed") {
                                    calc_amount();
                                }
                            });
                        });
                    }
                });
            } else {
                return false;
            }
        });
        function remove_itemFrom_bill(rem_val) {
// get index of object with id:37
            var removeIndex = ITEM_LIST.map(function (item) {
                return item.id;
            }).indexOf(rem_val);
// remove object
            ITEM_LIST.splice(removeIndex, 1);
            selectedPayments_table(ITEM_LIST);
        }
        function isValueExsist(value) {
            let ret = false;
            $.map(ITEM_LIST, function (val) {
                if (val.id == value) {
                    ret = true;
                }
            });
            return ret;
        }
    });
</script>
@endsection

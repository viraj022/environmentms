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
                <h1>Issue Application</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="col-md-12">
        <div class="card card-success card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Payment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Issued Applications</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card card-gray">
                                        <div class="card-header">
                                            <label class="card-title">Application Details</label>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Name *</label>
                                                <input id="cus_name" type="text" maxlength="45" class="form-control form-control-sm" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>NIC </label>
                                                <input id="cus_nic" type="text"  maxlength="12" minlength="10" class="form-control form-control-sm" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Contact </label>
                                                <input id="cus_tel" type="text" maxlength="10" class="form-control form-control-sm" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Address </label>
                                                <input id="cus_address" type="text" maxlength="45" class="form-control form-control-sm" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Application Type: </label>
                                                <select id="application_combo" class="form-control form-control-sm">
                                                    <option>Loading...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Amount *</label>
                                                <input id="amt" type="text" class="form-control form-control-sm" placeholder="" readonly="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Quantity  *</label>
                                                <input id="app_qty" type="number" class="form-control form-control-sm" placeholder="" value="1">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button id="btnAdd" type="submit" class="btn btn-success">Add</button>
                                            @if($pageAuth['is_create']==1 || false)
                                            <button id="btnSave" type="submit" class="btn btn-dark pull-right"><i class="fa fa-print"></i> &nbsp;Complete</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-7">
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
                                                            <th>Qty</th>
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
                    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                        <div class="col-md-12">
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Pending Payments</h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-sm btn-primary" id="tblRefresh"><i class="fa fa-refresh"></i> Refresh</button>&nbsp;
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="card-body table-responsive" style="height: 450px;">
                                        <table class="table table-condensed" id="tbl_pendingpays">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Name</th>
                                                    <th>NIC</th>
                                                    <th>Contact Number</th>
                                                    <th>Date</th>
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
            <!-- /.card -->
        </div>
    </div>
    <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Selected Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Are you sure you want to permanently delete this Payment? </b></p>
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
<script src="../../js/paymentsjs/application_payment.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
        var ITEM_LIST = [];
        loadApplication_types(function () {
            set_application_amount();
        });
        window.setInterval(function () {
            paymentDetals_table();
        }, 10000);
        paymentDetals_table();
        $('#application_combo').change(function () {
            set_application_amount();
        });
        $('#tblRefresh').click(function () {
            paymentDetals_table();
        });

//click save button
        loadTable();

        function getFormData() {
            let data = {
                id: parseInt($('#application_combo').val()),
                name: $('#cus_name').val().trim(),
                nic: $('#cus_nic').val().trim(),
                address: $('#cus_address').val().trim(),
                contact_no: $('#cus_tel').val().trim(),
                items: ITEM_LIST,
            };
            if (isNaN(data.id)) {
                alert('Please Select Application First!');
                return false;
            }

            if (data.items.length == 0) {
                alert('Please Select Payment Applications !');
                return false;
            }
            if (data.name.length == 0) {
                alert('Please Enter Name First!');
                return false;
            }
            return data;
        }
        $('#btnAdd').click(function () {
            add_itemToBill();
        });
        function add_itemToBill() {
            let app_id = parseInt($('#application_combo').val());
            let app_name = $('#application_combo :selected').html();
            let app_qty = parseInt($('#app_qty').val());
            let amount = parseFloat($('#amt').val());
            if (isValueExsist(app_id)) {
                alert('"' + app_name + '" already added !');
                return false;
            }
            if (isNaN(app_id)) {
                alert("invalid Application Type!");
                return false;
            }
            if (isNaN(app_qty)) {
                alert("invalid Application Qty !");
                return false;
            }
            if (isNaN(amount)) {
                alert('Please Select Application Amount First!');
                return false;
            }
            ITEM_LIST.push({id: app_id, qty: app_qty, name: app_name, amount: amount});
            selectedApplication_table(ITEM_LIST);
        }

        function remove_itemFrom_bill(rem_val) {
// get index of object with id:37
            var removeIndex = ITEM_LIST.map(function (item) {
                return item.id;
            }).indexOf(rem_val);
// remove object
            ITEM_LIST.splice(removeIndex, 1);
            selectedApplication_table(ITEM_LIST);
        }

        $(document).on('click', '.app_removeBtn', function (parameters) {
            remove_itemFrom_bill($(this).val());
        })

        $('#btnSave').click(function () {
            saveApplicationPayment(getFormData(), function (r) {
                show_mesege(r);
                if (r.id == 1) {
                    ITEM_LIST = [];
                    selectedApplication_table(ITEM_LIST);
                    $.ajax({
                        url: 'http://127.0.0.1:8081/hansana',
                        data: {code: r.code, name: r.name},
                        headers: {
                          "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                          "Accept": "application/json"
                        },
                        success: function (result) {
                        }
                    });
                    loadTable();
                    resetFormData();
                }
            });
        });
        //Issue Btn
        $(document).on('click', '.btnIssue', function (parameters) {
            issueApplication($(this).val(), function (r) {
                show_mesege(r);
                if (r.id == 1) {
                    loadTable();
                }
            });
        });
        //Del Button
        $(document).on('click', '.btnRemove', function (parameters) {
            if (confirm("Are you sure you want to delete this?")) {
                deleteIssueApplication($(this).val());
            } else {
                return false;
            }
        });

        function isValueExsist(value) {
            let ret = false;
            $.map(ITEM_LIST, function (val) {
                if (val.id == value) {
                    ret = true;
                }
            });
            return ret;
        }
        function resetFormData() {
            $('#cus_name').val('');
            $('#cus_nic').val('');
            $('#cus_address').val('');
            $('#cus_tel').val('');
        }
    });
</script>
@endsection

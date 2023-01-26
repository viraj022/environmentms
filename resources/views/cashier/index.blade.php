@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
    <section class="content-header">
        <div class="col-lg-12">
            <div class="col-md-12">
                <div class="card card-success card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill"
                                    href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home"
                                    aria-selected="true">New Client Payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile"
                                    aria-selected="false">Single Payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-three-profile" role="tab"
                                    aria-controls="custom-tabs-three-profile" aria-selected="false">Bulk Payment</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="tab-content" id="custom-tabs-two-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-two-home-tab">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header text-center bg-primary">
                                                            <h6 class="card-title">Payment Details</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mb-3">
                                                                <div class="col-lg-4">
                                                                    <label for="payment_type">Payment Type</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <select class="form-select form-control"
                                                                        aria-label="Default select example"
                                                                        id="payment_type" name="payment_type">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-4">
                                                                    <label for="category">Category</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <select class="form-select form-control"
                                                                        aria-label="Default select example" id="category"
                                                                        name="category">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-4">
                                                                    <label for="qty">Quantity</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <input type="number" name="qty" id="qty"
                                                                        class="form-control" value="1">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-lg-4">
                                                                    <label for="price">Amount</label>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <input type="number" name="price" id="price"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="float-right">
                                                                <button class="btn btn-sm btn-dark" type="button"
                                                                    id="btn_add_new_application_payment">Add</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mt-3">
                                                        <div class="card-header bg-secondary">
                                                            <h6 class="card-title">Application Invoice Generate</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table table-striped table-bordered "
                                                                id="new_application_payments_tbl">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:5%;">#</th>
                                                                        <th style="width:40%;">Payment</th>
                                                                        <th style="width:10%;">Quantity</th>
                                                                        <th style="width:15%;">Amount</th>
                                                                        <th class="" style="width:10%;">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-two-profile-tab">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card card-body">
                                                        <table class="table" id="industry_tran_table">
                                                            <colgroup>
                                                                <col style="width: 5%;">
                                                                <col style="width: 5%;">
                                                                <col style="width: 40%;">
                                                                <col style="width: 20%;">
                                                                <col style="width: 20%;">
                                                            </colgroup>
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Id</th>
                                                                    <th>Industry Name / Address</th>
                                                                    <th>Type / Amount</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-three-profile-tab">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card card-body" style="height: 400px; overflow-y:scroll">
                                                        <table class="table" id="transactions_table">
                                                            <colgroup>
                                                                <col style="width: 5%;">
                                                                <col style="width: 5%;">
                                                                <col style="width: 40%;">
                                                                <col style="width: 20%;">
                                                                <col style="width: 20%;">
                                                            </colgroup>
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Id</th>
                                                                    <th>Industry Name / Address</th>
                                                                    <th>Type / Amount</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header bg-secondary">
                                                            Industry Invoice Generate
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table" id="industry_payments_tbl">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Transaction Id</th>
                                                                        <th>Client Name</th>
                                                                        <th>Amount</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                                <tfoot>

                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <form action="" class="needs-validation" novalidate id="clientForm"
                                    name="clientForm">
                                    <div class="card">
                                        <div class="card-title text-center mt-2">
                                        </div>
                                        <div class="card-body">
                                            <input type="text" hidden value="" id="transactionId">
                                            <input type="text" hidden value="{{ $vat->rate }}" id="vatValue">
                                            <input type="text" hidden value="{{ $nbt->rate }}" id="nbtValue">
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="name">Industry Name</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="name" id="name"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="address">Industry Address</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="address" id="address"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="nic">NIC</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="nic" id="nic"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="telephone">Contact</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="telephone" id="telephone"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="invoice_date">Date</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="date" name="invoice_date" id="invoice_date"
                                                        class="form-control" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="payment_method">Payment Type</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="form-check d-inline">
                                                        <input class="form-check-input payment_method" type="radio"
                                                            name="payment_method" id="cash" value="cash" checked>
                                                        <label class="form-check-label" for="cash">
                                                            Cash
                                                        </label>
                                                    </div>
                                                    <div class="form-check d-inline mx-3">
                                                        <input class="form-check-input payment_method" type="radio"
                                                            name="payment_method" id="cheque" value="cheque">
                                                        <label class="form-check-label" for="cheque">
                                                            Cheque
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3 d-none" id="paymentReferenceField">
                                                <div class="col-lg-4">
                                                    <label for="payment_reference_number">Payment Reference
                                                        Number <br> (Cheque Number)</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="payment_reference_number"
                                                        id="payment_reference_number" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3 d-none" id="chequeDateField">
                                                <div class="col-lg-4">
                                                    <label for="cheque_issue_date">Cheque issued date</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="date" name="cheque_issue_date" id="cheque_issue_date"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="remark">Remark</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="remark" id="remark"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="sub_total">
                                                    Sub Total
                                                </label>
                                            </div>
                                            <div class="col-lg-8 ">
                                                <input type="number" name="sub_total" id="sub_total"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="sub_total">
                                                    Tax Status
                                                </label>
                                            </div>
                                            <div class="col-lg-8 ">
                                                <select class="form-select form-control"
                                                    aria-label="Default select example" name="tax_status"
                                                    id="tax_status">
                                                    <option value="non-tax" selected>Without TAX</option>
                                                    <option value="tax">TAX</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3 d-none" id="vatField">
                                            <div class="col-lg-4">
                                                <label for="vat">
                                                    Vat Rate
                                                    ({{ $vat->rate }}%)
                                                </label>
                                            </div>
                                            <div class="col-lg-8 ">
                                                <input type="text" name="vat" id="vat" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3 d-none" id="nbtField">
                                            <div class="col-lg-4">
                                                <label for="nbt">
                                                    NBT Rate
                                                    ({{ $nbt->rate }}%)
                                                </label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="nbt" id="nbt" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3 d-none" id="taxTotalField">
                                            <div class="col-lg-4">
                                                <label for="tax_total">
                                                    Tax Total
                                                </label>
                                            </div>
                                            <div class="col-lg-8 ">
                                                <input type="text" name="tax_total" id="tax_total"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="total">
                                                    Total
                                                </label>
                                            </div>
                                            <div class="col-lg-8 ">
                                                <input type="number" name="amount" id="amount" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="float-right">
                                            <button class="btn btn-danger btn-sm mx-1" type="button"
                                                id="btn_pay">Pay</button>
                                            <button class="btn btn-sm btn-success" type="button"
                                                id="btn_clear_customer_data">Clear</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script src="{{ asset('js/Cashier/cashier.js') }}"></script>
    <script src="{{ asset('js/Cashier/bulkTransactions.js') }}"></script>
    <script src="{{ asset('js/Cashier/singleTransaction.js') }}"></script>

    <script>
        $('.mainBodyClass').addClass('sidebar-collapse');

        function newPaymentAmountCal() {
            let new_pay_array = JSON.parse(localStorage.getItem("new_application_transaction_items"));
            if (new_pay_array && new_pay_array.length != 0) {
                var tot = 0;
                $.each(new_pay_array, function(k, val) {
                    tot += Number(val.amount);
                });

                $('#sub_total').val(tot.toFixed(2));
            }
        }

        function singleTranAmount() {
            let array = JSON.parse(localStorage.getItem("single_transaction_amount"));
            if (array && array.length != 0) {
                $('#transactionId').val(array.transactionId);
                $('#sub_total').val(array.sub_total.toFixed(2));
            }
        }

        //client data validation
        function clientDataValidation() {
            let namecheck = $('#name').val();
            let payment_type = $('.payment_method:checked').val();
            console.log(payment_type);
            let pay_number = $('#payment_reference_number').val();
            let cheque_date = $('#cheque_issue_date').val();
            let nicRegex = /^([1-9]{1}[0-9]{8}[VvXx])|([1-9]{1}[0-9]{11})$/;
            let numberRegex =
                /^(([0]{1}[12345689]{1}[0-9]{1}[0-9]{7})|([0]{1}7{1}[0-8]{1}[0-9]{7})|(\+947{1}[0-8]{1}[0-9]{7})|(947{1}[0-8]{1}[0-9]{7}))$/;
            let nic = $('#nic').val();
            let number = $('#telephone').val();
            newPaymentAmountCal();
            singleTranAmount();

            if (!namecheck || namecheck.length == 0) {
                singleTranAmount();
                swal.fire(
                    "failed",
                    "Please enter industry name before payment!",
                    "warning"
                ).then(function() {
                    singleTranAmount();
                    newPaymentAmountCal();
                    calTax();
                });
                return false;
            } else if (nic.length != 0 && nicRegex.test(nic) == false) {
                singleTranAmount();
                swal.fire(
                    "failed",
                    "Please insert valid NIC number!",
                    "warning"
                ).then(function() {
                    singleTranAmount();
                    newPaymentAmountCal();
                    calTax();
                });
                return false;
            } else if (number.length != 0 && numberRegex.test(number) == false) {
                swal.fire(
                    "failed",
                    "Please insert valid telephone number!",
                    "warning"
                ).then(function() {
                    singleTranAmount();
                    newPaymentAmountCal();
                    calTax();
                });
                return false;
            } else if (payment_type == 'cheque') {
                if (!pay_number || pay_number.length == 0) {
                    swal.fire(
                        "failed",
                        "Please enter payment reference number!",
                        "warning"
                    ).then(function() {
                        singleTranAmount();
                        newPaymentAmountCal();
                        calTax();
                    });
                    return false;
                } else if (!cheque_date || cheque_date.length == 0) {
                    swal.fire(
                        "failed",
                        "Please enter cheque issue date!",
                        "warning"
                    ).then(function() {
                        singleTranAmount();
                        newPaymentAmountCal();
                        calTax();
                    });
                    return false;
                } else  {
                    return true;
                }
            } else {
                return true;
            }
        }

        function addPayment() {
            if (clientDataValidation() == true) {
                let data = {
                    name: $('#name').val(),
                    telephone: $('#telephone').val(),
                    nic: $('#nic').val(),
                    ind_address: $('#address').val(),
                    invoice_date: $('#invoice_date').val(),
                    payment_method: $('.payment_method:checked').val(),
                    payment_reference_number: $('#payment_reference_number').val(),
                    cheque_issue_date: $('#cheque_issue_date').val(),
                    remark: $('#remark').val(),
                    amount: $('#amount').val(),
                    sub_amount: $('#sub_total').val(),
                    vat: $('#vat').val(),
                    nbt: $('#nbt').val(),
                    transactionsId: $('#transactionId').val(),
                    tax_total: $('#tax_total').val(),
                };
                console.log(data);

                localStorage.setItem("invoice_details", JSON.stringify(data));

                let tranItems = JSON.parse(localStorage.getItem('new_application_transaction_items'));
                let invoiceDet = JSON.parse(localStorage.getItem('invoice_details'));
                let industryTransactions = JSON.parse(localStorage.getItem('industry_transactions'));

                let arrData = {
                    tranItems: tranItems,
                    invoiceDet: invoiceDet,
                    industryTransactions: industryTransactions,
                };

                ajaxRequest('post', '/cashier/invoice', arrData, function(response) {
                    if (response.status == 1) {
                        swal.fire(
                            "success",
                            "Invoice created successfully",
                            "success"
                        );
                        localStorage.removeItem('new_application_transaction_items');
                        localStorage.removeItem('invoice_details');
                        localStorage.removeItem('industry_transactions');
                        localStorage.removeItem('industry_items_id_list');
                        $("#industry_payments_tbl tfoot").html('');
                        selectedIndustryTransactionRecordsTbl();
                        generateNewApplicationTable();
                        clearClientDetails();

                        if (response.type != 'bulk') {
                            window.open('{{ route('print-invoice', '') }}/' + response.data.invoice_id);
                        } else {
                            window.open('{{ route('print-transactions-invoice', '') }}/' + response.data
                                .invoice_id);
                        }
                    } else {
                        swal.fire(
                            "failed",
                            "Invoice created unsuccessful! Please check details again",
                            "warning"
                        );
                    }
                });
            }
        }

        // pay button click event
        $(document).on('click', "#btn_pay", function(e) {
            addPayment();
            loadAllIndustryTransactionsTable();
            generateNewApplicationTable();
            $("#industry_payments_tbl tfoot").html('');
            selectedIndustryTransactionRecordsTbl();
        });


        //industry transaction cancel
        $(document).on('click', ".btn-cancel", function(e) {
            if (!confirm('Are you sure you want to cancel this transaction?')) {
                return false;
            }
            let id = $(this).data('invoice_id');
            var row = $(`tr[data-row_id=` + id + `]`);
            var url = "/cancel-transaction/" + id;

            ajaxRequest('post', url, null, function(response) {
                if (response.status == 1) {
                    swal.fire(
                        "success",
                        "Transaction cancelled!",
                        "success"
                    );
                    row.remove();
                } else {
                    swal.fire(
                        "failed",
                        "Transaction cancel unsuccessful!",
                        "warning"
                    );
                }
            });
        });

        function clearClientDetails() {
            $("#name, #nic, #telephone, #address, #cheque_issue_date, #payment_reference_number, #remark, #tax_total, #vat, #nbt")
                .val(
                    '');
            $("#invoice_date").val(new Date().toJSON().slice(0, 10));

            $('#name').prop("readonly", false);
            $('#nic').prop("readonly", false);
            $('#telephone').prop("readonly", false);
            $('#address').prop("readonly", false);

        }
        $(document).on('click', "#btn_clear_customer_data", function(e) {
            clearClientDetails();
        });

        $(function() {
            loadPaymentTypes(
                function() {
                    loadPaymentsByPaymentTypes(loadPaymentPrice)
                });
            generateNewApplicationTable();
            loadAllIndustryTransactionsTable();
            selectedIndustryTransactionRecordsTbl();
            loadAllIndustryTransactionsTbleToPay();
        });

        function calTax() {
            let sub_total = $('#sub_total').val();

            let net_tot = Number(sub_total);
            $('#amount').val(net_tot.toFixed(2));

            if ($('#tax_status :selected').val() == 'non-tax') {
                $('#vatField').addClass('d-none');
                $('#nbtField').addClass('d-none');
                $('#taxTotalField').addClass('d-none');

                let vat_tot = 0;
                let nbt_tot = 0;
                let taxTot = 0;
                $('#vat').val(vat_tot.toFixed(2));
                $('#nbt').val(nbt_tot.toFixed(2));
                $('#tax_total').val(taxTot.toFixed(2));
                $('#amount').val(net_tot.toFixed(2));
            } else {
                $('#vatField').removeClass('d-none');
                $('#nbtField').removeClass('d-none');
                $('#taxTotalField').removeClass('d-none');

                let vat_tot = sub_total * (vat / 100);
                let nbt_tot = sub_total * (nbt / 100);
                let taxTot = Number(vat_tot.toFixed(2)) + Number(nbt_tot.toFixed(2));
                let net_tot = Number(sub_total) + Number(vat_tot) + Number(nbt_tot);

                $('#vat').val(vat_tot.toFixed(2));
                $('#nbt').val(nbt_tot.toFixed(2));
                $('#tax_total').val(taxTot.toFixed(2));
                $('#amount').val(net_tot.toFixed(2));
            }

            $("#tax_status").change(function() {
                $vatStatus = $('#tax_status :selected').val();
                if ($vatStatus == 'tax') {
                    $('#vatField').removeClass('d-none');
                    $('#nbtField').removeClass('d-none');
                    $('#taxTotalField').removeClass('d-none');

                    let vat_tot = sub_total * (vat / 100);
                    let nbt_tot = sub_total * (nbt / 100);
                    let taxTot = Number(vat_tot.toFixed(2)) + Number(nbt_tot.toFixed(2));
                    let net_tot = Number(sub_total) + Number(vat_tot) + Number(nbt_tot);

                    $('#vat').val(vat_tot.toFixed(2));
                    $('#nbt').val(nbt_tot.toFixed(2));
                    $('#tax_total').val(taxTot.toFixed(2));
                    $('#amount').val(net_tot.toFixed(2));
                } else {
                    $('#vatField').addClass('d-none');
                    $('#nbtField').addClass('d-none');
                    $('#taxTotalField').addClass('d-none');

                    let vat_tot = 0;
                    let nbt_tot = 0;
                    let taxTot = 0;
                    $('#vat').val(vat_tot.toFixed(2));
                    $('#nbt').val(nbt_tot.toFixed(2));
                    $('#tax_total').val(taxTot.toFixed(2));
                    $('#amount').val(net_tot.toFixed(2));
                }
            });
        }

        $("#cash").change(function() {
            if ($(this).is(':checked')) {
                $('#paymentReferenceField').addClass('d-none');
                $('#chequeDateField').addClass('d-none');
            } else {
                $('#paymentReferenceField').removeClass('d-none');
                $('#chequeDateField').removeClass('d-none');
            }
        });

        $("#cheque").change(function() {
            if ($(this).is(':checked')) {
                $('#paymentReferenceField').removeClass('d-none');
                $('#chequeDateField').removeClass('d-none');
            } else {
                $('#paymentReferenceField').addClass('d-none');
                $('#chequeDateField').addClass('d-none');
            }
        });
    </script>
@endsection

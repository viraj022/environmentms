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
                                    aria-selected="true">Cashier</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile"
                                    aria-selected="false">Cashier 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-three-profile" role="tab"
                                    aria-controls="custom-tabs-three-profile" aria-selected="false">Cashier 3</a>
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
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                            </colgroup>
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Id</th>
                                                                    <th>Client Name</th>
                                                                    <th>Address</th>
                                                                    <th>Type</th>
                                                                    <th>Amount</th>
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
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                                <col style="width: 10%;">
                                                            </colgroup>
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Id</th>
                                                                    <th>Client Name</th>
                                                                    <th>Address</th>
                                                                    <th>Type</th>
                                                                    <th>Amount</th>
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
                                <div class="card">
                                    <div class="card-title text-center mt-2">
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <input type="text" hidden value="" id="transactionId">
                                            <input type="text" hidden value="{{ $vat->rate }}" id="vatValue">
                                            <input type="text" hidden value="{{ $nbt->rate }}" id="nbtValue">
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="name">Name</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="name" id="name"
                                                        class="form-control" required>
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
                                                    <label for="address">Industry Address</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="address" id="address"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="invoice_date">Date</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="date" name="invoice_date" id="invoice_date"
                                                        class="form-control" value="today()">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="payment_method">Payment Type</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <select class="form-select  form-control"
                                                        aria-label="Default select example" id="payment_method"
                                                        name="payment_method">
                                                        <option value="cash">Cash</option>
                                                        <option value="cheque">Cheque</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="payment_reference_number">Payment Reference
                                                        Number</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="payment_reference_number"
                                                        id="payment_reference_number" class="form-control">
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
                                        </form>
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
                                            <input type="text" name="sub_total" id="sub_total" class="form-control"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
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
                                    <div class="row mb-3">
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
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="tax_1">
                                                Tax 1
                                            </label>
                                        </div>
                                        <div class="col-lg-8 ">
                                            <input type="text" name="tax_1" id="tax_1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="tax_2">
                                                Tax 2
                                            </label>
                                        </div>
                                        <div class="col-lg-8 ">
                                            <input type="text" name="tax_2" id="tax_2" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="tax_total">
                                                Tax Total
                                            </label>
                                        </div>
                                        <div class="col-lg-8 ">
                                            <input type="text" name="tax_total" id="tax_total" class="form-control"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="total">
                                                Total
                                            </label>
                                        </div>
                                        <div class="col-lg-8 ">
                                            <input type="text" name="amount" id="amount" class="form-control"
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
    <script>
        let vat = Number($('#vatValue').val());
        let nbt = Number($('#nbtValue').val());

        //create new application payment table
        $(document).on('click', "#btn_add_new_application_payment", function() {
            var transactions = JSON.parse(localStorage.getItem("industry_transactions"));
            if (transactions && transactions.length != 0) {
                localStorage.setItem('industry_transactions', '[]'); // clear

                selectedIndustryTransactionRecordsTbl(); // clear table
            }

            // create if location storage key does not exists            
            if (!localStorage.getItem('new_application_transaction_items')) {
                localStorage.setItem('new_application_transaction_items', '[]');
            }

            // get the transaction items data from local storage
            let transactionItems = JSON.parse(localStorage.getItem('new_application_transaction_items'));

            transactionItems.push({
                payment_type: $('#payment_type').val(),
                payment_cat_name: $('#category option:selected').data('name'),
                amount: $('#price').val(),
                category_id: $('#category').val(),
                qty: $('#qty').val()
            });

            localStorage.setItem('new_application_transaction_items', JSON.stringify(transactionItems));

            // clear tfoot
            $("#industry_payments_tbl tfoot").html('');
            generateNewApplicationTable();
        });


        //generate payment table
        function generateNewApplicationTable() {
            let sub_total = 0;
            let i = 1;
            $("#new_application_payments_tbl tbody").html('');

            var array = JSON.parse(localStorage.getItem("new_application_transaction_items"));

            $.each(array, function(index, val) {
                if (val) {
                    if (val.category_id) {
                        $("#new_application_payments_tbl > tbody").append(`<tr><td>${i++}</td><td>${val.payment_cat_name}</td><td>${val.qty}</td>
                        <td>${val.amount}</td>
                        <td><button type="button" class="btn btn-sm btn-danger btn-delete" 
                            value=` + index + `>Delete</button></td></tr>`);
                    } else {
                        localStorage.setItem('new_application_transaction_items', '[]');
                        return false;
                    }
                }
                sub_total += Number(val.amount);

                $('#sub_total').val(sub_total.toFixed(2));
                let tax_1 = Number($('#tax_1').val());
                let tax_2 = Number($('#tax_2').val());

                calTax();

            });
        }

        $(document).on('click', ".btn-delete", function(e) {
            if (!confirm('Remove this item?')) {
                return false;
            }

            var items = JSON.parse(localStorage.getItem("new_application_transaction_items"));
            let rowVal = $(this).val();

            // remove the item at rowVal index
            items.splice(rowVal, 1);

            // set modified items back to the local storage
            localStorage.setItem("new_application_transaction_items", JSON.stringify(items));

            // re-generate the table
            generateNewApplicationTable();
        });


        function addPayment() {
            let namecheck = $('#name').val();
            if (!namecheck || namecheck.length == 0) {
                swal.fire(
                    "failed",
                    "Please enter client name before payment!",
                    "warning"
                );
                return false;
            } else {
                let data = {
                    name: $('#name').val(),
                    telephone: $('#telephone').val(),
                    nic: $('#nic').val(),
                    ind_address: $('#address').val(),
                    invoice_date: $('#invoice_date').val(),
                    payment_method: $('#payment_method').val(),
                    payment_reference_number: $('#payment_reference_number').val(),
                    remark: $('#remark').val(),
                    amount: $('#amount').val(),
                    sub_amount: $('#sub_total').val(),
                    vat: $('#vat').val(),
                    nbt: $('#nbt').val(),
                    transactionsId: $('#transactionId').val(),
                    tax_total: $('#tax_total').val(),
                };

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

        $(document).on('click', "#btn_pay", function(e) {
            addPayment();
            loadAllIndustryTransactionsTable();
            generateNewApplicationTable();
            $("#industry_payments_tbl tfoot").html('');
            selectedIndustryTransactionRecordsTbl();
        });

        //load all industry transaction records
        function loadAllIndustryTransactionsTable() {
            var url = "{{ route('load-transactions-table') }}";

            ajaxRequest("GET", url, null, function(response) {
                let tr = '';
                let i = 0;
                $.each(response, function(i, transaction) {
                    let type = transaction.type;
                    type = type.replace("_", " ");
                    type.charAt(0).toUpperCase();
                    type = type.charAt(0).toUpperCase() + type.slice(1);
                    tr += `<tr data-row_id = "${transaction.id}">
                        <td>${++i}</td>
                        <td>${transaction.id}</td>
                        <td data-transaction_name=${transaction.name}>${transaction.name}</td>
                        <td data-address="${transaction.address}">${transaction.address}</td>
                        <td>${type}</td>
                        <td data-net_total=${transaction.net_total}>${transaction.net_total}</td>
                        <td>
                            <button class ="btn btn-dark btn-xs btn-old-transaction-add" data-invoice_id=${transaction.id}> Add </button> <br>
                            <button class ="btn btn-info btn-xs btn-cancel mt-2" data-invoice_id=${transaction.id}> Cancel </button> 
                        </td>
                    </tr>`;

                    if ($('.btn-delete-invoice-gen[data-transaction_id]') == transaction.id) {
                        $('.btn-old-transaction-add[data-invoice_id=' + transaction.id + ']').prop(
                            'disabled', true);
                    }
                })
                $("#transactions_table > tbody").html(tr);
                console.log('hi');

                $('#transactions_table').DataTable();
            });
        }

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
                        "Transaction canceled!",
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

        //industry transaction add
        $(document).on('click', ".btn-old-transaction-add", function() {

            var newApplicationPayments = JSON.parse(localStorage.getItem("new_application_transaction_items"));
            if (newApplicationPayments && newApplicationPayments.length != 0) {
                localStorage.setItem('new_application_transaction_items', '[]'); // clear
                generateNewApplicationTable();
            }

            // create if location storage key does not exists            
            if (!localStorage.getItem('industry_transactions')) {
                localStorage.setItem('industry_transactions', '[]');
            }

            // get the transactions data from local storage
            let transactions = JSON.parse(localStorage.getItem('industry_transactions'));

            var currentRow = $(this).closest("tr");

            var transaction_id = currentRow.find("td:eq(1)").text();
            var name = currentRow.find("td:eq(2)").text();
            var type = currentRow.find("td:eq(4)").text();
            var amount = currentRow.find("td:eq(5)").text();

            transactions.push({
                id: transaction_id,
                name: name,
                total: amount,
            });

            localStorage.setItem('industry_transactions', JSON.stringify(transactions));
            $("#industry_payments_tbl tfoot").html('');
            selectedIndustryTransactionRecordsTbl();

            $(this).prop('disabled', true);
        });

        //load selected industry transactions table to generate invoice
        function selectedIndustryTransactionRecordsTbl() {
            let sub_total = 0;
            let i = 1;
            $("#industry_payments_tbl tbody").html('');

            var array = JSON.parse(localStorage.getItem("industry_transactions"));

            $.each(array, function(index, val) {
                if (val) {
                    $("#industry_payments_tbl > tbody").append(`<tr>
                    <td>${i++}</td><td>${val.id}</td><td>${val.name}</td>
                    <td>${val.total}</td>
                    <td><button type="button" class="btn btn-sm btn-danger btn-delete-invoice-gen" 
                        value=` + index + ` ` + `data-transaction_id=${val.id}` + `>Delete</button></td>
                    </tr>`);
                }
                sub_total += Number(val.total);
            });
            $("#industry_payments_tbl > tfoot").append(`<tr>
                <td colspan="3" style="text-align: center">Total</td>
                <td id="gene_total_amount">${sub_total}</td>
            </tr>`);
            console.log('hi');
            $('#sub_total').val(sub_total.toFixed(2));
            calTax();
        }

        //remove selected industry transaction record
        $(document).on('click', ".btn-delete-invoice-gen", function(e) {
            if (!confirm('Remove this item?')) {
                return false;
            }

            var transactions = JSON.parse(localStorage.getItem("industry_transactions"));
            let rowVal = $(this).val();
            let transactionId = $(this).data('transaction_id');
            $('.btn-old-transaction-add[data-invoice_id=' + transactionId + ']').prop('disabled', false);

            console.log('hi');

            transactions.splice(rowVal, 1);

            localStorage.setItem("industry_transactions", JSON.stringify(transactions));

            $("#industry_payments_tbl tfoot").html('');
            selectedIndustryTransactionRecordsTbl();
        });


        //load all industry transaction records to pay single transaction
        function loadAllIndustryTransactionsTbleToPay() {
            var url = "{{ route('load-transactions-table') }}";

            ajaxRequest("GET", url, null, function(response) {
                let tr = '';
                let i = 0;
                $.each(response, function(i, transaction) {
                    let type = transaction.type;
                    type = type.replace("_", " ");
                    type.charAt(0).toUpperCase();
                    type = type.charAt(0).toUpperCase() + type.slice(1)

                    tr += `<tr data-row_id = "${transaction.id}">
                        <td>${++i}</td>
                        <td>${transaction.id}</td>
                        <td>${transaction.name}</td>
                        <td>${transaction.address}</td>
                        <td>${type}</td>
                        <td>${transaction.net_total}</td>
                        <td>
                            <button class ="btn btn-danger btn-xs btn-old-transaction-pay" 
                            data-transaction_name=${transaction.name}
                            data-nic=${transaction.nic} 
                            data-contact_no=${transaction.contact_no} 
                            data-invoice_id=${transaction.id} 
                            data-net_total=${transaction.net_total}
                            data-address="${transaction.address}"> Pay </button> 
                            <br>
                            <button class ="btn btn-info btn-xs btn-cancel mt-2" data-invoice_id=${transaction.id}> Cancel </button> 
                        </td>
                    </tr>`;
                })
                $('#industry_tran_table > tbody').html(tr);
                $('#industry_tran_table').DataTable();
            });
        }

        $(document).on('click', ".btn-old-transaction-pay", function(e) {
            localStorage.setItem('new_application_transaction_items', '[]');
            generateNewApplicationTable();

            localStorage.setItem('industry_transactions', '[]');
            $("#industry_payments_tbl tfoot").html('');
            selectedIndustryTransactionRecordsTbl();

            let name = $(this).data('transaction_name');
            let nic = $(this).data('nic');
            let telephone = $(this).data('contact_no');
            let address = $(this).data('address');
            let sub_total = $(this).data('net_total');
            let transactionId = $(this).data('invoice_id');

            $('#name').val(name);
            $('#nic').val(nic);
            $('#telephone').val(telephone);
            $('#address').val(address);
            $('#sub_total').val(sub_total.toFixed(2));
            $('#transactionId').val(transactionId);

            calTax();
        });

        function clearClientDetails() {
            $("#name, #nic, #telephone, #address, #payment_reference_number, #remark, #tax_1, #tax_2, #tax_total").val(
                '');
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

            let tax_1 = $('#tax_1').val();
            let tax_2 = $('#tax_2').val();

            let vat_tot = sub_total * (vat / 100);
            let nbt_tot = sub_total * (nbt / 100);

            let net_tot = Number(sub_total) + Number(vat_tot) + Number(nbt_tot);

            if (tax_1 || tax_2) {
                let tax_1_tot = sub_total * (tax_1 / 100);
                let tax_2_tot = sub_total * (tax_2 / 100);

                let taxTot = Number(tax_1_tot.toFixed(2)) + Number(tax_2_tot.toFixed(2));
                net_tot = Number(sub_total) + Number(vat_tot) + Number(nbt_tot) + Number(tax_1_tot) + Number(tax_2_tot);
                $('#tax_total').val(taxTot.toFixed(2));
            }

            $('#vat').val(vat_tot.toFixed(2));
            $('#nbt').val(nbt_tot.toFixed(2));
            $('#amount').val(net_tot.toFixed(2));
        }
        $('#tax_1').change(calTax);
        $('#tax_2').change(calTax);
    </script>
@endsection

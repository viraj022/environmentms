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
                                                    <div class="card card-body" style="height: 400px; overflow-y:scroll">
                                                        <table class="table" id="transactions_table">
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
                                        <h5>Customer Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="row mb-3">
                                                <div class="col-lg-4">
                                                    <label for="name">Name</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="name" id="name"
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
                                                        class="form-control">
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
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="total">
                                                Total
                                            </label>
                                        </div>
                                        <div class="col-lg-8 ">
                                            <input type="text" name="amount" id="amount" class="form-control">
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
    <script>
        //load payment types
        function loadPaymentTypes(callback) {
            ajaxRequest('get', '/cashier/payment_types', null, function(response) {
                let options = '';

                $.each(response, function(index, value) {
                    options += `<option value="` + value.id + `">` + value.name + `</option>`;
                })
                $('#payment_type').html(options);

                if (typeof callback == 'function') {
                    callback();
                }
            });
        }

        //load payments by payment type
        function loadPaymentsByPaymentTypes(callback) {
            let payment_type = $('#payment_type').val();

            ajaxRequest('get', '/cashier/payments-by-type/' + payment_type, null, function(response) {
                let options = '';

                $.each(response, function(index, value) {
                    options +=
                        `<option value="${value.id}" data-price="${value.amount}" data-name="${value.name}"> ${value.name} </option>`;
                })
                $('#category').html(options);

                if (typeof callback == 'function') {
                    callback();
                }
            });
        }

        //load payment price by payments
        function loadPaymentPrice() {
            let price = $('#category option:selected').data('price');
            $('#price').val(price);
        }

        $('#payment_type').change(loadPaymentsByPaymentTypes);
        $('#category').change(loadPaymentPrice);

        //get total amount
        function total() {
            let price = $('#category option:selected').data('price');
            let total = price * $('#qty').val();
            $('#price').val(total.toFixed(2));
        }

        $('#qty').change(total);


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

            generateNewApplicationTable();
        });


        //generate payment table
        function generateNewApplicationTable() {
            let total = 0;
            let i = 1;
            $("#new_application_payments_tbl tbody").html('');

            var array = JSON.parse(localStorage.getItem("new_application_transaction_items"));

            $.each(array, function(index, val) {
                if (val) {
                    $("#new_application_payments_tbl > tbody").append(`<tr><td>${i++}</td><td>${val.payment_cat_name}</td><td>${val.qty}</td>
                    <td>${val.amount}</td>
                    <td><button type="button" class="btn btn-sm btn-danger btn-delete" 
                        value=` + index + `>Delete</button></td></tr>`);
                }
                total += Number(val.amount);

                $('#amount').val(total.toFixed(2));
            });

            // let newTotal = array.reduce((a,b) => Number(a.amount)+Number(b.amount));

            // console.log(`total is ${total}`);
            // console.log(`new total is ${newTotal}`);
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
            let data = {
                name: $('#name').val(),
                telephone: $('#telephone').val(),
                nic: $('#nic').val(),
                invoice_date: $('#invoice_date').val(),
                payment_method: $('#payment_method').val(),
                payment_reference_number: $('#payment_reference_number').val(),
                remark: $('#remark').val(),
                amount: $('#amount').val(),
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

                    window.open('{{ route('print-invoice', '') }}/' + response.data.invoice_id);
                } else {
                    swal.fire(
                        "failed",
                        "Invoice created unsuccessful! Please check details again",
                        "warning"
                    );
                }
            });
        }

        $(document).on('click', "#btn_pay", function(e) {
            addPayment();
            loadAllIndustryTransactionsTable();
            generateNewApplicationTable();
            selectedIndustryTransactionRecordsTbl();
        });

        //load all industry transaction records
        function loadAllIndustryTransactionsTable() {
            var url = "{{ route('load-transactions-table') }}";

            ajaxRequest("GET", url, null, function(response) {
                let tr = '';
                let i = 0;
                $.each(response, function(i, transaction) {
                    tr += `<tr data-row_id = "${transaction.id}">
                        <td>${++i}</td>
                        <td>${transaction.id}</td>
                        <td data-transaction_name=${transaction.name}>${transaction.name}</td>
                        <td data-net_total=${transaction.net_total}>${transaction.net_total}</td>
                        <td>
                            <button class ="btn btn-dark btn-sm btn-old-transaction-add" data-invoice_id=${transaction.id}> Add </button> <br>
                            <button class ="btn btn-info btn-sm btn-cancel mt-2" data-invoice_id=${transaction.id}> Cancel </button> 
                        </td>
                    </tr>`;
                })
                $("#transactions_table > tbody").html(tr);
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
            var amount = currentRow.find("td:eq(3)").text();

            transactions.push({
                id: transaction_id,
                name: name,
                total: amount,
            });

            localStorage.setItem('industry_transactions', JSON.stringify(transactions));
            $("#industry_payments_tbl tfoot").html('');
            selectedIndustryTransactionRecordsTbl();
        });

        //load selected industry transactions table to generate invoice
        function selectedIndustryTransactionRecordsTbl() {
            let total = 0;
            let i = 1;
            $("#industry_payments_tbl tbody").html('');

            var array = JSON.parse(localStorage.getItem("industry_transactions"));

            $.each(array, function(index, val) {
                if (val) {
                    $("#industry_payments_tbl > tbody").append(`<tr>
                    <td>${i++}</td><td>${val.id}</td><td>${val.name}</td>
                    <td>${val.total}</td>
                    <td><button type="button" class="btn btn-sm btn-danger btn-delete-invoice-gen" 
                        value=` + index + `>Delete</button></td>
                    </tr>`);
                }
                total += Number(val.total);

            });
            $("#industry_payments_tbl > tfoot").append(`<tr>
                <td colspan="3" style="text-align: center">Total</td>
                <td id="gene_total_amount">${total}</td>
            </tr>`);

            $('#amount').val(total.toFixed(2));

            // clear tfoot
            //$("#industry_payments_tbl tfoot").html('');
        }

        //remove selected industry transaction record
        $(document).on('click', ".btn-delete-invoice-gen", function(e) {
            if (!confirm('Remove this item?')) {
                return false;
            }

            var transactions = JSON.parse(localStorage.getItem("industry_transactions"));
            let rowVal = $(this).val();

            transactions.splice(rowVal, 1);

            localStorage.setItem("industry_transactions", JSON.stringify(transactions));

            $("#industry_payments_tbl tfoot").html('');
            selectedIndustryTransactionRecordsTbl();
        });

        $(function() {
            loadPaymentTypes(
                function() {
                    loadPaymentsByPaymentTypes(loadPaymentPrice)
                });
            generateNewApplicationTable();
            loadAllIndustryTransactionsTable();
            selectedIndustryTransactionRecordsTbl();
        });
    </script>
@endsection

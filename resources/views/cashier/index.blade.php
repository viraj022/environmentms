@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-3">Cashier</h1>
                    <div class="row">
                        <div class="col-lg-6">
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
                                            <select class="form-select form-control" aria-label="Default select example"
                                                id="payment_type" name="payment_type">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="category">Category</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-select form-control" aria-label="Default select example"
                                                id="category" name="category">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="qty">Quantity</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="number" name="qty" id="qty" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="price">Amount</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="number" name="price" id="price" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-sm btn-dark" type="button"
                                            id="btn_add_to_payments">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card  mt-3">
                                <div class="card-header bg-secondary">
                                    <h6 class="card-title">Payment Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered " id="payments_tbl">
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
                        <div class="col-lg-6">
                            <div class="card card-body">
                                <form action="" method="post">
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="name" id="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="nic">NIC</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="nic" id="nic" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="telephone">Contact</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="telephone" id="telephone" class="form-control">
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
                                            <select class="form-select  form-control" aria-label="Default select example"
                                                id="payment_method" name="payment_method">
                                                <option value="cash">Cash</option>
                                                <option value="cheque">Cheque</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="payment_reference_number">Payment Reference Number</label>
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
                                            <input type="text" name="remark" id="remark" class="form-control">
                                        </div>
                                    </div>
                                </form>
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
                                    <button class="btn btn-danger btn-sm mx-1" type="button" id="btn_pay">Pay</button>
                                    <button class="btn btn-sm btn-success" type="button"
                                        id="btn_clear_customer_data">Clear</button>
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

        $(function() {
            loadPaymentTypes(
                function() {
                    loadPaymentsByPaymentTypes(loadPaymentPrice)
                });
            generateTable();
        });


        $('#payment_type').change(loadPaymentsByPaymentTypes);

        $('#category').change(loadPaymentPrice);

        //get total amount
        function total() {
            let price = $('#category option:selected').data('price');
            let total = price * $('#qty').val();
            $('#price').val(total);
        }

        $('#qty').change(total);


        //create payment table
        $(document).on('click', "#btn_add_to_payments", function() {
            // create if location storage key does not exists            
            if (!localStorage.getItem('transaction_items')) {
                localStorage.setItem('transaction_items', '[]');
            }

            // get the transaction items data from local storage
            let transactionItems = JSON.parse(localStorage.getItem('transaction_items'));

            transactionItems.push({
                payment_type: $('#payment_type').val(),
                payment_cat_name: $('#category option:selected').data('name'),
                amount: $('#price').val(),
                category_id: $('#category').val(),
                qty: $('#qty').val()
            });

            localStorage.setItem('transaction_items', JSON.stringify(transactionItems));

            generateTable();
        });


        function generateTable() {
            let total = 0;
            let i = 1;
            $("#payments_tbl tbody").html('');

            var array = JSON.parse(localStorage.getItem("transaction_items"));

            $.each(array, function(index, val) {
                if (val) {
                    $("#payments_tbl > tbody").append(`<tr><td>${i++}</td><td>${val.payment_cat_name}</td><td>${val.qty}</td>
                    <td>${val.amount}</td>
                    <td><button type="button" class="btn btn-sm btn-danger btn-delete" 
                        value=` + index +`>Delete</button></td></tr>`);
                }
                total += Number(val.amount);

                $('#amount').val(total.toFixed(2));
            });

            // let newTotal = array.reduce((a,b) => Number(a.amount)+Number(b.amount));

            // console.log(`total is ${total}`);
            // console.log(`new total is ${newTotal}`);
        }

        $(document).on('click', ".btn-delete", function(e) {
            if(!confirm('Remove this item?')) {
                return false;
            }

            var items = JSON.parse(localStorage.getItem("transaction_items"));
            let rowVal = $(this).val();
            
            // remove the item at rowVal index
            items.splice(rowVal, 1);
            
            // set modified items back to the local storage
            localStorage.setItem("transaction_items", JSON.stringify(items));

            // re-generate the table
            generateTable();
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

            let tranItems = JSON.parse(window.localStorage.getItem('transaction_items'));
            let invoiceDet = JSON.parse(window.localStorage.getItem('invoice_details'));

            let arrData = {
                tranItems: tranItems,
                invoiceDet: invoiceDet,
            };
            ajaxRequest('post', '/cashier/invoice', arrData , function(response) {
                console.log(arrData);
                if (typeof callback == 'function') {
                    callback();
                }
            });
        }

        $(document).on('click', "#btn_pay", function(e) {
            addPayment();
        });
    </script>
@endsection

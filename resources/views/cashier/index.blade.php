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
                                    <form action="" method="post">
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="Payment_type">Payment Type</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="Payment_type" id="Payment_type"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <label for="category">Category</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" name="category" id="category" class="form-control">
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
                                                <label for="amount">Amount</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="number" name="amount" id="amount" class="form-control">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button class="btn btn-sm btn-success mx-1" type="button"
                                            id="btn_new_invoice">New</button>
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
                                                <th class="" style="width:10%;"><span
                                                        class=" badge bg-danger">-</span></th>
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
                                            <label for="nic">NIC</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="nic" id="nic" class="form-control">
                                        </div>
                                    </div>
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
                                            <label for="telephone">Contact</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="telephone" id="telephone" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="date">Date</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="date" name="date" id="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <label for="payment_type">Payment Type</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select class="form-select  form-control" aria-label="Default select example">
                                                <option value="cash">Cash</option>
                                                <option value="cheque">Cheque</option>
                                              </select>
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
                                <div class="row" >
                                    <div class="col-lg-4">
                                        <label for="total">
                                           Total
                                        </label>
                                    </div>
                                    <div class="col-lg-8 ">
                                        <input type="text" name="total" id="total" class="form-control">
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

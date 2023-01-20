@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Invoice View</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        Amount- {{ number_format($invoice->amount, 2) }}
                        <div class="card-title">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $invoice->name }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="nic">NIC</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="nic" id="nic" class="form-control"
                                    value="{{ $invoice->nic }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="telephone">Contact</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="telephone" id="telephone" class="form-control"
                                    value="{{ $invoice->telephone }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="invoice_date">Date</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="invoice_date" id="invoice_date" class="form-control"
                                    value="{{ Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="payment_method">Payment Type</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="payment_method" id="payment_method" class="form-control"
                                    value="{{ $invoice->payment_method }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="payment_reference_number">Payment Reference
                                    Number</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="payment_reference_number" id="payment_reference_number"
                                    class="form-control" value="{{ $invoice->payment_reference_number }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="remark">Remark</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" name="remark" id="remark" class="form-control"
                                    value="{{ $invoice->remark }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        Payment Details
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Payment Type</th>
                                    <th>Payment Name</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $transTotal = 0;
                                @endphp
                                @foreach ($transactionItems as $transactionItem)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transactionItem->paymentType->name }}</td>
                                        <td>{{ $transactionItem->payment->name }}</td>
                                        <td>{{ $transactionItem->qty }}</td>
                                        <td>{{ number_format($transactionItem->amount, 2) }}</td>
                                        @php
                                            $transTotal += $transactionItem->amount;
                                        @endphp
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="4" style="text-align: center;">Total</td>
                                <td>
                                    {{ number_format($transTotal, 2) }}
                                </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
    </section>
@endsection

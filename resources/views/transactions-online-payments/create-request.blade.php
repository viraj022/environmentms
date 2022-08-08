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
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Create Online Payment Request</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card border border-info">
                        <div class="card-header bg-info">Client Details</div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <colgroup>
                                    <col style="width: 40%;">
                                    <col style="width: 60%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>
                                            {{ sprintf('%s. %s %s', $client->name_title, $client->first_name, $client->last_name) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $client->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact No</th>
                                        <td>{{ $client->contact_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $client->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>N.I.C./S.L.I.C. No.</th>
                                        <td>{{ $client->nic ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Name</th>
                                        <td>{{ $client->industry_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Registration No.</th>
                                        <td>{{ $client->industry_registration_no ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pradeshiya Sabha Name</th>
                                        <td>{{ $client->pradesheeyasaba->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Industry Category</th>
                                        <td>{{ $client->industryCategory->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Scale</th>
                                        <td>{{ $client->businessScale->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Industry Investment</th>
                                        <td>{{ $client->industry_investment }}</td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td>{{ Carbon\Carbon::parse($client->industry_start_date)->format('Y-m-d') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border border-primary">
                        <div class="card-header bg-primary">Transaction Details</div>
                        <div class="card-body">
                            <h3 class="card-title mb-3">Summary</h3>
                            <table class="table table-striped table-hover table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Invoice No.</th>
                                        <td>{{ $transaction->invoice_no ?? 'Unavailable' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cashier</th>
                                        <td>{{ $transaction->cashier_name ?? 'Unavailable' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $transactionStatuses[$transaction->status] }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h3 class="card-title my-3">Payable Items</h3>
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Payment Type</th>
                                        <th>Payment</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $trTotal = 0.0;
                                    @endphp
                                    @foreach ($transaction->transactionItems as $trItem)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $trItem->paymentType->name }}</td>
                                            <td>{{ $trItem->payment->name }}</td>
                                            <td class="text-right">{{ number_format($trItem->amount, 2) }}</td>
                                        </tr>

                                        @php
                                            $trTotal += doubleval($trItem->amount);
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <th colspan="3">Total Payable</th>
                                        <th class="text-right">{{ number_format($trTotal, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('transactions.payment.send-link', $transaction->id) }}" method="post">
                                @csrf

                                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                <input type="hidden" name="payment_amount" value="{{ doubleval($trTotal) }}">

                                <button type="submit" class="btn btn-success">Send online payment link</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
    <!-- Page scripts -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        $(function() {

        });
    </script>
@endsection

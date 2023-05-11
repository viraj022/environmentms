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
                    <h1>Online Payments Report</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6">
                <div class="card border border-primary">
                    <div class="card-header bg-primary">
                        Generate Income Report
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="date" name="start_date" id="start_date" class="form-control" aria-label=""
                                    aria-describedby="button-addon2"
                                    value="{{ isset($start_date) ? $start_date : date('Y-m-d') }}">
                                <input type="date" name="end_date" id="end_date" class="form-control" aria-label=""
                                    aria-describedby="button-addon3"
                                    value="{{ isset($end_date) ? $end_date : date('Y-m-d') }}">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if (!empty($invoices))
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="onlinePaymentIncomeTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th>Date</th>
                                        <th>Reference Number</th>
                                        <th>Invoice Number</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @forelse ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $invoice->name }}</td>
                                            <td>{{ $invoice->invoice_date }}</td>
                                            <td>{{ $invoice->onlinePayment->reference_no }}</td>
                                            <td>{{ $invoice->invoice_number }}</td>
                                            <td>{{ number_format($invoice->amount, 2, '.', '') }}</td>
                                            @php
                                                $total += $invoice->amount;
                                            @endphp
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Data Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <td colspan="5" style="text-align: center;">Total</td>
                                    <td>
                                        {{ number_format($total, 2, '.', '') }}
                                    </td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script type="text/javascript" src="/dataTable/datatables.min.js"></script>
<script type="text/javascript" src="/dataTable/Buttons-1.6.5/dataTables.buttons.min.js"></script>
    <script>
        let sDate = $('#start_date').val();
        let eDate = $('#end_date').val();

        $(document).ready(function() {
            $('#onlinePaymentIncomeTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'print',
                    messageTop: `<h4>${sDate} To ${eDate}</h4>`,
                    title: 'Online Payment Income Report',
                }, "excel"],
            });
        });
    </script>
@endsection

@section('pageStyles')
<link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="/dataTable/Buttons-1.6.5/css/buttons.dataTables.min.css"/>
@endsection

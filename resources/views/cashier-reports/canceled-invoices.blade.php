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
                    <h1>Canceled Invoice List</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-body border border-primary">
                    <form action="{{ route('canceled-invoice-list-by-date') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="date" name="start_date" id="start_date" class="form-control" aria-label=""
                                aria-describedby="button-addon2"
                                value="{{ isset($start_date) ? $start_date : date('Y-m-d') }}">
                            <input type="date" name="end_date" id="end_date" class="form-control" aria-label=""
                                aria-describedby="button-addon3" value="{{ isset($end_date) ? $end_date : date('Y-m-d') }}">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            @if (empty($canceledInvoices))
                <div class="col-lg-12">
                    <div class="card crad-body">
                        <div class="alert alert-info">
                            Please search a date to view canceled invoices.
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" id="canceledInvoiceTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Invoice Date</th>
                                        <th>Canceled Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($canceledInvoices as $invoice)
                                        <tr data-row_id={{ $invoice->id }}>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $invoice->name }}</td>
                                            <td>{{ $invoice->address }}</td>
                                            <td>{{ $invoice->invoice_date }}</td>
                                            <td>{{ $invoice->canceled_at }}</td>
                                            <td>{{ number_format($invoice->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('#canceledInvoiceTable').DataTable();
        });
    </script>
@endsection

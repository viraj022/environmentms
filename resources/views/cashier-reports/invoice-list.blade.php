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
                    <h1>Invoice List</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-body border border-primary">
                    <form action="{{ route('invoice-list-by-date') }}" method="post">
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
        </div>
        <div class="row">
            @if (empty($invoices))
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-info">
                                Please search a date to view invoices.
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" id="invoicesTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice Number</th>
                                        <th>Industry Name</th>
                                        <th>Industry Address</th>
                                        <th>NIC</th>
                                        <th>Invoice Date</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr data-row_id={{ $invoice->id }}>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $invoice->invoice_number }}</td>
                                            <td>{{ $invoice->name }}</td>
                                            <td>{{ $invoice->address }}</td>
                                            <td>{{ $invoice->nic }}</td>
                                            <td>{{ $invoice->invoice_date }}</td>
                                            <td>Rs.{{ number_format($invoice->amount, 2) }}</td>
                                            <td>
                                                <a href="{{ route('print-invoice', $invoice->id) }}"
                                                    class="btn btn-sm btn-success" target="_blank">Print</a>
                                                <button type="button" class="btn btn-info btn-sm btn-cancel"
                                                    data-invoice_id={{ $invoice->id }}>
                                                    Cancel
                                                </button>
                                            </td>
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
            $('#invoicesTable').DataTable();
        });

        $(document).on('click', ".btn-cancel", function(e) {
            if (!confirm('Are you sure you want to cancel this invoice?')) {
                return false;
            }
            let invoice_id = $(this).data('invoice_id');
            let url = '/cancel-invoice/' + invoice_id;
            var currentRow = $(this).closest("tr");

            ajaxRequest('post', url, null, function(response) {
                if (response.status == 1) {
                    swal.fire(
                        "success",
                        "Invoice cancelled successfully",
                        "success"
                    );
                    currentRow.remove();
                } else {
                    swal.fire(
                        "failed",
                        "Invoice cancelled unsuccessful!",
                        "warning"
                    );
                }
            });
        });
    </script>
@endsection

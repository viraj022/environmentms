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
                    <h1>Add Invoice to Client</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header">
        <div class="row">
            <div class="col-lg-4">
                <div class="card border border-primary">
                    <div class="card-header bg-primary">
                        Client Details
                    </div>
                    <div class="card-body">
                        <table class="table border">
                            <tr>
                                <th>Client Name</th>
                                <td>{{ $client->name_title }}. {{ $client->first_name }} {{ $client->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Client Address</th>
                                <td>{{ $client->address }}</td>
                            </tr>
                            <tr>
                                <th>Industry Name</th>
                                <td>{{ $client->industry_name }}</td>
                            </tr>
                            <tr>
                                <th>Industry Address</th>
                                <td>{{ $client->industry_address }}</td>
                            </tr>
                            <tr>
                                <th>File No</th>
                                <td>{{ $client->file_no }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card border border-secondary">
                    <div class="card-header bg-secondary">
                        Send Online Payment Request
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-body">
                    <table class="table border" id="invoiceTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice Number</th>
                                <th>Invoice Name</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ $invoice->name }}</td>
                                    <td>{{ number_format($invoice->amount, 2) }}</td>
                                    <td>
                                        <form action="{{ route('set-payment-to-client', [$client->id, $invoice->id]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">Set Payment</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script>
        @if (session('payment_set'))
            Swal.fire('Success', '{{ session('payment_set') }}', 'success');
        @endif
        $(document).ready(function() {
            $('#invoiceTable').DataTable();
        });
    </script>
@endsection

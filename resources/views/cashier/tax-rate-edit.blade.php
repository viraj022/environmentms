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
                    <h1>Tax Rates</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content-header">
        <div class="row">
            <div class="col-lg-4">
                <form action="{{ route('change-tax-rate') }}" method="post">
                    @csrf
                    <div class="card border border-primary">
                        <div class="card-header bg-primary">
                            Edit Tax Rate
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="tax_type">Tax Type</label>
                                <select name="tax_type" id="tax_type" class="form-control">
                                    @foreach ($taxes as $tax)
                                        <option value="{{ $tax->id }}" data-rate="{{ $tax->rate }}">
                                            {{ $tax->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tax_rate">Tax Rate</label>
                                <input type="text" name="tax_rate" id="tax_rate" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Change Rate Value</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="card card-body border border-primary">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taxes as $tax)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tax->name }}</td>
                                    <td>{{ $tax->rate }}</td>
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
        function setTaxRate() {
            let rate = $("#tax_type option:selected").data("rate");
            $('#tax_rate').val(rate);
        }

        $('#tax_type').change(setTaxRate);

        $(function() {
            setTaxRate();
        });
    </script>
@endsection

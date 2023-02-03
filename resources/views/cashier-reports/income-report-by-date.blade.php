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
                    <h1>Income Report</h1>
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
                        <form action="{{ route('income-report-by-date-new') }}" method="post">
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
        </div>
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

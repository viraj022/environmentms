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
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>New Application Request Details</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card border border-primary">
                        <div class="card-header bg-primary">
                            <strong>Client Details</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped m-0">
                                <colgroup>
                                    <col style="width: 50%;">
                                    <col style="width: 50%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $newApplication->title }} {{ $newApplication->firstname }}
                                            {{ $newApplication->lastname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $newApplication->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile Number</th>
                                        <td>{{ $newApplication->mobile_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email Address</th>
                                        <td>{{ $newApplication->email_address }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card border border-success">
                        <div class="card-header bg-success">
                            <strong>Industry Details</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped m-0">
                                <colgroup>
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>Pradeshiya Sabha</th>
                                        <td>{{ $newApplication->pradeshiyaSabha->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Industry Category</th>
                                        <td>{{ $newApplication->industryCategory->name }} -
                                            {{ $newApplication->industryCategory->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Scale</th>
                                        <td>{{ $businessScales[$newApplication->business_scale] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Industry Sub-category</th>
                                        <td>{{ $newApplication->industry_sub_category }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Registration Number</th>
                                        <td>{{ $newApplication->business_registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Name</th>
                                        <td>{{ $newApplication->business_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Is in industry zone?</th>
                                        <td>{{ $newApplication->is_in_industry_zone ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Investment Amount</th>
                                        <td>{{ number_format(doubleval($newApplication->investment_amount), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Industry Address</th>
                                        <td>{{ $newApplication->industry_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td>{{ $newApplication->start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Submitted Date</th>
                                        <td>{{ $newApplication->submitted_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Number</th>
                                        <td>{{ $newApplication->industry_contact_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email Address</th>
                                        <td>{{ $newApplication->industry_email_address }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <form action="{{ route('client-space') }}" method="post">
                        @csrf

                        <input type="hidden" name="new_application_request" value="{{ $newApplication->id }}">

                        <button type="submit" class="btn btn-success">Send to create new industry profile</button>
                    </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script>
        $(function() {
            // init clipboard
            new ClipboardJS('.btn');
        });
    </script>
@endsection

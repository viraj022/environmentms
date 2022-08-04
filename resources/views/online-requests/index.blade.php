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
                    <h1>Online Requests</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-renewals-tab" data-toggle="pill" href="#pills-renewals"
                                role="tab" aria-controls="pills-renewals" aria-selected="true">Renewals</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-new-applications-tab" data-toggle="pill"
                                href="#pills-new-applications" role="tab" aria-controls="pills-new-applications"
                                aria-selected="false">New Applications</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-renewals" role="tabpanel"
                            aria-labelledby="pills-renewals-tab">
                            <table class="table table-striped table-condensed table-hover" id="renewals_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Renewal Type</th>
                                        <th>Certificate/License No.</th>
                                        <th>Person Name</th>
                                        <th>Industry Name</th>
                                        <th>Business Reg. No.</th>
                                        <th>Contact No.</th>
                                        <th>Mobile No.</th>
                                        <th>Email</th>
                                        <th>Attachment</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($renewalApplications as $renewal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $renewal->renewal_type)) }}</td>
                                            <td>{{ $renewal->certificate_number }}</td>
                                            <td>{{ $renewal->person_name }}</td>
                                            <td>{{ $renewal->industry_name }}</td>
                                            <td>{{ $renewal->business_registration_no }}</td>
                                            <td>{{ $renewal->contact_no }}</td>
                                            <td>{{ $renewal->mobile_no }}</td>
                                            <td>{{ $renewal->email }}</td>
                                            <td>
                                                <a href="{{ route('online-requests.renewal.view-attachment', $renewal) }}"
                                                    target="_blank">View
                                                    File</a>
                                            </td>
                                            <td>{{ ucwords(str_replace('_', ' ', $renewal->status)) }}</td>
                                            <td>
                                                <a href="{{ route('online-requests.renewal.view', $renewal->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <span class="fa fa-eye"></span> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12">No renewal requests received.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-new-applications" role="tabpanel"
                            aria-labelledby="pills-new-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover" id="new-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Pradeshiya Sabha</th>
                                            <th>Industry Category</th>
                                            <th>Business Scale</th>
                                            <th>Industry Sub Category</th>
                                            <th>Business Name</th>
                                            <th>Start Date</th>
                                            <th>Submitted Date</th>
                                            <th>Industry Contact No</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($newApplications as $new)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $new->title }} {{ $new->firstname }} {{ $new->lastname }}
                                                    <br />
                                                    {{ $new->mobile_number }}
                                                </td>
                                                <td>{{ $new->pradeshiyaSabha->name }}</td>
                                                <td>{{ $new->industryCategory->name }}</td>
                                                <td>{{ $businessScales[$new->business_scale] }}</td>
                                                <td>{{ $new->industry_sub_category }}</td>
                                                <td>{{ $new->business_name }}
                                                    <br />Reg. No.: {{ $new->business_registration_number }}
                                                </td>
                                                <td>{{ $new->start_date }}</td>
                                                <td>{{ $new->submitted_date }}</td>
                                                <td>{{ $new->industry_contact_no }}</td>
                                                <td>{{ $new->status }}</td>
                                                <td>
                                                    <a href="{{ route('online-requests.new-application.view', $new) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <span class="fa fa-eye"></span> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12">No new application requests received.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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
